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
    'postcode'    => htmlspecialchars(strip_tags(trim($input['postcode'] ?? ''))),
    'city'        => htmlspecialchars(strip_tags(trim($input['city'] ?? ''))),
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
    'quickscan'      => 'AI Governance Quickscan',
    'blueprint'      => 'AI Governance Blueprint',
    'compliance'     => 'Compliance Service',
    'automatisering' => 'AI Automatisering',
    // Backward compatibility
    'starter'        => 'AI Governance Quickscan',
    'growth'         => 'AI Governance Blueprint',
    'scale'          => 'Compliance Service',
];
$serviceLabels = [
    'inbox-calendar'           => 'AI Inbox & Calendar Manager',
    'appointment-setter'       => 'AI Appointment Setter',
    'sales-chatbot'            => 'AI Sales Chatbot',
    'private-ai'               => 'Private / On-Premise AI',
    'maatwerk-workflows'       => 'Maatwerk Automation Workflows',
    'ai-governance-quickscan'  => 'AI Governance Quickscan',
    'ai-governance-blueprint'  => 'AI Governance Blueprint',
    'ai-compliance-service'    => 'Compliance Service',
    'anders'                   => 'Iets anders / Weet ik nog niet',
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
$postcode  = $personalData['postcode'];
$city      = $personalData['city'];

// --- Generate .ics calendar file ---
// Convert local Amsterdam time to UTC for maximum calendar app compatibility
$dtStart = new DateTime("{$date} {$time}", new DateTimeZone('Europe/Amsterdam'));
$dtEnd   = new DateTime("{$date} {$endTime}", new DateTimeZone('Europe/Amsterdam'));
$dtStart->setTimezone(new DateTimeZone('UTC'));
$dtEnd->setTimezone(new DateTimeZone('UTC'));

$icsDateStart = $dtStart->format('Ymd\THis\Z');
$icsDateEnd   = $dtEnd->format('Ymd\THis\Z');
$icsUid       = 'aseq-' . $result['bookingId'] . '@automationsequre.nl';
$icsNow       = gmdate('Ymd\THis\Z');
$icsDesc      = "Intake gesprek met Automation SeQure\\nReferentie: #{$result['bookingId']}";
if ($serviceDisplay) $icsDesc .= "\\nInteresse: {$serviceDisplay}";

$icsContent = "BEGIN:VCALENDAR\r\n";
$icsContent .= "VERSION:2.0\r\n";
$icsContent .= "PRODID:-//Automation SeQure//Booking//NL\r\n";
$icsContent .= "CALSCALE:GREGORIAN\r\n";
$icsContent .= "METHOD:REQUEST\r\n";
$icsContent .= "BEGIN:VEVENT\r\n";
$icsContent .= "UID:{$icsUid}\r\n";
$icsContent .= "DTSTAMP:{$icsNow}\r\n";
$icsContent .= "DTSTART:{$icsDateStart}\r\n";
$icsContent .= "DTEND:{$icsDateEnd}\r\n";
$icsContent .= "SUMMARY:Intake - Automation SeQure\r\n";
$icsContent .= "DESCRIPTION:{$icsDesc}\r\n";
$icsContent .= "ORGANIZER;CN=Automation SeQure:mailto:" . SITE_EMAIL . "\r\n";
$icsContent .= "ATTENDEE;CN={$fullName}:mailto:{$email}\r\n";
$icsContent .= "STATUS:CONFIRMED\r\n";
$icsContent .= "BEGIN:VALARM\r\n";
$icsContent .= "TRIGGER:-PT15M\r\n";
$icsContent .= "ACTION:DISPLAY\r\n";
$icsContent .= "DESCRIPTION:Afspraak Automation SeQure over 15 minuten\r\n";
$icsContent .= "END:VALARM\r\n";
$icsContent .= "END:VEVENT\r\n";
$icsContent .= "END:VCALENDAR\r\n";

// --- Calendar link variables (shared by customer and admin emails) ---
$calStart      = $date . 'T' . $time . ':00';
$calEnd        = $date . 'T' . $endTime . ':00';
$gcalStart     = str_replace('-', '', $date) . 'T' . str_replace(':', '', $time) . '00';
$gcalEnd       = str_replace('-', '', $date) . 'T' . str_replace(':', '', $endTime) . '00';
$gcalTitle     = rawurlencode("Intake - Automation SeQure");
$gcalDetails   = rawurlencode("Intake gesprek met Automation SeQure\nReferentie: #{$result['bookingId']}");
$gcalLink      = "https://calendar.google.com/calendar/render?action=TEMPLATE&text={$gcalTitle}&dates={$gcalStart}/{$gcalEnd}&details={$gcalDetails}&ctz=Europe/Amsterdam";

// Outlook deeplink for customer (no online=1, no attendee — that's admin-only)
$outlookCustomerSubject = rawurlencode("Intake - Automation SeQure");
$outlookCustomerBody    = rawurlencode("Intake gesprek met Automation SeQure\nReferentie: #{$result['bookingId']}");
$outlookCustomerLink    = "https://outlook.office.com/calendar/0/deeplink/compose?subject={$outlookCustomerSubject}&startdt={$calStart}&enddt={$calEnd}&body={$outlookCustomerBody}";

// --- E-mail naar klant (bevestiging) ---
$customerSubject = "Bevestiging: Jouw afspraak op {$date} om {$time}";
$privacyUrl = PRIVACY_POLICY_URL;
$siteEmail  = SITE_EMAIL;

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
      <h1 style="color:#EAEDF6;font-size:22px;margin:0 0 6px;">Afspraak bevestigd!</h1>
      <p style="color:#6B6F80;font-size:13px;margin:0 0 24px;">Referentie #{$result['bookingId']}</p>

      <!-- CTA: Toevoegen aan agenda -->
      <div style="text-align:center;margin-bottom:28px;">
        <a href="{$outlookCustomerLink}" target="_blank"
           style="display:inline-block;background:linear-gradient(135deg,#6C5CE7,#00D2FF);color:#fff;text-decoration:none;font-weight:700;font-size:15px;padding:14px 32px;border-radius:10px;">
          &#128197; Toevoegen aan Outlook Agenda
        </a>
      </div>

      <!-- Jouw gegevens -->
      <p style="color:#6C5CE7;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:1.5px;margin:0 0 12px;">Jouw gegevens</p>
      <div style="background:#1A1A25;border:1px solid rgba(255,255,255,0.06);border-radius:10px;padding:20px;margin-bottom:20px;">
        <table style="width:100%;border-collapse:collapse;font-size:14px;">
          <tr><td style="padding:8px 0;color:#6B6F80;width:120px;">Naam</td>
              <td style="padding:8px 0;color:#EAEDF6;font-weight:600;">{$fullName}</td></tr>
          <tr><td style="padding:8px 0;color:#6B6F80;border-top:1px solid rgba(255,255,255,0.06);">Bedrijf</td>
              <td style="padding:8px 0;color:#EAEDF6;font-weight:600;border-top:1px solid rgba(255,255,255,0.06);">{$companyName}</td></tr>
          <tr><td style="padding:8px 0;color:#6B6F80;border-top:1px solid rgba(255,255,255,0.06);">E-mail</td>
              <td style="padding:8px 0;color:#EAEDF6;border-top:1px solid rgba(255,255,255,0.06);">{$email}</td></tr>
          <tr><td style="padding:8px 0;color:#6B6F80;border-top:1px solid rgba(255,255,255,0.06);">Telefoon</td>
              <td style="padding:8px 0;color:#EAEDF6;border-top:1px solid rgba(255,255,255,0.06);">{$phone}</td></tr>
        </table>
      </div>

      <!-- Afspraak details -->
      <p style="color:#6C5CE7;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:1.5px;margin:0 0 12px;">Afspraak</p>
      <div style="background:#1A1A25;border:1px solid rgba(255,255,255,0.06);border-radius:10px;padding:20px;margin-bottom:20px;">
        <table style="width:100%;border-collapse:collapse;font-size:14px;">
          <tr><td style="padding:8px 0;color:#6B6F80;width:120px;">Datum</td>
              <td style="padding:8px 0;color:#EAEDF6;font-weight:600;">{$dateDisplay}</td></tr>
          <tr><td style="padding:8px 0;color:#6B6F80;border-top:1px solid rgba(255,255,255,0.06);">Tijdstip</td>
              <td style="padding:8px 0;color:#EAEDF6;font-weight:600;border-top:1px solid rgba(255,255,255,0.06);">{$time} - {$endTime}</td></tr>
          <tr><td style="padding:8px 0;color:#6B6F80;border-top:1px solid rgba(255,255,255,0.06);">Duur</td>
              <td style="padding:8px 0;color:#EAEDF6;font-weight:600;border-top:1px solid rgba(255,255,255,0.06);">30 minuten</td></tr>
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

      <!-- Meer agenda opties -->
      <p style="color:#6C5CE7;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:1.5px;margin:0 0 14px;text-align:center;">Andere agenda?</p>
      <div style="text-align:center;margin-bottom:24px;">
        <a href="{$gcalLink}" target="_blank"
           style="display:inline-block;background:#1A1A25;border:1px solid rgba(255,255,255,0.1);color:#EAEDF6;text-decoration:none;font-weight:600;font-size:13px;padding:10px 20px;border-radius:8px;margin:4px;">
          &#128197; Google Agenda
        </a>
      </div>
      <p style="text-align:center;font-size:12px;color:#6B6F80;margin:0 0 24px;">
        iPhone &amp; Android: open het .ics bestand in de bijlage om toe te voegen aan je agenda.
      </p>

      <!-- Wat kun je verwachten -->
      <div style="background:#1A1A25;border:1px solid rgba(255,255,255,0.06);border-radius:10px;padding:20px;margin-bottom:20px;">
        <p style="color:#EAEDF6;font-size:14px;font-weight:600;margin:0 0 10px;">Wat kun je verwachten?</p>
        <p style="font-size:14px;line-height:1.6;margin:0;color:#B0B3C0;">
          Wij nemen op het afgesproken tijdstip contact met je op via Teams of telefoon.
          Heb je vragen of wil je de afspraak wijzigen? Stuur ons gerust een bericht op
          <a href="mailto:{$siteEmail}" style="color:#6C5CE7;text-decoration:none;">{$siteEmail}</a>.
        </p>
      </div>

      <!-- Spam waarschuwing -->
      <div style="background:rgba(108,92,231,0.08);border:1px solid rgba(108,92,231,0.2);border-radius:8px;padding:14px 16px;margin-bottom:20px;">
        <p style="margin:0;font-size:13px;line-height:1.5;color:#B0B3C0;">
          <span style="color:#6C5CE7;font-weight:700;">&#9993; Tip:</span>
          Controleer ook je <strong style="color:#EAEDF6;">spam- of ongewenste e-mail map</strong>. Onze e-mails kunnen daar terechtkomen.
          Markeer ons als veilige afzender om toekomstige berichten direct in je inbox te ontvangen.
        </p>
      </div>

      <!-- AVG -->
      <p style="font-size:12px;color:#6B6F80;line-height:1.5;margin:0;border-top:1px solid rgba(255,255,255,0.06);padding-top:16px;">
        Je gegevens worden versleuteld opgeslagen en verwerkt conform onze
        <a href="{$privacyUrl}" style="color:#6C5CE7;">privacyverklaring</a>.
        Je kunt op elk moment verzoeken om verwijdering van je gegevens door te mailen naar {$siteEmail}.
      </p>
    </div>
    <div style="text-align:center;margin-top:32px;font-size:12px;color:#6B6F80;">
      <p style="margin:0 0 8px;">&copy; 2026 Automation SeQure | Almere, Nederland</p>
    </div>
  </div>
</body>
</html>
HTML;

// --- Build multipart email with .ics attachment ---
$mimeBoundary = 'aseq_' . md5(time() . $result['bookingId']);
$icsBase64 = chunk_split(base64_encode($icsContent));

$customerBody  = "--{$mimeBoundary}\r\n";
$customerBody .= "Content-Type: text/html; charset=UTF-8\r\n";
$customerBody .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
$customerBody .= $customerHtml . "\r\n\r\n";
$customerBody .= "--{$mimeBoundary}\r\n";
$customerBody .= "Content-Type: text/calendar; charset=UTF-8; method=REQUEST; name=\"afspraak.ics\"\r\n";
$customerBody .= "Content-Transfer-Encoding: base64\r\n";
$customerBody .= "Content-Disposition: attachment; filename=\"afspraak.ics\"\r\n\r\n";
$customerBody .= $icsBase64 . "\r\n";
$customerBody .= "--{$mimeBoundary}--\r\n";

$customerHeaders  = "MIME-Version: 1.0\r\n";
$customerHeaders .= "Content-Type: multipart/mixed; boundary=\"{$mimeBoundary}\"\r\n";
$customerHeaders .= "From: " . SITE_NAME . " <" . SITE_EMAIL . ">\r\n";
$customerHeaders .= "Reply-To: " . SITE_EMAIL . "\r\n";

$customerSent = @mail($email, $customerSubject, $customerBody, $customerHeaders);

// --- E-mail naar admin ---
$adminSubject = "Nieuwe afspraak: {$fullName} ({$companyName}) - {$date} {$time}";

// Build Outlook/Teams deep link for one-click calendar + Teams meeting creation
$teamsSubject  = rawurlencode("Intake - {$fullName} ({$companyName})");
$teamsStart    = $calStart;
$teamsEnd      = $calEnd;
$teamsBodyText = "Intake gesprek met {$fullName} van {$companyName}\n\nE-mail: {$email}\nTelefoon: {$phone}";
if ($address || $postcode || $city) {
    $teamsBodyText .= "\nAdres: {$address}, {$postcode} {$city}";
}
if ($serviceDisplay) {
    $teamsBodyText .= "\nInteresse: {$serviceDisplay}";
}
if ($pakketDisplay) {
    $teamsBodyText .= "\nPakket: {$pakketDisplay}";
}
$teamsBody     = rawurlencode($teamsBodyText);
$teamsAttendee = rawurlencode($email);
$outlookDeepLink = "https://outlook.office.com/calendar/0/deeplink/compose?subject={$teamsSubject}&startdt={$teamsStart}&enddt={$teamsEnd}&body={$teamsBody}&to={$teamsAttendee}&online=1";

// Address display
$addressLine = '';
if ($address) $addressLine .= $address;
if ($postcode || $city) {
    if ($addressLine) $addressLine .= '<br>';
    $addressLine .= trim($postcode . ' ' . $city);
}

$adminHtml = <<<HTML
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
      <h1 style="color:#EAEDF6;font-size:22px;margin:0 0 6px;">Nieuwe afspraak</h1>
      <p style="color:#6B6F80;font-size:13px;margin:0 0 24px;">Referentie #{$result['bookingId']}</p>

      <!-- CTA: Teams Meeting -->
      <div style="text-align:center;margin-bottom:28px;">
        <a href="{$outlookDeepLink}" target="_blank"
           style="display:inline-block;background:linear-gradient(135deg,#6C5CE7,#00D2FF);color:#fff;text-decoration:none;font-weight:700;font-size:15px;padding:14px 32px;border-radius:10px;">
          &#128197; Plan Teams Meeting in Outlook
        </a>
      </div>

      <!-- Klantgegevens -->
      <p style="color:#6C5CE7;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:1.5px;margin:0 0 12px;">Klantgegevens</p>
      <div style="background:#1A1A25;border:1px solid rgba(255,255,255,0.06);border-radius:10px;padding:20px;margin-bottom:20px;">
        <table style="width:100%;border-collapse:collapse;font-size:14px;">
          <tr><td style="padding:8px 0;color:#6B6F80;width:120px;">Naam</td>
              <td style="padding:8px 0;color:#EAEDF6;font-weight:600;">{$fullName}</td></tr>
          <tr><td style="padding:8px 0;color:#6B6F80;border-top:1px solid rgba(255,255,255,0.06);">Bedrijf</td>
              <td style="padding:8px 0;color:#EAEDF6;font-weight:600;border-top:1px solid rgba(255,255,255,0.06);">{$companyName}</td></tr>
HTML;

if ($addressLine) {
    $adminHtml .= <<<HTML
          <tr><td style="padding:8px 0;color:#6B6F80;border-top:1px solid rgba(255,255,255,0.06);">Adres</td>
              <td style="padding:8px 0;color:#EAEDF6;border-top:1px solid rgba(255,255,255,0.06);">{$addressLine}</td></tr>
HTML;
}

$adminHtml .= <<<HTML
          <tr><td style="padding:8px 0;color:#6B6F80;border-top:1px solid rgba(255,255,255,0.06);">E-mail</td>
              <td style="padding:8px 0;border-top:1px solid rgba(255,255,255,0.06);"><a href="mailto:{$email}" style="color:#6C5CE7;text-decoration:none;">{$email}</a></td></tr>
          <tr><td style="padding:8px 0;color:#6B6F80;border-top:1px solid rgba(255,255,255,0.06);">Telefoon</td>
              <td style="padding:8px 0;border-top:1px solid rgba(255,255,255,0.06);"><a href="tel:{$phone}" style="color:#6C5CE7;text-decoration:none;">{$phone}</a></td></tr>
        </table>
      </div>

      <!-- Afspraak details -->
      <p style="color:#6C5CE7;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:1.5px;margin:0 0 12px;">Afspraak</p>
      <div style="background:#1A1A25;border:1px solid rgba(255,255,255,0.06);border-radius:10px;padding:20px;margin-bottom:20px;">
        <table style="width:100%;border-collapse:collapse;font-size:14px;">
          <tr><td style="padding:8px 0;color:#6B6F80;width:120px;">Datum</td>
              <td style="padding:8px 0;color:#EAEDF6;font-weight:600;">{$dateDisplay}</td></tr>
          <tr><td style="padding:8px 0;color:#6B6F80;border-top:1px solid rgba(255,255,255,0.06);">Tijdstip</td>
              <td style="padding:8px 0;color:#EAEDF6;font-weight:600;border-top:1px solid rgba(255,255,255,0.06);">{$time} - {$endTime}</td></tr>
          <tr><td style="padding:8px 0;color:#6B6F80;border-top:1px solid rgba(255,255,255,0.06);">Duur</td>
              <td style="padding:8px 0;color:#EAEDF6;font-weight:600;border-top:1px solid rgba(255,255,255,0.06);">30 minuten</td></tr>
HTML;

// Conditionally add pakket row to admin email
if ($pakketDisplay) {
    $adminHtml .= <<<HTML
          <tr><td style="padding:8px 0;color:#6B6F80;border-top:1px solid rgba(255,255,255,0.06);">Pakket</td>
              <td style="padding:8px 0;color:#EAEDF6;font-weight:600;border-top:1px solid rgba(255,255,255,0.06);">{$pakketDisplay}</td></tr>
HTML;
}

// Conditionally add service row to admin email
if ($serviceDisplay) {
    $adminHtml .= <<<HTML
          <tr><td style="padding:8px 0;color:#6B6F80;border-top:1px solid rgba(255,255,255,0.06);">Interesse</td>
              <td style="padding:8px 0;color:#EAEDF6;font-weight:600;border-top:1px solid rgba(255,255,255,0.06);">{$serviceDisplay}</td></tr>
HTML;
}

$adminHtml .= <<<HTML
        </table>
      </div>

      <!-- AVG -->
      <div style="background:rgba(52,211,153,0.08);border:1px solid rgba(52,211,153,0.2);border-radius:8px;padding:12px 16px;font-size:13px;">
        <span style="color:#34D399;font-weight:600;">&#10003; AVG-toestemming gegeven</span>
      </div>
    </div>
    <div style="text-align:center;margin-top:32px;font-size:12px;color:#6B6F80;">
      <p style="margin:0;">&copy; 2026 Automation SeQure | Almere, Nederland</p>
    </div>
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
