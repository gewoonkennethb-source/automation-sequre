<?php
$page_title = 'Over Automation SeQure';
$page_description = 'Automation SeQure: cybersecurity-specialisten die AI-automatisering en AI governance veilig implementeren voor bedrijven en gemeenten.';
$page_canonical = 'https://automationsequre.nl/over-ons';
$current_page = 'over-ons';
?>
<!DOCTYPE html>
<html lang="nl">
<head>
<?php include 'includes/head.php'; ?>
</head>
<body data-page="over-ons">

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
        <a href="/over-ons" class="active">Over ons</a>
        <a href="/contact">Contact</a>
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
        <li aria-current="page">Over ons</li>
      </ol>
    </div>
  </nav>

  <!-- ==================== HERO ==================== -->
  <section class="hero" id="hero">
    <div class="hero-glow"></div>
    <div class="container hero-content">
      <span class="hero-label">Over Automation SeQure</span>
      <h1 class="hero-headline">Veilige AI, gebouwd door security-specialisten</h1>
      <p class="hero-sub">Wij combineren jarenlange ervaring in cybersecurity met praktische AI-expertise. Zo helpen we bedrijven en gemeenten om AI veilig, verantwoord en resultaatgericht in te zetten.</p>
    </div>
  </section>

  <!-- ==================== MISSIE ==================== -->
  <section class="waarom-wij" id="missie">
    <div class="container">
      <div class="section-header reveal">
        <span class="section-label">Onze missie</span>
        <h2 class="section-title">De kloof dichten tussen AI-potentieel en veiligheid</h2>
      </div>
      <div class="analyse-wrapper reveal" style="max-width: 800px; margin: 0 auto;">
        <div class="analyse-content">
          <p>AI biedt enorme kansen voor productiviteit, klanttevredenheid en proceseffici&euml;ntie. Maar zonder de juiste beveiligings- en governancemaatregelen ontstaan risico's die organisaties kwetsbaar maken.</p>
          <p>Automation SeQure is opgericht vanuit de overtuiging dat AI pas echt waarde levert als het veilig is ingericht. Wij bouwen oplossingen die niet alleen slim zijn, maar ook betrouwbaar, transparant en compliant.</p>
          <p>Of het nu gaat om een ondernemer die zijn inbox wil automatiseren of een gemeente die grip wil krijgen op AI-gebruik binnen de organisatie: wij leveren werkende oplossingen met security als fundament.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- ==================== WAARDEN / PIJLERS ==================== -->
  <section class="diensten" id="waarden">
    <div class="container">
      <div class="section-header reveal">
        <span class="section-label">Onze waarden</span>
        <h2 class="section-title">Waar wij voor staan</h2>
      </div>
      <div class="reasons-grid reveal">
        <div class="reason-card">
          <div class="reason-icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
          </div>
          <h3>Security-first</h3>
          <p>Elke oplossing begint met beveiliging. Wij bouwen AI-automatiseringen die voldoen aan de hoogste eisen op het gebied van dataveiligheid, privacy en compliance. Geen concessies.</p>
        </div>
        <div class="reason-card">
          <div class="reason-icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
          </div>
          <h3>Resultaatgericht</h3>
          <p>Geen theorie, maar werkende oplossingen. Wij leveren meetbaar resultaat: tijdswinst, hogere conversie, minder handmatig werk. U merkt het verschil vanaf dag &eacute;&eacute;n.</p>
        </div>
        <div class="reason-card">
          <div class="reason-icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
          </div>
          <h3>Maatwerk</h3>
          <p>Geen standaardpakketten, maar oplossingen op maat. Wij ontwerpen automatiseringen die aansluiten op uw bestaande processen, tools en organisatiestructuur.</p>
        </div>
        <div class="reason-card">
          <div class="reason-icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
          </div>
          <h3>Transparant</h3>
          <p>Duidelijke processen, geen verborgen kosten. U weet altijd wat wij doen, waarom wij het doen en wat het oplevert. Heldere communicatie van intake tot oplevering.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- ==================== TEAM / FOUNDER ==================== -->
  <section class="oplossing" id="team">
    <div class="container">
      <div class="section-header reveal">
        <span class="section-label">Ons team</span>
        <h2 class="section-title">Cybersecurity-expertise meets AI-innovatie</h2>
      </div>
      <div class="solution-grid reveal" style="max-width: 800px; margin: 0 auto;">
        <div class="solution-card" style="grid-column: 1 / -1;">
          <div class="solution-icon">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
          </div>
          <h3>Achtergrond in cybersecurity</h3>
          <p>Automation SeQure is opgericht door specialisten met een achtergrond in cybersecurity en IT-governance. Die ervaring vormt de basis van alles wat wij bouwen: AI-oplossingen die niet alleen slim zijn, maar ook veilig en compliant.</p>
          <p>Wij werken met een klein, gespecialiseerd team en schakelen waar nodig experts in op het gebied van AI-engineering, privacywetgeving en procesoptimalisatie. Zo combineren we snelheid met diepgang.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- ==================== WAAROM KLANTEN KIEZEN ==================== -->
  <section class="waarom-wij" id="waarom">
    <div class="container">
      <div class="section-header reveal">
        <span class="section-label">Het verschil</span>
        <h2 class="section-title">Waarom organisaties kiezen voor Automation SeQure</h2>
      </div>
      <div class="reasons-grid reveal">
        <div class="reason-card">
          <div class="reason-icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
          </div>
          <h3>Focus op businessresultaat</h3>
          <p>Geen technisch jargon of eindeloze trajecten. Wij leveren werkende oplossingen die direct tijdswinst, betere opvolging en lagere werkdruk opleveren.</p>
        </div>
        <div class="reason-card">
          <div class="reason-icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
          </div>
          <h3>Veilige implementaties</h3>
          <p>Security-first benadering. Cloud &eacute;n private AI mogelijk. Data-minimalisatie, afgeschermde omgevingen en integratie met bestaande systemen zonder concessies aan veiligheid.</p>
        </div>
        <div class="reason-card">
          <div class="reason-icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><polyline points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
          </div>
          <h3>Maatwerk op uw processen</h3>
          <p>Geen standaardoplossing die u moet aanpassen. Wij ontwerpen automatiseringen die passen op uw bestaande werkwijze, tools en proceslandschap.</p>
        </div>
        <div class="reason-card">
          <div class="reason-icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
          </div>
          <h3>Cybersecurity-minded aanpak</h3>
          <p>Wij combineren AI-expertise met een security-achtergrond. Elke oplossing wordt gebouwd met oog voor dataveiligheid, privacywetgeving en risicobeheer.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- ==================== CTA ==================== -->
  <section class="slot-cta">
    <div class="container">
      <div class="section-header reveal">
        <h2 class="section-title">Plan een kennismaking</h2>
        <p class="section-intro">Wilt u weten hoe wij uw organisatie kunnen helpen met veilige AI-automatisering of AI governance? Neem vrijblijvend contact op voor een kennismakingsgesprek.</p>
      </div>
      <div class="hero-buttons reveal">
        <a href="/afspraak" class="btn btn-primary">Plan een gesprek
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </a>
        <a href="/cases" class="btn btn-outline">Bekijk onze cases</a>
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
    "@type": "AboutPage",
    "name": "Over Automation SeQure",
    "description": "Automation SeQure: cybersecurity-specialisten die AI-automatisering en AI governance veilig implementeren voor bedrijven en gemeenten.",
    "url": "https://automationsequre.nl/over-ons",
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
        "name": "Over ons",
        "item": "https://automationsequre.nl/over-ons"
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
