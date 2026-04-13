<?php
$page_title = 'Gesprek plannen | Automation SeQure — Veilige AI-automatisering';
$page_description = 'Plan een vrijblijvend kennismakingsgesprek van 30 minuten. Bespreek hoe AI-automatisering uw organisatie kan helpen.';
$page_canonical = 'https://automationsequre.nl/afspraak';
$current_page = 'afspraak';
?>
<!DOCTYPE html>
<html lang="nl">
<head>
<?php include 'includes/head.php'; ?>
<link rel="stylesheet" href="/afspraak.css">
</head>
<body data-page="afspraak">

  <?php include 'includes/header.php'; ?>

  <!-- ==================== BREADCRUMB ==================== -->
  <nav class="breadcrumb" aria-label="Breadcrumb">
    <div class="container">
      <ol class="breadcrumb-list">
        <li><a href="/">Home</a></li>
        <li aria-current="page">Gesprek plannen</li>
      </ol>
    </div>
  </nav>

  <!-- ==================== BOOKING MODULE ==================== -->
  <main class="booking-page">
    <div class="booking-container">

      <!-- Left: Info -->
      <div class="booking-info">
        <div class="booking-info-inner">
          <div class="section-label">Gesprek plannen</div>
          <h1>Vrijblijvend kennis&shy;makingsgesprek <span class="gradient-text">van 30 minuten</span></h1>
          <p class="booking-desc">Bespreek hoe AI-automatisering uw organisatie kan helpen. Wij vertellen u concreet hoe wij inbox, agenda, klantprocessen of maatwerk workflows kunnen automatiseren.</p>

          <div class="booking-includes">
            <h3>Wat u kunt verwachten:</h3>
            <ul>
              <li>
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#6C5CE7" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                Verkenning van uw processen en uitdagingen
              </li>
              <li>
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#6C5CE7" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                Eerste inschatting van automatiseringsmogelijkheden
              </li>
              <li>
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#6C5CE7" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                Advies over passende AI-oplossing
              </li>
              <li>
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#6C5CE7" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                Vrijblijvend en zonder verplichtingen
              </li>
            </ul>
          </div>

          <div class="booking-meta">
            <div class="meta-item">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#00D2FF" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
              <span>30 minuten</span>
            </div>
            <div class="meta-item">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#00D2FF" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
              <span>Telefonisch of video</span>
            </div>
            <div class="meta-item">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#00D2FF" stroke-width="2"><path d="M12 22s-8-4.5-8-11.8A8 8 0 0 1 12 2a8 8 0 0 1 8 8.2c0 7.3-8 11.8-8 11.8z"/><circle cx="12" cy="10" r="3"/></svg>
              <span>Kosteloos &amp; vrijblijvend</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Right: Booking wizard -->
      <div class="booking-wizard">

        <!-- Step 1: Calendar + Time -->
        <div class="wizard-step" id="step1">
          <div class="wizard-step-header">
            <div class="step-indicator">
              <span class="step-dot active"></span>
              <span class="step-line"></span>
              <span class="step-dot"></span>
            </div>
            <h2>Kies een datum en tijdstip</h2>
          </div>

          <!-- Calendar -->
          <div class="calendar-wrapper">
            <div class="calendar-nav">
              <button class="cal-nav-btn" id="calPrev" aria-label="Vorige maand">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
              </button>
              <h3 class="cal-month-title" id="calTitle"></h3>
              <button class="cal-nav-btn" id="calNext" aria-label="Volgende maand">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
              </button>
            </div>
            <div class="calendar-grid">
              <div class="cal-day-header">Ma</div>
              <div class="cal-day-header">Di</div>
              <div class="cal-day-header">Wo</div>
              <div class="cal-day-header">Do</div>
              <div class="cal-day-header">Vr</div>
              <div class="cal-day-header cal-weekend">Za</div>
              <div class="cal-day-header cal-weekend">Zo</div>
            </div>
            <div class="calendar-days" id="calDays"></div>
          </div>

          <!-- Time slots -->
          <div class="timeslots-wrapper" id="timeslotsWrapper" style="display:none;">
            <h3 class="timeslots-title">Beschikbare tijden op <span id="selectedDateText"></span></h3>
            <div class="timeslots-grid" id="timeslotsGrid"></div>
          </div>

          <button class="btn btn-primary wizard-next" id="toStep2" disabled>
            Volgende: Gegevens invullen
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
          </button>
        </div>

        <!-- Step 2: Contact details -->
        <div class="wizard-step" id="step2" style="display:none;">
          <div class="wizard-step-header">
            <div class="step-indicator">
              <span class="step-dot completed">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
              </span>
              <span class="step-line active"></span>
              <span class="step-dot active"></span>
            </div>
            <h2>Jouw gegevens</h2>
          </div>

          <div class="selected-slot-banner" id="selectedSlotBanner"></div>

          <!-- Pakketkeuze banner (wordt ingevuld via URL parameter) -->
          <div class="package-banner" id="packageBanner" style="display:none;">
            <span class="package-banner-label">Gekozen pakket:</span>
            <span class="package-banner-name" id="packageName"></span>
          </div>

          <form id="bookingForm" class="booking-form">
            <div class="form-row">
              <div class="form-group">
                <label for="firstName">Voornaam *</label>
                <input type="text" id="firstName" name="firstName" placeholder="Jan" required>
              </div>
              <div class="form-group">
                <label for="lastName">Achternaam *</label>
                <input type="text" id="lastName" name="lastName" placeholder="de Vries" required>
              </div>
            </div>
            <div class="form-group">
              <label for="companyName">Bedrijfsnaam *</label>
              <input type="text" id="companyName" name="companyName" placeholder="Jouw Bedrijf B.V." required>
            </div>
            <div class="form-group">
              <label for="address">Adres</label>
              <input type="text" id="address" name="address" placeholder="Straatnaam 123">
            </div>
            <div class="form-row">
              <div class="form-group">
                <label for="postcode">Postcode</label>
                <input type="text" id="postcode" name="postcode" placeholder="1234 AB">
              </div>
              <div class="form-group">
                <label for="city">Plaats</label>
                <input type="text" id="city" name="city" placeholder="Almere">
              </div>
            </div>
            <div class="form-row">
              <div class="form-group">
                <label for="bookEmail">E-mailadres *</label>
                <input type="email" id="bookEmail" name="email" placeholder="jan@bedrijf.nl" required>
              </div>
              <div class="form-group">
                <label for="bookPhone">Telefoonnummer *</label>
                <input type="tel" id="bookPhone" name="phone" placeholder="+31 6 1234 5678" required>
              </div>
            </div>
            <div class="form-group">
              <label for="bookService">Waar heeft u interesse in?</label>
              <select id="bookService" name="service">
                <option value="">Selecteer een optie</option>
                <optgroup label="AI Automatisering">
                  <option value="inbox-calendar">AI Inbox &amp; Calendar Manager</option>
                  <option value="appointment-setter">AI Appointment Setter</option>
                  <option value="sales-chatbot">AI Sales Chatbot</option>
                  <option value="private-ai">Private / On-Premise AI</option>
                  <option value="maatwerk-workflows">Maatwerk Automation Workflows</option>
                </optgroup>
                <optgroup label="AI Governance &amp; Compliance">
                  <option value="ai-governance-quickscan">AI Governance Quickscan</option>
                  <option value="ai-governance-blueprint">AI Governance Blueprint</option>
                  <option value="ai-compliance-service">Compliance Service</option>
                </optgroup>
                <option value="anders">Iets anders / Weet ik nog niet</option>
              </select>
            </div>

            <div class="form-group consent-group">
              <label class="consent-label">
                <input type="checkbox" id="privacyConsent" name="privacyConsent" required>
                <span class="consent-check"></span>
                <span class="consent-text">Ik ga akkoord met de <a href="/privacy" target="_blank">privacyverklaring</a> en geef toestemming voor het verwerken van mijn gegevens conform de AVG. *</span>
              </label>
            </div>

            <div class="form-actions">
              <button type="button" class="btn btn-outline" id="backToStep1">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
                Terug
              </button>
              <button type="submit" class="btn btn-primary">
                Afspraak bevestigen
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
              </button>
            </div>
          </form>
        </div>

        <!-- Step 3: Confirmation -->
        <div class="wizard-step" id="step3" style="display:none;">
          <div class="confirmation-screen">
            <div class="confirm-icon">
              <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#00E676" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="9 12 11.5 14.5 16 9"/></svg>
            </div>
            <h2>Afspraak bevestigd!</h2>
            <p class="confirm-detail" id="confirmDetail"></p>
            <p class="confirm-email">Een bevestiging is verstuurd naar <strong id="confirmEmail"></strong></p>
            <div class="confirm-summary" id="confirmSummary"></div>
            <a href="/" class="btn btn-outline" style="margin-top:32px;">Terug naar de website</a>
          </div>
        </div>

      </div>
    </div>
  </main>

  <!-- ==================== FOOTER ==================== -->
  <?php if (file_exists(__DIR__ . '/includes/footer.php')): ?>
    <?php include 'includes/footer.php'; ?>
  <?php else: ?>
  <footer class="footer">
    <div class="container">
      <div class="footer-inner">
        <div class="footer-logo">Automation <span>SeQure</span></div>
        <ul class="footer-links">
          <li><a href="/">Home</a></li>
          <li><a href="/ai-automatisering">Diensten</a></li>
          <li><a href="/contact">Contact</a></li>
          <li><a href="/privacy">Privacyverklaring</a></li>
        </ul>
      </div>
      <div class="footer-bottom">
        &copy; <?= date('Y') ?> Automation SeQure. Alle rechten voorbehouden.
      </div>
    </div>
  </footer>
  <?php endif; ?>

  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "BreadcrumbList",
    "itemListElement": [
      {
        "@type": "ListItem",
        "position": 1,
        "name": "Home",
        "item": "https://automationsequre.nl/"
      },
      {
        "@type": "ListItem",
        "position": 2,
        "name": "Gesprek plannen",
        "item": "https://automationsequre.nl/afspraak"
      }
    ]
  }
  </script>

  <?php if (file_exists(__DIR__ . '/includes/schema.php')): ?>
    <?php include 'includes/schema.php'; ?>
  <?php endif; ?>

  <script src="/script.js"></script>
  <script src="/afspraak.js"></script>
</body>
</html>
