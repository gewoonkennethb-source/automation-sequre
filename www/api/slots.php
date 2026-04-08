<?php
/**
 * Automation SeQure — Available Slots API
 *
 * GET /api/slots.php?date=2026-04-15
 * Returns available timeslots for a given date.
 */

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/database.php';

checkRateLimit();

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(['error' => 'Alleen GET-verzoeken toegestaan.']);
    exit;
}

$date = $_GET['date'] ?? '';

// Validate date format
if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
    http_response_code(400);
    echo json_encode(['error' => 'Ongeldig datumformaat. Gebruik YYYY-MM-DD.']);
    exit;
}

$dateObj = new DateTime($date);
$today = new DateTime('today');

// Check if date is in the past
if ($dateObj < $today) {
    echo json_encode(['date' => $date, 'slots' => [], 'message' => 'Datum ligt in het verleden.']);
    exit;
}

// Check if date is a weekend
$dayOfWeek = (int) $dateObj->format('N'); // 1=Mon, 7=Sun
if ($dayOfWeek >= 6) {
    echo json_encode(['date' => $date, 'slots' => [], 'message' => 'Geen beschikbaarheid in het weekend.']);
    exit;
}

// Check if date is within booked-ahead window
$diff = $today->diff($dateObj)->days;
if ($diff < BOOKED_DAYS_AHEAD) {
    echo json_encode(['date' => $date, 'slots' => [], 'fullyBooked' => true, 'message' => 'Deze dag is volledig volgeboekt.']);
    exit;
}

// Check max booking window
$maxDate = (clone $today)->modify('+' . MAX_BOOKING_WEEKS . ' weeks');
if ($dateObj > $maxDate) {
    echo json_encode(['date' => $date, 'slots' => [], 'message' => 'Je kunt maximaal ' . MAX_BOOKING_WEEKS . ' weken vooruit boeken.']);
    exit;
}

// Get booked slots from database
$db = new BookingDatabase();
$bookedSlots = $db->getBookedSlots($date);

// Generate all possible slots
$allSlots = [];
for ($h = SLOT_START_HOUR; $h < SLOT_END_HOUR; $h++) {
    for ($m = 0; $m < 60; $m += SLOT_DURATION) {
        $timeStr = sprintf('%02d:%02d', $h, $m);
        $allSlots[] = [
            'time' => $timeStr,
            'available' => !in_array($timeStr, $bookedSlots)
        ];
    }
}

echo json_encode([
    'date' => $date,
    'slots' => $allSlots,
    'bookedCount' => count($bookedSlots),
    'totalSlots' => count($allSlots)
]);
