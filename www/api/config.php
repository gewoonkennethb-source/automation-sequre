<?php
/**
 * Automation SeQure — Configuration
 *
 * Centrale configuratie voor de boekings-API.
 * AVG/GDPR-compliant setup.
 */

// --- SITE CONFIG ---
define('SITE_NAME', 'Automation SeQure');
define('SITE_URL', 'https://automationsequre.nl');
define('SITE_EMAIL', 'info@automationsequre.nl');
define('ADMIN_EMAIL', 'info@automationsequre.nl');

// --- BOOKING CONFIG ---
define('SLOT_START_HOUR', 13);    // 13:00
define('SLOT_END_HOUR', 18);      // 18:00
define('SLOT_DURATION', 30);      // minutes
define('BOOKED_DAYS_AHEAD', 2);   // first 2 days fully booked
define('MAX_BOOKING_WEEKS', 12);  // max weeks ahead allowed

// --- DATABASE ---
define('DB_PATH', __DIR__ . '/../db/bookings.sqlite');

// --- ENCRYPTION KEY ---
// BELANGRIJK: Verander deze key naar een willekeurige string van 32+ tekens
// Genereer er een via: php -r "echo bin2hex(random_bytes(32));"
define('ENCRYPTION_KEY', 'VERANDER_DIT_NAAR_EEN_VEILIGE_SLEUTEL_VAN_64_TEKENS_LANG_12345678');

// --- AVG/GDPR CONFIG ---
define('DATA_RETENTION_DAYS', 365);  // Bewaar klantgegevens max 1 jaar
define('PRIVACY_POLICY_URL', SITE_URL . '/privacy.html');

// --- CORS ---
header('Access-Control-Allow-Origin: ' . SITE_URL);
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// --- RATE LIMITING (simple, per IP) ---
function checkRateLimit() {
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    $file = sys_get_temp_dir() . '/aseq_rate_' . md5($ip);

    $now = time();
    $window = 60;       // 1 minute window
    $maxRequests = 20;  // max 20 requests per minute

    $data = [];
    if (file_exists($file)) {
        $data = json_decode(file_get_contents($file), true) ?: [];
    }

    // Clean old entries
    $data = array_filter($data, function($t) use ($now, $window) {
        return ($now - $t) < $window;
    });

    if (count($data) >= $maxRequests) {
        http_response_code(429);
        echo json_encode(['error' => 'Te veel verzoeken. Probeer het over een minuut opnieuw.']);
        exit;
    }

    $data[] = $now;
    file_put_contents($file, json_encode($data));
}
