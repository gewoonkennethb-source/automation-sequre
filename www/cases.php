<?php
$page_title = 'Cases en resultaten';
$page_description = 'Bekijk hoe bedrijven en gemeenten resultaat boeken met AI-automatisering en AI governance van Automation SeQure.';
$page_canonical = 'https://automationsequre.nl/cases';
$current_page = 'cases';
?>
<!DOCTYPE html>
<html lang="nl">
<head>
<?php include 'includes/head.php'; ?>
</head>
<body data-page="cases">

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
        <a href="/cases" class="active">Cases</a>
        <a href="/over-ons">Over ons</a>
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
        <li aria-current="page">Cases</li>
      </ol>
    </div>
  </nav>

  <!-- ==================== PAGE HEADER ==================== -->
  <section class="hero" id="hero">
    <div class="hero-glow"></div>
    <div class="container hero-content">
      <span class="hero-label">Cases &middot; AI Automatisering &middot; AI Governance</span>
      <h1 class="hero-headline">Resultaten uit de praktijk</h1>
      <p class="hero-sub">Van gemeenten die grip krijgen op AI-gebruik tot ondernemers die uren per week terugwinnen. Bekijk hoe organisaties concreet resultaat boeken met onze AI-oplossingen.</p>
    </div>
  </section>

  <!-- ==================== FILTER BUTTONS ==================== -->
  <section class="cases-filter-section">
    <div class="container">
      <div class="cases-filter reveal">
        <button class="filter-btn active" data-filter="all">Alle</button>
        <button class="filter-btn" data-filter="ai-automatisering">AI Automatisering</button>
        <button class="filter-btn" data-filter="ai-governance">AI Governance</button>
      </div>
    </div>
  </section>

  <!-- ==================== CASES ==================== -->
  <section class="cases" id="cases-overview">
    <div class="container">
      <div class="cases-grid reveal">

        <!-- Case 1: Middelgrote gemeente — governance quickscan -->
        <div class="case-card" data-route="ai-governance">
          <div class="case-industry">Middelgrote gemeente, 800 medewerkers</div>
          <div class="case-phase">
            <span class="case-label">Situatie</span>
            <p>Meerdere afdelingen gebruikten AI-tools zonder centraal overzicht. De gemeentesecretaris kon bij raadsvragen niet aantonen welke AI-toepassingen er draaiden en hoe risico's werden beheerst.</p>
          </div>
          <div class="case-phase">
            <span class="case-label case-label--accent">Aanpak</span>
            <p>AI-inventarisatie uitgevoerd over alle afdelingen. Risicoclassificatie per toepassing. Governanceproces ingericht met intake, toetsing en rapportageformat voor het bestuur.</p>
          </div>
          <div class="case-phase">
            <span class="case-label case-label--success">Resultaat</span>
            <p>Volledig overzicht in 3 weken. Bestuur kan verantwoord AI-gebruik aantonen. Nieuw intakeproces voorkomt ongecontroleerde inzet van AI.</p>
          </div>
        </div>

        <!-- Case 2: Kleine gemeente — governance/compliance -->
        <div class="case-card" data-route="ai-governance">
          <div class="case-industry">Kleine gemeente, 200 medewerkers</div>
          <div class="case-phase">
            <span class="case-label">Situatie</span>
            <p>De FG signaleerde dat medewerkers generatieve AI gebruikten met persoonsgegevens. Er was geen beleid, geen intake en geen zicht op de omvang.</p>
          </div>
          <div class="case-phase">
            <span class="case-label case-label--accent">Aanpak</span>
            <p>Quickscan uitgevoerd. AI-beleid opgesteld. Eenvoudig intakeformulier ingericht voor nieuwe AI-use-cases. Rapportageformat opgeleverd voor verantwoording richting bestuur.</p>
          </div>
          <div class="case-phase">
            <span class="case-label case-label--success">Resultaat</span>
            <p>Binnen 4 weken helder AI-beleid en werkend intakeproces. Privacy officer heeft grip. Bestuur is ge&iuml;nformeerd.</p>
          </div>
        </div>

        <!-- Case 3: CEO MKB-bedrijf — inbox/calendar automation -->
        <div class="case-card" data-route="ai-automatisering">
          <div class="case-industry">CEO van een groeiend MKB-bedrijf</div>
          <div class="case-phase">
            <span class="case-label">Situatie</span>
            <p>De CEO besteedde dagelijks 2-3 uur aan het handmatig verwerken van e-mails, het bijhouden van follow-ups en het structureren van zijn agenda. Belangrijke berichten bleven liggen.</p>
          </div>
          <div class="case-phase">
            <span class="case-label case-label--accent">Aanpak</span>
            <p>AI Inbox &amp; Calendar Manager ingericht. E-mails worden automatisch geprioriteerd, conceptantwoorden voorbereid en follow-ups bewaakt. Agenda wordt gestructureerd met urgente signaleringen.</p>
          </div>
          <div class="case-phase">
            <span class="case-label case-label--success">Resultaat</span>
            <p>8 uur tijdswinst per week. Snellere opvolging, minder gemiste berichten en meer focus op strategische taken.</p>
          </div>
        </div>

        <!-- Case 4: Groeiend servicebedrijf — lead management -->
        <div class="case-card" data-route="ai-automatisering">
          <div class="case-industry">Dienstverlener met hoog leadvolume</div>
          <div class="case-phase">
            <span class="case-label">Situatie</span>
            <p>Inbound leads via website en WhatsApp werden te laat of helemaal niet beantwoord. Het team had geen capaciteit voor snelle opvolging buiten kantooruren.</p>
          </div>
          <div class="case-phase">
            <span class="case-label case-label--accent">Aanpak</span>
            <p>AI Sales Chatbot en Appointment Setter ingezet. Leads worden 24/7 gekwalificeerd, vragen beantwoord en afspraken automatisch ingepland in de agenda van het salesteam.</p>
          </div>
          <div class="case-phase">
            <span class="case-label case-label--success">Resultaat</span>
            <p>40% meer ingeplande afspraken. Gemiddelde reactietijd van uren naar seconden. Geen extra personeel nodig.</p>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- ==================== CTA ==================== -->
  <section class="slot-cta">
    <div class="container">
      <div class="section-header reveal">
        <h2 class="section-title">Benieuwd wat wij voor uw organisatie kunnen betekenen?</h2>
        <p class="section-intro">Iedere organisatie is anders. In een vrijblijvend gesprek brengen we samen in kaart waar de meeste impact zit en hoe wij u kunnen helpen.</p>
      </div>
      <div class="hero-buttons reveal">
        <a href="/afspraak" class="btn btn-primary">Plan een kennismaking
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </a>
        <a href="/contact" class="btn btn-outline">Neem contact op</a>
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
    "@type": "CollectionPage",
    "name": "Cases en resultaten",
    "description": "Bekijk hoe bedrijven en gemeenten resultaat boeken met AI-automatisering en AI governance van Automation SeQure.",
    "url": "https://automationsequre.nl/cases",
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
        "name": "Cases",
        "item": "https://automationsequre.nl/cases"
      }
    ]
  }
  </script>

  <?php if (file_exists(__DIR__ . '/includes/schema.php')): ?>
    <?php include 'includes/schema.php'; ?>
  <?php endif; ?>

  <!-- ==================== FILTER SCRIPT ==================== -->
  <script>
  (function() {
    var filterBtns = document.querySelectorAll('.filter-btn');
    var cards = document.querySelectorAll('.case-card[data-route]');

    filterBtns.forEach(function(btn) {
      btn.addEventListener('click', function() {
        filterBtns.forEach(function(b) { b.classList.remove('active'); });
        btn.classList.add('active');
        var filter = btn.getAttribute('data-filter');

        cards.forEach(function(card) {
          if (filter === 'all' || card.getAttribute('data-route') === filter) {
            card.style.display = '';
          } else {
            card.style.display = 'none';
          }
        });
      });
    });
  })();
  </script>

  <script src="/script.js"></script>
</body>
</html>
