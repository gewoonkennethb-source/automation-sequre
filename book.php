<?php
/**
 * Automation SeQure — Booking Handler
 *
 * Verwerkt afspraken en stuurt bevestigingsmails.
 * Deploy op TransIP shared hosting (PHP 8+).
 */

// --- CONFIG ---
$fromEmail   = 'info@automationsequre.nl';
$fromName    = 'Automation SeQure';
$adminEmail  = 'info@automationsequre.nl'; // Jouw notificatie-adres
$siteName    = 'Automation SeQure';
$siteUrl     = 'https://automationsequre.nl';

// --- CORS & Headers ---
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

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

// --- Validate ---
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

// --- Sanitize ---
$firstName   = htmlspecialchars(strip_tags(trim($input['firstName'])));
$lastName    = htmlspecialchars(strip_tags(trim($input['lastName'])));
$companyName = htmlspecialchars(strip_tags(trim($input['companyName'])));
$address     = htmlspecialchars(strip_tags(trim($input['address'] ?? '')));
$email       = filter_var(trim($input['email']), FILTER_SANITIZE_EMAIL);
$phone       = htmlspecialchars(strip_tags(trim($input['phone'])));
$date        = htmlspecialchars(strip_tags(trim($input['date'])));
$time        = htmlspecialchars(strip_tags(trim($input['time'])));
$dateDisplay = htmlspecialchars(strip_tags(trim($input['dateDisplay'] ?? '')));

$fullName = $firstName . ' ' . $lastName;

// Calculate end time
$timeParts = explode(':', $time);
$endMinutes = intval($timeParts[1]) + 30;
$endHour    = intval($timeParts[0]);
if ($endMinutes >= 60) {
    $endHour++;
    $endMinutes -= 60;
}
$endTime = sprintf('%02d:%02d', $endHour, $endMinutes);

// --- E-mail naar klant (bevestiging) ---
$customerSubject = "Bevestiging: Jouw afspraak op {$date} om {$time}";

$customerHtml = <<<HTML
<!DOCTYPE html>
<html lang="nl">
<head><meta charset="UTF-8"></head>
<body style="margin:0;padding:0;font-family:Arial,Helvetica,sans-serif;background:#0A0A0F;color:#B0B3C0;">
  <div style="max-width:600px;margin:0 auto;padding:40px 24px;">

    <!-- Header -->
    <div style="text-align:center;margin-bottom:32px;">
      <div style="display:inline-block;background:linear-gradient(135deg,#6C5CE7,#00D2FF);padding:10px 20px;border-radius:10px;">
        <span style="color:#fff;font-size:18px;font-weight:bold;font-family:Arial,sans-serif;">Automation SeQure</span>
      </div>
    </div>

    <!-- Content card -->
    <div style="background:#12121A;border:1px solid rgba(255,255,255,0.06);border-radius:16px;padding:36px 28px;">

      <h1 style="color:#EAEDF6;font-size:22px;margin:0 0 8px;font-family:Arial,sans-serif;">Afspraak bevestigd!</h1>
      <p style="margin:0 0 24px;font-size:15px;line-height:1.6;">
        Hoi {$firstName}, bedankt voor het inplannen van een afspraak. Hieronder vind je de details.
      </p>

      <!-- Details box -->
      <div style="background:#1A1A25;border:1px solid rgba(255,255,255,0.06);border-radius:10px;padding:20px;margin-bottom:24px;">
        <table style="width:100%;border-collapse:collapse;font-size:14px;">
          <tr>
            <td style="padding:8px 0;color:#6B6F80;width:120px;">Datum</td>
            <td style="padding:8px 0;color:#EAEDF6;font-weight:600;">{$dateDisplay}</td>
          </tr>
          <tr>
            <td style="padding:8px 0;color:#6B6F80;border-top:1px solid rgba(255,255,255,0.06);">Tijdstip</td>
            <td style="padding:8px 0;color:#EAEDF6;font-weight:600;border-top:1px solid rgba(255,255,255,0.06);">{$time} - {$endTime}</td>
          </tr>
          <tr>
            <td style="padding:8px 0;color:#6B6F80;border-top:1px solid rgba(255,255,255,0.06);">Duur</td>
            <td style="padding:8px 0;color:#EAEDF6;font-weight:600;border-top:1px solid rgba(255,255,255,0.06);">30 minuten</td>
          </tr>
          <tr>
            <td style="padding:8px 0;color:#6B6F80;border-top:1px solid rgba(255,255,255,0.06);">Type</td>
            <td style="padding:8px 0;color:#EAEDF6;font-weight:600;border-top:1px solid rgba(255,255,255,0.06);">Strategiegesprek (telefonisch of video)</td>
          </tr>
        </table>
      </div>

      <p style="font-size:14px;line-height:1.6;margin:0 0 24px;">
        Wij nemen op het afgesproken tijdstip contact met je op via het telefoonnummer dat je hebt opgegeven.
        Heb je in de tussentijd vragen? Stuur ons gerust een bericht.
      </p>

      <!-- CTA Button -->
      <div style="text-align:center;margin:24px 0 8px;">
        <a href="https://wa.me/31JOUNUMMER" target="_blank"
           style="display:inline-block;padding:14px 32px;background:#25D366;color:#fff;text-decoration:none;border-radius:50px;font-weight:bold;font-size:15px;">
          WhatsApp ons
        </a>
      </div>
    </div>

    <!-- Footer -->
    <div style="text-align:center;margin-top:32px;font-size:12px;color:#6B6F80;">
      <p style="margin:0 0 8px;">&copy; 2026 Automation SeQure | Almere, Nederland</p>
      <p style="margin:0;">
        <a href="{$siteUrl}" style="color:#6C5CE7;text-decoration:none;">automationsequre.nl</a>
      </p>
    </div>
  </div>
