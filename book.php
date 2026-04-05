<?php
/**
 * Automation SeQure — Booking Handler
 *
 * Verwerkt afspraken, voorkomt dubbelboekingen en stuurt bevestigingsmails.
 * AVG/GDPR-compliant: versleutelde opslag, toestemming vereist.
 * Deploy op TransIP shared hosting (PHP 8+).
 */

require_once __DIR__ . '/api/config.php';
require_once __DIR__ . '/api/database.php';

checkRateLimit();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Alleen POST-verzoeken toegestaan.']);
    exit;
}

// --- Parse input ---
$input = json_decode(file_get_contents('php://input'), true);

if (!$input) {
    http_response_code(400);
    echo json_encode(['error' => 'Ongeldige data ontvangen.']);
    exit;
}

// --- Validate required fields ---
$required = ['firstName', 'lastName', 'companyName', 'email', 'phone', 'date', 'time'];
foreach ($required as $field) {
    if (empty($input[$field])) {
        http_response_code(400);
        echo json_encode(['error' => "Veld '{$field}' is verplicht."]);
        exit;
    }
}

if (!filter_var($input['email'], FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['error' => 'Ongeldig e-mailadres.']);
    exit;
}

// --- Check AVG consent ---
if (empty($input['privacyConsent'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Je moet akkoord gaan met de privacyverklaring om een afspraak te maken.']);
    exit;
}

// --- Sanitize ---
$personalData = [
    'firstName'   => htmlspecialchars(strip_tags(trim($input['firstName']))),
    'lastName'    => htmlspecialchars(strip_tags(trim($input['lastName']))),
    'companyName' => htmlspecialchars(strip_tags(trim($input['companyName']))),
    'address'     => htmlspecialchars(strip_tags(trim($input['address'] ?? ''))),
    'email'       => filter_var(trim($input['email']), FILTER_SANITIZE_EMAIL),
    'phone'       => htmlspecialchars(strip_tags(trim($input['phone']))),
];

$date        = htmlspecialchars(strip_tags(trim($input['date'])));
$time        = htmlspecialchars(strip_tags(trim($input['time'])));
$dateDisplay = htmlspecialchars(strip_tags(trim($input['dateDisplay'] ?? '')));
$consent     = !empty($input['privacyConsent']);
$ip          = $_SERVER['REMOTE_ADDR'] ?? '';

// Optional fields: pakket & service
$pakket  = htmlspecialchars(strip_tags(trim($input['pakket'] ?? '')));
$service = htmlspecialchars(strip_tags(trim($input['service'] ?? '')));

// Readable labels for pakket and service
$pakketLabels = [
    'starter'        => 'Starter',
    'professioneel'  => 'Professioneel',
    'compleet'       => 'Compleet Ecosysteem',
];
$serviceLabels = [
    'website'           => 'Commerciële website',
    'landing-page'      => 'Landing page',
    'lead-intake'       => 'Lead intake & kwalificatie',
    'automatisering'    => 'Procesautomatisering',
    'ai-leadopvolging'  => 'AI leadopvolging',
    'compleet-traject'  => 'Volledig digitaal ecosysteem',
    'anders'            => 'Iets anders / Weet ik nog niet',
];
$pakketDisplay  = $pakketLabels[$pakket] ?? '';
$serviceDisplay = $serviceLabels[$service] ?? '';

// --- Validate date format ---
if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
    http_response_code(400);
    echo json_encode(['error' => 'Ongeldig datumformaat.']);
    exit;
}

// --- Validate time format ---
if (!preg_match('/^\d{2}:\d{2}$/', $time)) {
    http_response_code(400);
    echo json_encode(['error' => 'Ongeldig tijdformaat.']);
    exit;
}

// --- Create booking (with double-booking prevention) ---
$db = new BookingDatabase();
$result = $db->createBooking($date, $time, $personalData, $consent, $ip);

if (!$result['success']) {
    http_response_code(409); // Conflict
    echo json_encode([
        'success' => false,
        'error' => $result['error'],
        'doubleBooked' => true
    ]);
    exit;
}

// --- Calculate end time ---
$timeParts = explode(':', $time);
$endMinutes = intval($timeParts[1]) + SLOT_DURATION;
$endHour    = intval($timeParts[0]);
if ($endMinutes >= 60) { $endHour++; $endMinutes -= 60; }
$endTime = sprintf('%02d:%02d', $endHour, $endMinutes);

$firstName = $personalData['firstName'];
$fullName  = $personalData['firstName'] . ' ' . $personalData['lastName'];
$email     = $personalData['email'];
$phone     = $personalData['phone'];
$companyName = $personalData['companyName'];
$address   = $personalData['address'];

// --- E-mail naar klant (bevestiging) ---
$customerSubject = "Bevestiging: Jouw afspraak op {$date} om {$time}";

$customerHtml = <<<HTML
<!DOCTYPE html>
<html lang="nl">
<head><meta charset="UTF-8"></head>
<body style="margin:0;padding:0;font-family:Arial,Helvetica,sans-serif;background:#0A0A0F;color:#B0B3C0;">
  <div style="max-width:600px;margin:0 auto;padding:40px 24px;">
    <div style="text-align:center;margin-bottom:32px;">
      <div style="display:inline-block;background:linear-gradient(135deg,#6C5CE7,#00D2FF);padding:10px 20px;border-radius:10px;">
        <span style="color:#fff;font-size:18px;font-weight:bold;">Automation SeQure</span>
      </div>
    </div>
    <div style="background:#12121A;border:1px solid rgba(255,255,255,0.06);border-radius:16px;padding:36px 28px;">
      <h1 style="color:#EAEDF6;font-size:22px;margin:0 0 8px;">Afspraak bevestigd!</h1>
      <p style="margin:0 0 24px;font-size:15px;line-height:1.6;">
        Hoi {$firstName}, bedankt voor het inplannen van een afspraak. Hieronder vind je de details.
      </p>
      <div style="background:#1A1A25;border:1px solid rgba(255,255,255,0.06);border-radius:10px;padding:20px;margin-bottom:24px;">
        <table style="width:100%;border-collapse:collapse;font-size:14px;">
          <tr><td style="padding:8px 0;color:#6B6F80;width:120px;">Datum</td>
              <td style="padding:8px 0;color:#EAEDF6;font-weight:600;">{$dateDisplay}</td></tr>
          <tr><td style="padding:8px 0;color:#6B6F80;border-top:1px solid rgba(255,255,255,0.06);">Tijdstip</td>
              <td style="padding:8px 0;color:#EAEDF6;font-weight:600;border-top:1px solid rgba(255,255,255,0.06);">{$time} - {$endTime}</td></tr>
          <tr><td style="padding:8px 0;color:#6B6F80;border-top:1px solid rgba(255,255,255,0.06);">Duur</td>
              <td style="padding:8px 0;color:#EAEDF6;font-weight:600;border-top:1px solid rgba(255,255,255,0.06);">30 minuten</td></tr>
          <tr><td style="padding:8px 0;color:#6B6F80;border-top:1px solid rgba(255,255,255,0.06);">Referentie</td>
              <td style="padding:8px 0;color:#EAEDF6;font-weight:600;border-top:1px solid rgba(255,255,255,0.06);">#{$result['bookingId']}</td></tr>
HTML;

// Conditionally add pakket row
if ($pakketDisplay) {
    $customerHtml .= <<<HTML
          <tr><td style="padding:8px 0;color:#6B6F80;border-top:1px solid rgba(255,255,255,0.06);">Pakket</td>
              <td style="padding:8px 0;color:#EAEDF6;font-weight:600;border-top:1px solid rgba(255,255,255,0.06);">{$pakketDisplay}</td></tr>
HTML;
}

// Conditionally add service row
if ($serviceDisplay) {
    $customerHtml .= <<<HTML
          <tr><td style="padding:8px 0;color:#6B6F80;border-top:1px solid rgba(255,255,255,0.06);">Interesse</td>
              <td style="padding:8px 0;color:#EAEDF6;font-weight:600;border-top:1px solid rgba(255,255,255,0.06);">{$serviceDisplay}</td></tr>
HTML;
}

$customerHtml .= <<<HTML
        </table>
      </div>
      <p style="font-size:14px;line-height:1.6;margin:0 0 24px;">
        Wij nemen op het afgesproken tijdstip contact met je op.
        Heb je vragen? Stuur ons gerust een bericht.
      </p>
      <p style="font-size:12px;color:#6B6F80;line-height:1.5;margin:16px 0 0;border-top:1px solid rgba(255,255,255,0.06);padding-top:16px;">
        Je gegevens worden versleuteld opgeslagen en verwerkt conform onze
        <a href="{PRIVACY_POLICY_URL}" style="color:#6C5CE7;">privacyverklaring</a>.
        Je kunt op elk moment verzoeken om verwijdering van je gegevens door te mailen naar {SITE_EMAIL}.
      </p>
    </div>
    <div style="text-align:center;margin-top:32px;font-size:12px;color:#6B6F80;">
      <p style="margin:0 0 8px;">&copy; 2026 Automation SeQure | Almere, Nederland</p>
    </div>
  </div>
</body>
</html>
HTML;

$customerHeaders  = "MIME-Version: 1.0\r\n";
$customerHeaders .= "Content-Type: text/html; charset=UTF-8\r\n";
$customerHeaders .= "From: " . SITE_NAME . " <" . SITE_EMAIL . ">\r\n";
$customerHeaders .= "Reply-To: " . SITE_EMAIL . "\r\n";

$customerSent = @mail($email, $customerSubject, $customerHtml, $customerHeaders);

// --- E-mail naar admin ---
$adminSubject = "Nieuwe afspraak: {$fullName} ({$companyName}) - {$date} {$time}";

$adminHtml = <<<HTML
<!DOCTYPE html>
<html lang="nl">
<head><meta charset="UTF-8"></head>
<body style="margin:0;padding:0;font-family:Arial,sans-serif;background:#f5f5f5;">
  <div style="max-width:600px;margin:20px auto;background:#fff;border-radius:12px;padding:32px;">
    <h2 style="color:#333;margin:0 0 20px;">Nieuwe afspraak #{$result['bookingId']}</h2>
    <table style="width:100%;border-collapse:collapse;font-size:14px;">
      <tr><td style="padding:10px;border-bottom:1px solid #eee;color:#888;width:140px;">Naam</td>
          <td style="padding:10px;border-bottom:1px solid #eee;font-weight:600;">{$fullName}</td></tr>
      <tr><td style="padding:10px;border-bottom:1px solid #eee;color:#888;">Bedrijf</td>
          <td style="padding:10px;border-bottom:1px solid #eee;font-weight:600;">{$companyName}</td></tr>
      <tr><td style="padding:10px;border-bottom:1px solid #eee;color:#888;">Adres</td>
          <td style="padding:10px;border-bottom:1px solid #eee;">{$address}</td></tr>
      <tr><td style="padding:10px;border-bottom:1px solid #eee;color:#888;">E-mail</td>
          <td style="padding:10px;border-bottom:1px solid #eee;"><a href="mailto:{$email}">{$email}</a></td></tr>
      <tr><td style="padding:10px;border-bottom:1px solid #eee;color:#888;">Telefoon</td>
          <td style="padding:10px;border-bottom:1px solid #eee;"><a href="tel:{$phone}">{$phone}</a></td></tr>
      <tr><td style="padding:10px;border-bottom:1px solid #eee;color:#888;">Datum</td>
          <td style="padding:10px;border-bottom:1px solid #eee;font-weight:600;">{$dateDisplay}</td></tr>
      <tr><td style="padding:10px;border-bottom:1px solid #eee;color:#888;">Tijdstip</td>
          <td style="padding:10px;border-bottom:1px solid #eee;font-weight:600;">{$time} - {$endTime}</td></tr>
      <tr><td style="padding:10px;color:#888;">AVG-toestemming</td>
          <td style="padding:10px;color:#27ae60;font-weight:600;">Gegeven</td></tr>
HTML;

// Conditionally add pakket row to admin email
if ($pakketDisplay) {
    $adminHtml .= <<<HTML
      <tr><td style="padding:10px;border-top:1px solid #eee;color:#888;">Pakket</td>
          <td style="padding:10px;border-top:1px solid #eee;font-weight:600;color:#6C5CE7;">{$pakketDisplay}</td></tr>
HTML;
}

// Conditionally add service row to admin email
if ($serviceDisplay) {
    $adminHtml .= <<<HTML
      <tr><td style="padding:10px;border-top:1px solid #eee;color:#888;">Interesse</td>
          <td style="padding:10px;border-top:1px solid #eee;font-weight:600;">{$serviceDisplay}</td></tr>
HTML;
}

$adminHtml .= <<<HTML
    </table>
  </div>
</body>
</html>
HTML;

$adminHeaders  = "MIME-Version: 1.0\r\n";
$adminHeaders .= "Content-Type: text/html; charset=UTF-8\r\n";
$adminHeaders .= "From: " . SITE_NAME . " <" . SITE_EMAIL . ">\r\n";
$adminHeaders .= "Reply-To: {$email}\r\n";

@mail(ADMIN_EMAIL, $adminSubject, $adminHtml, $adminHeaders);

// --- Response ---
echo json_encode([
    'success'   => true,
    'bookingId' => $result['bookingId'],
    'message'   => 'Afspraak bevestigd.',
    'mailSent'  => $customerSent
]);
