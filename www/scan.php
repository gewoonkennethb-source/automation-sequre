<?php
/**
 * Automation SeQure — Contact Form Handler
 *
 * POST /scan.php
 * Handles contact form submissions from contact.php.
 * Sends notification email to admin.
 */

require_once __DIR__ . '/api/config.php';

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
$name    = trim($input['name'] ?? '');
$company = trim($input['company'] ?? '');
$email   = trim($input['email'] ?? '');

if (!$name || !$company || !$email) {
    http_response_code(400);
    echo json_encode(['error' => 'Naam, bedrijfsnaam en e-mailadres zijn verplicht.']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['error' => 'Ongeldig e-mailadres.']);
    exit;
}

// --- Sanitize ---
$name    = htmlspecialchars(strip_tags($name));
$company = htmlspecialchars(strip_tags($company));
$email   = filter_var($email, FILTER_SANITIZE_EMAIL);
$phone   = htmlspecialchars(strip_tags(trim($input['phone'] ?? '')));
$service = htmlspecialchars(strip_tags(trim($input['service'] ?? '')));
$message = htmlspecialchars(strip_tags(trim($input['message'] ?? '')));

// Service labels
$serviceLabels = [
    'inbox-calendar'      => 'AI Inbox & Calendar Manager',
    'appointment-setter'  => 'AI Appointment Setter',
    'sales-chatbot'       => 'AI Sales Chatbot',
    'private-ai'          => 'Private / On-Premise AI',
    'maatwerk-workflows'  => 'Maatwerk Automation Workflows',
    'governance'          => 'AI Governance & Compliance',
    'anders'              => 'Anders / weet ik nog niet',
];
$serviceDisplay = $serviceLabels[$service] ?? $service;

// --- Build admin notification email ---
$subject = "Contactformulier: {$name} ({$company})";

$serviceRow = '';
if ($serviceDisplay) {
    $serviceRow = <<<HTML
          <tr><td style="padding:8px 0;color:#6B6F80;border-top:1px solid rgba(255,255,255,0.06);">Interesse</td>
              <td style="padding:8px 0;color:#EAEDF6;font-weight:600;border-top:1px solid rgba(255,255,255,0.06);">{$serviceDisplay}</td></tr>
HTML;
}

$messageRow = '';
if ($message) {
    $messageRow = <<<HTML
      <p style="color:#2ECB6F;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:1.5px;margin:20px 0 12px;">Bericht</p>
      <div style="background:#1A1A25;border:1px solid rgba(255,255,255,0.06);border-radius:10px;padding:20px;margin-bottom:20px;">
        <p style="font-size:14px;line-height:1.6;margin:0;color:#EAEDF6;">{$message}</p>
      </div>
HTML;
}

$html = <<<HTML
<!DOCTYPE html>
<html lang="nl">
<head><meta charset="UTF-8"></head>
<body style="margin:0;padding:0;font-family:Arial,Helvetica,sans-serif;background:#0A0A0F;color:#B0B3C0;">
  <div style="max-width:600px;margin:0 auto;padding:40px 24px;">
    <div style="text-align:center;margin-bottom:32px;">
      <div style="display:inline-block;background:linear-gradient(135deg,#2ECB6F,#00D2FF);padding:10px 20px;border-radius:10px;">
        <span style="color:#fff;font-size:18px;font-weight:bold;">Automation SeQure</span>
      </div>
    </div>
    <div style="background:#12121A;border:1px solid rgba(255,255,255,0.06);border-radius:16px;padding:36px 28px;">
      <h1 style="color:#EAEDF6;font-size:22px;margin:0 0 6px;">Nieuw contactformulier</h1>
      <p style="color:#6B6F80;font-size:13px;margin:0 0 24px;">Via de website ontvangen</p>

      <p style="color:#2ECB6F;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:1.5px;margin:0 0 12px;">Contactgegevens</p>
      <div style="background:#1A1A25;border:1px solid rgba(255,255,255,0.06);border-radius:10px;padding:20px;margin-bottom:20px;">
        <table style="width:100%;border-collapse:collapse;font-size:14px;">
          <tr><td style="padding:8px 0;color:#6B6F80;width:120px;">Naam</td>
              <td style="padding:8px 0;color:#EAEDF6;font-weight:600;">{$name}</td></tr>
          <tr><td style="padding:8px 0;color:#6B6F80;border-top:1px solid rgba(255,255,255,0.06);">Bedrijf</td>
              <td style="padding:8px 0;color:#EAEDF6;font-weight:600;border-top:1px solid rgba(255,255,255,0.06);">{$company}</td></tr>
          <tr><td style="padding:8px 0;color:#6B6F80;border-top:1px solid rgba(255,255,255,0.06);">E-mail</td>
              <td style="padding:8px 0;border-top:1px solid rgba(255,255,255,0.06);"><a href="mailto:{$email}" style="color:#2ECB6F;text-decoration:none;">{$email}</a></td></tr>
          <tr><td style="padding:8px 0;color:#6B6F80;border-top:1px solid rgba(255,255,255,0.06);">Telefoon</td>
              <td style="padding:8px 0;border-top:1px solid rgba(255,255,255,0.06);"><a href="tel:{$phone}" style="color:#2ECB6F;text-decoration:none;">{$phone}</a></td></tr>
{$serviceRow}
        </table>
      </div>

{$messageRow}
    </div>
    <div style="text-align:center;margin-top:32px;font-size:12px;color:#6B6F80;">
      <p style="margin:0;">&copy; 2026 Automation SeQure | Almere, Nederland</p>
    </div>
  </div>
</body>
</html>
HTML;

$headers  = "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
$headers .= "From: " . SITE_NAME . " <" . SITE_EMAIL . ">\r\n";
$headers .= "Reply-To: {$email}\r\n";

$sent = mail(ADMIN_EMAIL, $subject, $html, $headers);

if (!$sent) {
    error_log("scan.php: mail() failed for contact from {$email}");
}

echo json_encode([
    'success' => true,
    'message' => 'Bericht ontvangen.',
    'mailSent' => $sent
]);