</body>
</html>
HTML;

$customerHeaders  = "MIME-Version: 1.0\r\n";
$customerHeaders .= "Content-Type: text/html; charset=UTF-8\r\n";
$customerHeaders .= "From: {$fromName} <{$fromEmail}>\r\n";
$customerHeaders .= "Reply-To: {$fromEmail}\r\n";
$customerHeaders .= "X-Mailer: AutomationSeQure/1.0\r\n";

$customerSent = mail($email, $customerSubject, $customerHtml, $customerHeaders);

// --- E-mail naar admin (notificatie) ---
$adminSubject = "Nieuwe afspraak: {$fullName} ({$companyName}) - {$date} {$time}";

$adminHtml = <<<HTML
<!DOCTYPE html>
<html lang="nl">
<head><meta charset="UTF-8"></head>
<body style="margin:0;padding:0;font-family:Arial,sans-serif;background:#f5f5f5;">
  <div style="max-width:600px;margin:20px auto;background:#fff;border-radius:12px;padding:32px;box-shadow:0 2px 8px rgba(0,0,0,0.08);">
    <h2 style="color:#333;margin:0 0 20px;">Nieuwe afspraak ingepland</h2>

    <table style="width:100%;border-collapse:collapse;font-size:14px;">
      <tr><td style="padding:10px;border-bottom:1px solid #eee;color:#888;width:140px;">Naam</td>
          <td style="padding:10px;border-bottom:1px solid #eee;color:#333;font-weight:600;">{$fullName}</td></tr>
      <tr><td style="padding:10px;border-bottom:1px solid #eee;color:#888;">Bedrijf</td>
          <td style="padding:10px;border-bottom:1px solid #eee;color:#333;font-weight:600;">{$companyName}</td></tr>
      <tr><td style="padding:10px;border-bottom:1px solid #eee;color:#888;">Adres</td>
          <td style="padding:10px;border-bottom:1px solid #eee;color:#333;">{$address}</td></tr>
      <tr><td style="padding:10px;border-bottom:1px solid #eee;color:#888;">E-mail</td>
          <td style="padding:10px;border-bottom:1px solid #eee;color:#333;"><a href="mailto:{$email}">{$email}</a></td></tr>
      <tr><td style="padding:10px;border-bottom:1px solid #eee;color:#888;">Telefoon</td>
          <td style="padding:10px;border-bottom:1px solid #eee;color:#333;"><a href="tel:{$phone}">{$phone}</a></td></tr>
      <tr><td style="padding:10px;border-bottom:1px solid #eee;color:#888;">Datum</td>
          <td style="padding:10px;border-bottom:1px solid #eee;color:#333;font-weight:600;">{$dateDisplay}</td></tr>
      <tr><td style="padding:10px;color:#888;">Tijdstip</td>
          <td style="padding:10px;color:#333;font-weight:600;">{$time} - {$endTime}</td></tr>
    </table>
  </div>
</body>
</html>
HTML;

$adminHeaders  = "MIME-Version: 1.0\r\n";
$adminHeaders .= "Content-Type: text/html; charset=UTF-8\r\n";
$adminHeaders .= "From: {$fromName} <{$fromEmail}>\r\n";
$adminHeaders .= "Reply-To: {$email}\r\n";

$adminSent = mail($adminEmail, $adminSubject, $adminHtml, $adminHeaders);

// --- Response ---
if ($customerSent) {
    echo json_encode([
        'success' => true,
        'message' => 'Afspraak bevestigd. Bevestigingsmail verstuurd.'
    ]);
} else {
    // Even if mail fails, the booking was registered
    echo json_encode([
        'success' => true,
        'message' => 'Afspraak bevestigd. Mail kon niet worden verstuurd, maar we hebben je gegevens ontvangen.',
        'mailError' => true
    ]);
}
