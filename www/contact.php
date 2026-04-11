<?php
$page_title = 'Contact';
$page_description = 'Neem contact op met Automation SeQure. Plan een vrijblijvend gesprek of stel uw vraag over AI-automatisering en AI governance.';
$page_canonical = 'https://automationsequre.nl/contact';
$current_page = 'contact';
?>
<!DOCTYPE html>
<html lang="nl">
<head>
<?php include 'includes/head.php'; ?>
</head>
<body data-page="contact">

  <!-- ==================== HEADER ==================== -->
  <?php if (file_exists(__DIR__ . '/includes/header.php')): ?>
    <?php include 'includes/header.php'; ?>
  <?php else: ?>
  <header class="header" id="header">
    <div class="container header-inner">
      <a href="/" class="logo" aria-label="Automation SeQure homepage">
        <span class="logo-icon">AS</span>
        <span class="logo-text">Automation <strong>SeQure</strong></span>
      </a>
      <nav class="nav-links" id="navLinks" aria-label="Hoofdnavigatie">
        <a href="/ai-automatisering">AI Automatisering</a>
        <a href="/ai-governance-gemeenten">Gemeenten</a>
        <a href="/cases">Cases</a>
        <a href="/over-ons">Over ons</a>
        <a href="/contact" class="active">Contact</a>
        <a href="/afspraak" class="nav-cta">Plan een gesprek</a>
      </nav>
      <button class="hamburger" id="hamburger" aria-label="Menu openen" aria-expanded="false">
        <span></span><span></span><span></span>
      </button>
    </div>
  </header>
  <?php endif; ?>

  <!-- ==================== BREADCRUMB ==================== -->
  <nav class="breadcrumb" aria-label="Breadcrumb">
    <div class="container">
      <ol class="breadcrumb-list">
        <li><a href="/">Home</a></li>
        <li aria-current="page">Contact</li>
      </ol>
    </div>
  </nav>

  <!-- ==================== PAGE HEADER ==================== -->
  <section class="hero" id="hero">
    <div class="hero-glow"></div>
    <div class="container hero-content">
      <span class="hero-label">Contact</span>
      <h1 class="hero-headline">Neem contact met ons op</h1>
      <p class="hero-sub">Heeft u een vraag over onze diensten, wilt u een vrijblijvend gesprek plannen of bent u benieuwd wat AI voor uw organisatie kan betekenen? Wij helpen u graag verder.</p>
    </div>
  </section>

  <!-- ==================== CONTACT CONTENT ==================== -->
  <section class="analyse" id="contact-content">
    <div class="container">
      <div class="analyse-wrapper reveal">

        <!-- Left column: contact info -->
        <div class="analyse-content">
          <h2>Rechtstreeks contact</h2>

          <div class="results-list" style="margin-bottom: 2rem;">
            <div class="result-item">
              <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
              <span><a href="mailto:info@automationsequre.nl">info@automationsequre.nl</a></span>
            </div>
            <div class="result-item">
              <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
              <span>Almere, Nederland</span>
            </div>
            <div class="result-item">
              <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
              <span>Reactie binnen 2 werkdagen</span>
            </div>
          </div>

          <h3>Direct naar de juiste pagina</h3>
          <ul class="analyse-list">
            <li>
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
              <a href="/ai-automatisering">AI Automatisering voor bedrijven</a>
            </li>
            <li>
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
              <a href="/ai-governance-gemeenten">AI Governance voor gemeenten</a>
            </li>
            <li>
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
              <a href="/afspraak">Direct een gesprek inplannen</a>
            </li>
          </ul>

          <div style="margin-top: 2rem;">
            <h3>Veelgestelde vragen?</h3>
            <p>Bekijk onze pagina's voor meer informatie:</p>
            <ul class="analyse-list">
              <li>
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                <a href="/ai-automatisering">AI Automatisering &mdash; diensten, werkwijze en FAQ</a>
              </li>
              <li>
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                <a href="/ai-governance-gemeenten">AI Governance &mdash; trajecten en veelgestelde vragen</a>
              </li>
            </ul>
          </div>
        </div>

        <!-- Right column: contact form -->
        <form class="analyse-form" id="contactForm" novalidate>
          <h3>Stuur ons een bericht</h3>
          <p class="form-trust">We nemen binnen 2 werkdagen contact op. Vrijblijvend.</p>
          <div class="form-group">
            <label for="contactName">Naam</label>
            <input type="text" id="contactName" name="name" placeholder="Uw volledige naam" required>
          </div>
          <div class="form-group">
            <label for="contactCompany">Bedrijfsnaam</label>
            <input type="text" id="contactCompany" name="company" placeholder="Naam van uw organisatie" required>
          </div>
          <div class="form-group">
            <label for="contactEmail">E-mailadres</label>
            <input type="email" id="contactEmail" name="email" placeholder="naam@bedrijf.nl" required>
          </div>
          <div class="form-group">
            <label for="contactPhone">Telefoonnummer</label>
            <input type="tel" id="contactPhone" name="phone" placeholder="06 - 12345678">
          </div>
          <div class="form-group">
            <label for="contactService">Type oplossing</label>
            <select id="contactService" name="service">
              <option value="">Selecteer een optie</option>
              <option value="inbox-calendar">AI Inbox &amp; Calendar Manager</option>
              <option value="appointment-setter">AI Appointment Setter</option>
              <option value="sales-chatbot">AI Sales Chatbot</option>
              <option value="private-ai">Private / On-Premise AI</option>
              <option value="maatwerk-workflows">Maatwerk Automation Workflows</option>
              <option value="governance">AI Governance &amp; Compliance</option>
              <option value="anders">Anders / weet ik nog niet</option>
            </select>
          </div>
          <div class="form-group">
            <label for="contactMessage">Korte beschrijving van uw vraag</label>
            <textarea id="contactMessage" name="message" rows="4" placeholder="Waar kunnen wij u mee helpen?"></textarea>
          </div>
          <button type="submit" class="btn btn-primary btn-full">Verstuur bericht
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
          </button>
          <p class="form-privacy">Uw gegevens worden niet gedeeld. <a href="/privacy">Privacyverklaring</a></p>
          <div class="form-feedback" id="contactFeedback" style="display:none;"></div>
        </form>

      </div>
    </div>
  </section>

  <!-- ==================== FOOTER ==================== -->
  <?php if (file_exists(__DIR__ . '/includes/footer.php')): ?>
    <?php include 'includes/footer.php'; ?>
  <?php else: ?>
  <footer class="footer">
    <div class="container">
      <div class="footer-bottom">
        <p>&copy; <?= date('Y') ?> Automation SeQure. Alle rechten voorbehouden.</p>
      </div>
    </div>
  </footer>
  <?php endif; ?>

  <!-- ==================== SCHEMA ==================== -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "ContactPage",
    "name": "Contact - Automation SeQure",
    "description": "Neem contact op met Automation SeQure. Plan een vrijblijvend gesprek of stel uw vraag over AI-automatisering en AI governance.",
    "url": "https://automationsequre.nl/contact",
    "inLanguage": "nl-NL",
    "isPartOf": {
      "@type": "WebSite",
      "name": "Automation SeQure",
      "url": "https://automationsequre.nl"
    }
  }
  </script>

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
        "name": "Contact",
        "item": "https://automationsequre.nl/contact"
      }
    ]
  }
  </script>

  <?php if (file_exists(__DIR__ . '/includes/schema.php')): ?>
    <?php include 'includes/schema.php'; ?>
  <?php endif; ?>

  <script src="/script.js"></script>
</body>
</html>
