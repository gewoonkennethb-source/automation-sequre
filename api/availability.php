<?php
/**
 * Automation SeQure — Weekly Availability API
 *
 * GET /api/availability.php
 * Returns the number of remaining bookable slots for the current week.
 * Used by the urgency banner on the homepage.
 */

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/database.php';

checkRateLimit();

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(['error' => 'Alleen GET-verzoeken toegestaan.']);
    exit;
}

// Calculate current week boundaries (Monday to Friday)
$today = new DateTime('today');
$dayOfWeek = (int) $today->format('N'); // 1=Mon, 7=Sun

// Find Monday of the current week
$monday = clone $today;
if ($dayOfWeek > 1) {
    $monday->modify('-' . ($dayOfWeek - 1) . ' days');
}

// Find Friday of the current week
$friday = clone $monday;
$friday->modify('+4 days');

// Calculate total possible slots for remaining weekdays this week
$slotsPerDay = (SLOT_END_HOUR - SLOT_START_HOUR) * (60 / SLOT_DURATION);
$totalWeekSlots = 0;
$bookedThisWeek = 0;

$db = new BookingDatabase();

// Loop through Monday to Friday
$checkDate = clone $monday;
for ($i = 0; $i < 5; $i++) {
    $dateStr = $checkDate->format('Y-m-d');
    $diff = (int) $today->diff($checkDate)->format('%r%a');

    // Only count future dates that are bookable (past BOOKED_DAYS_AHEAD)
    if ($diff >= BOOKED_DAYS_AHEAD) {
        $totalWeekSlots += $slotsPerDay;
        $bookedSlots = $db->getBookedSlots($dateStr);
        $bookedThisWeek += count($bookedSlots);
    }

    $checkDate->modify('+1 day');
}

$remainingSlots = max(0, $totalWeekSlots - $bookedThisWeek);

echo json_encode([
    'weekStart'      => $monday->format('Y-m-d'),
    'weekEnd'        => $friday->format('Y-m-d'),
    'totalSlots'     => (int) $totalWeekSlots,
    'bookedSlots'    => $bookedThisWeek,
    'remainingSlots' => (int) $remainingSlots,
    'month'          => $today->format('F Y')
]);
