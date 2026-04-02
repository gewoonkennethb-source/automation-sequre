<?php
/**
 * Automation SeQure — Database Layer
 *
 * SQLite database voor boekingen met versleutelde klantgegevens.
 * AVG/GDPR-compliant: encryptie at rest, data minimalisatie, retentiebeleid.
 */

require_once __DIR__ . '/config.php';

class BookingDatabase {
    private $db;

    public function __construct() {
        $dbDir = dirname(DB_PATH);
        if (!is_dir($dbDir)) {
            mkdir($dbDir, 0750, true);
        }

        $this->db = new SQLite3(DB_PATH);
        $this->db->busyTimeout(5000);
        $this->db->exec('PRAGMA journal_mode = WAL');
        $this->db->exec('PRAGMA foreign_keys = ON');

        $this->createTables();
        $this->cleanExpiredData();
    }

    /**
     * Create tables if they don't exist
     */
    private function createTables() {
        // Bookings table: date/time in plain text (needed for queries),
        // personal data encrypted
        $this->db->exec("
            CREATE TABLE IF NOT EXISTS bookings (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                booking_date TEXT NOT NULL,
                booking_time TEXT NOT NULL,
                encrypted_data TEXT NOT NULL,
                data_hash TEXT NOT NULL,
                consent_given INTEGER NOT NULL DEFAULT 0,
                consent_timestamp TEXT,
                ip_address_hash TEXT,
                created_at TEXT NOT NULL DEFAULT (datetime('now', 'localtime')),
                expires_at TEXT NOT NULL,
                status TEXT NOT NULL DEFAULT 'confirmed',
                UNIQUE(booking_date, booking_time, status)
            )
        ");

        // Audit log for AVG compliance (who accessed/modified data)
        $this->db->exec("
            CREATE TABLE IF NOT EXISTS audit_log (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                action TEXT NOT NULL,
                booking_id INTEGER,
                details TEXT,
                ip_address_hash TEXT,
                created_at TEXT NOT NULL DEFAULT (datetime('now', 'localtime'))
            )
        ");

        // Data deletion requests (right to be forgotten)
        $this->db->exec("
            CREATE TABLE IF NOT EXISTS deletion_requests (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                email_hash TEXT NOT NULL,
                requested_at TEXT NOT NULL DEFAULT (datetime('now', 'localtime')),
                processed_at TEXT,
                status TEXT NOT NULL DEFAULT 'pending'
            )
        ");
    }

    /**
     * Encrypt personal data using AES-256-GCM
     */
    private function encrypt($data) {
        $key = hex2bin(substr(hash('sha256', ENCRYPTION_KEY), 0, 64));
        $iv = random_bytes(12);
        $tag = '';

        $encrypted = openssl_encrypt(
            json_encode($data),
            'aes-256-gcm',
            $key,
            OPENSSL_RAW_DATA,
            $iv,
            $tag
        );

        return base64_encode($iv . $tag . $encrypted);
    }

    /**
     * Decrypt personal data
     */
    private function decrypt($encryptedData) {
        $key = hex2bin(substr(hash('sha256', ENCRYPTION_KEY), 0, 64));
        $decoded = base64_decode($encryptedData);

        $iv = substr($decoded, 0, 12);
        $tag = substr($decoded, 12, 16);
        $ciphertext = substr($decoded, 28);

        $decrypted = openssl_decrypt(
            $ciphertext,
            'aes-256-gcm',
            $key,
            OPENSSL_RAW_DATA,
            $iv,
            $tag
        );

        return $decrypted ? json_decode($decrypted, true) : null;
    }

    /**
     * Hash email for lookups (without storing plaintext)
     */
    private function hashEmail($email) {
        return hash('sha256', strtolower(trim($email)) . ENCRYPTION_KEY);
    }

    /**
     * Check if a timeslot is available
     */
    public function isSlotAvailable($date, $time) {
        $stmt = $this->db->prepare(
            "SELECT COUNT(*) as cnt FROM bookings
             WHERE booking_date = :date AND booking_time = :time
             AND status = 'confirmed'"
        );
        $stmt->bindValue(':date', $date, SQLITE3_TEXT);
        $stmt->bindValue(':time', $time, SQLITE3_TEXT);
        $result = $stmt->execute()->fetchArray(SQLITE3_ASSOC);

        return ($result['cnt'] == 0);
    }

    /**
     * Get all booked slots for a specific date
     */
    public function getBookedSlots($date) {
        $stmt = $this->db->prepare(
            "SELECT booking_time FROM bookings
             WHERE booking_date = :date AND status = 'confirmed'
             ORDER BY booking_time"
        );
        $stmt->bindValue(':date', $date, SQLITE3_TEXT);
        $result = $stmt->execute();

        $slots = [];
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $slots[] = $row['booking_time'];
        }
        return $slots;
    }

    /**
     * Create a new booking (with double-booking prevention)
     */
    public function createBooking($date, $time, $personalData, $consent, $ip = '') {
        // Double-check availability (with exclusive lock via transaction)
        $this->db->exec('BEGIN EXCLUSIVE TRANSACTION');

        try {
            if (!$this->isSlotAvailable($date, $time)) {
                $this->db->exec('ROLLBACK');
                return ['success' => false, 'error' => 'Dit tijdslot is helaas net geboekt door iemand anders. Kies een ander tijdstip.'];
            }

            // Encrypt personal data
            $encryptedData = $this->encrypt($personalData);

            // Create hash for lookups
            $dataHash = $this->hashEmail($personalData['email']);

            // Calculate expiry (data retention policy)
            $expiresAt = date('Y-m-d H:i:s', strtotime('+' . DATA_RETENTION_DAYS . ' days'));

            // Hash IP (don't store plaintext)
            $ipHash = $ip ? hash('sha256', $ip . ENCRYPTION_KEY) : '';

            $stmt = $this->db->prepare(
                "INSERT INTO bookings (booking_date, booking_time, encrypted_data, data_hash,
                    consent_given, consent_timestamp, ip_address_hash, expires_at)
                 VALUES (:date, :time, :data, :hash, :consent, :consent_ts, :ip, :expires)"
            );

            $stmt->bindValue(':date', $date, SQLITE3_TEXT);
            $stmt->bindValue(':time', $time, SQLITE3_TEXT);
            $stmt->bindValue(':data', $encryptedData, SQLITE3_TEXT);
            $stmt->bindValue(':hash', $dataHash, SQLITE3_TEXT);
            $stmt->bindValue(':consent', $consent ? 1 : 0, SQLITE3_INTEGER);
            $stmt->bindValue(':consent_ts', $consent ? date('Y-m-d H:i:s') : null, SQLITE3_TEXT);
            $stmt->bindValue(':ip', $ipHash, SQLITE3_TEXT);
            $stmt->bindValue(':expires', $expiresAt, SQLITE3_TEXT);

            $stmt->execute();
            $bookingId = $this->db->lastInsertRowID();

            // Audit log
            $this->logAction('booking_created', $bookingId, 'Afspraak aangemaakt', $ipHash);

            $this->db->exec('COMMIT');

            return ['success' => true, 'bookingId' => $bookingId];

        } catch (Exception $e) {
            $this->db->exec('ROLLBACK');
            return ['success' => false, 'error' => 'Er is een fout opgetreden. Probeer het opnieuw.'];
        }
    }

    /**
     * Get booking details (decrypted) by ID
     */
    public function getBooking($id) {
        $stmt = $this->db->prepare(
            "SELECT * FROM bookings WHERE id = :id AND status = 'confirmed'"
        );
        $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
        $row = $stmt->execute()->fetchArray(SQLITE3_ASSOC);

        if (!$row) return null;

        $row['personal_data'] = $this->decrypt($row['encrypted_data']);
        unset($row['encrypted_data']);

        return $row;
    }

    /**
     * Process data deletion request (right to be forgotten / AVG Art. 17)
     */
    public function requestDeletion($email) {
        $emailHash = $this->hashEmail($email);

        // Log the deletion request
        $stmt = $this->db->prepare(
            "INSERT INTO deletion_requests (email_hash) VALUES (:hash)"
        );
        $stmt->bindValue(':hash', $emailHash, SQLITE3_TEXT);
        $stmt->execute();

        // Delete all bookings for this email
        $stmt = $this->db->prepare(
            "UPDATE bookings SET encrypted_data = 'DELETED', status = 'deleted'
             WHERE data_hash = :hash"
        );
        $stmt->bindValue(':hash', $emailHash, SQLITE3_TEXT);
        $stmt->execute();

        $affected = $this->db->changes();

        // Update deletion request
        $this->db->exec(
            "UPDATE deletion_requests SET processed_at = datetime('now','localtime'),
             status = 'completed' WHERE email_hash = '{$emailHash}' AND status = 'pending'"
        );

        $this->logAction('data_deleted', null, "Verwijderverzoek verwerkt voor hash: {$emailHash}");

        return $affected;
    }

    /**
     * Clean expired data (automatic retention enforcement)
     */
    private function cleanExpiredData() {
        $this->db->exec(
            "UPDATE bookings SET encrypted_data = 'EXPIRED', status = 'expired'
             WHERE expires_at < datetime('now','localtime') AND status = 'confirmed'"
        );

        $cleaned = $this->db->changes();
        if ($cleaned > 0) {
            $this->logAction('auto_cleanup', null, "{$cleaned} verlopen records opgeschoond");
        }
    }

    /**
     * Audit logging
     */
    private function logAction($action, $bookingId = null, $details = '', $ipHash = '') {
        $stmt = $this->db->prepare(
            "INSERT INTO audit_log (action, booking_id, details, ip_address_hash)
             VALUES (:action, :bid, :details, :ip)"
        );
        $stmt->bindValue(':action', $action, SQLITE3_TEXT);
        $stmt->bindValue(':bid', $bookingId, SQLITE3_INTEGER);
        $stmt->bindValue(':details', $details, SQLITE3_TEXT);
        $stmt->bindValue(':ip', $ipHash, SQLITE3_TEXT);
        $stmt->execute();
    }

    public function __destruct() {
        if ($this->db) {
            $this->db->close();
        }
    }
}
