<?php
$page_title = 'Privacyverklaring | Automation SeQure';
$page_description = 'Privacyverklaring van Automation SeQure — hoe wij omgaan met jouw persoonsgegevens conform de AVG.';
$page_canonical = 'https://automationsequre.nl/privacy';
$current_page = '';
?>
<!DOCTYPE html>
<html lang="nl">
<head>
<?php include 'includes/head.php'; ?>
<style>
    .privacy-page {
      padding-top: calc(var(--header-h) + 60px);
      padding-bottom: 80px;
      min-height: 100vh;
    }
    .privacy-container {
      max-width: 800px;
      margin: 0 auto;
      padding: 0 24px;
    }
    .privacy-container h1 {
      font-family: var(--ff-display);
      font-size: 2.2rem;
      color: var(--text);
      margin-bottom: 8px;
    }
    .privacy-updated {
      color: var(--text-light);
      font-size: 0.9rem;
      margin-bottom: 40px;
    }
    .privacy-container h2 {
      font-family: var(--ff-display);
      font-size: 1.3rem;
      color: var(--text);
      margin-top: 40px;
      margin-bottom: 12px;
    }
    .privacy-container h3 {
      font-size: 1.05rem;
      color: var(--text);
      margin-top: 24px;
      margin-bottom: 8px;
    }
    .privacy-container p,
    .privacy-container li {
      color: var(--text-light);
      font-size: 0.95rem;
      line-height: 1.75;
      margin-bottom: 12px;
    }
    .privacy-container ul {
      padding-left: 24px;
      margin-bottom: 16px;
    }
    .privacy-container li {
      margin-bottom: 6px;
    }
    .privacy-container a {
      color: var(--accent);
      text-decoration: underline;
      text-underline-offset: 2px;
    }
    .privacy-container a:hover {
      color: var(--accent2);
    }
    .privacy-container table {
      width: 100%;
      border-collapse: collapse;
      margin: 16px 0 24px;
      font-size: 0.9rem;
    }
    .privacy-container th,
    .privacy-container td {
      padding: 12px 16px;
      text-align: left;
      border-bottom: 1px solid var(--border);
      color: var(--text-light);
    }
    .privacy-container th {
      color: var(--text);
      font-weight: 600;
      background: rgba(255,255,255,0.03);
    }
    .privacy-highlight {
      background: rgba(108,92,231,0.08);
      border: 1px solid rgba(108,92,231,0.2);
      border-radius: 10px;
      padding: 20px 24px;
      margin: 20px 0;
    }
    .privacy-highlight p {
      margin-bottom: 0;
    }
    @media (max-width: 600px) {
      .privacy-container h1 { font-size: 1.6rem; }
      .privacy-container { padding: 0 16px; }
    }
  </style>
</head>
<body data-page="privacy">

  <!-- ==================== HEADER ==================== -->
  <?php if (file_exists(__DIR__ . '/includes/header.php')): ?>
    <?php include 'includes/header.php'; ?>
  <?php else: ?>
  <header class="header scrolled" id="header">
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
        <li aria-current="page">Privacyverklaring</li>
      </ol>
    </div>
  </nav>

  <!-- ==================== PRIVACY CONTENT ==================== -->
  <main class="privacy-page">
    <div class="privacy-container">

      <h1>Privacyverklaring</h1>
      <p class="privacy-updated">Laatst bijgewerkt: 2 april 2026</p>

      <p>Automation SeQure, gevestigd in Almere, Nederland, is verantwoordelijk voor de verwerking van persoonsgegevens zoals weergegeven in deze privacyverklaring. Wij respecteren jouw privacy en verwerken persoonsgegevens uitsluitend in overeenstemming met de Algemene Verordening Gegevensbescherming (AVG/GDPR) en de Uitvoeringswet AVG (UAVG).</p>

      <h2>1. Contactgegevens</h2>
      <p>Automation SeQure<br>
      Almere, Nederland<br>
      E-mail: <a href="mailto:info@automationsequre.nl">info@automationsequre.nl</a><br>
      Website: <a href="https://automationsequre.nl">automationsequre.nl</a></p>

      <h2>2. Welke gegevens verzamelen wij?</h2>
      <p>Wij verzamelen persoonsgegevens wanneer je een afspraak inplant via onze website of contact met ons opneemt. Dit betreft de volgende categorie&euml;n:</p>

      <table>
        <thead>
          <tr>
            <th>Gegeven</th>
            <th>Doel</th>
            <th>Grondslag</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Voornaam en achternaam</td>
            <td>Identificatie en communicatie</td>
            <td>Toestemming</td>
          </tr>
          <tr>
            <td>Bedrijfsnaam</td>
            <td>Dienstverlening op maat</td>
            <td>Toestemming</td>
          </tr>
          <tr>
            <td>E-mailadres</td>
            <td>Bevestiging en communicatie</td>
            <td>Toestemming</td>
          </tr>
          <tr>
            <td>Telefoonnummer</td>
            <td>Contact voor afspraak</td>
            <td>Toestemming</td>
          </tr>
          <tr>
            <td>Adres (optioneel)</td>
            <td>Dienstverlening en facturatie</td>
            <td>Toestemming</td>
          </tr>
          <tr>
            <td>IP-adres (gehashed)</td>
            <td>Beveiliging en misbruikpreventie</td>
            <td>Gerechtvaardigd belang</td>
          </tr>
        </tbody>
      </table>

      <h2>3. Waarom verwerken wij jouw gegevens?</h2>
      <p>Wij verwerken jouw persoonsgegevens voor de volgende doeleinden:</p>
      <ul>
        <li>Het inplannen en bevestigen van afspraken</li>
        <li>Het versturen van een bevestigingsmail met afspraakdetails</li>
        <li>Het voorkomen van dubbelboekingen</li>
        <li>Het contact opnemen voor het strategiegesprek</li>
        <li>Het beveiligen van onze diensten (misbruikpreventie)</li>
      </ul>

      <h2>4. Rechtsgrond van verwerking</h2>
      <p>De verwerking van jouw persoonsgegevens is gebaseerd op de volgende rechtsgronden uit de AVG:</p>
      <ul>
        <li><strong>Toestemming (Art. 6 lid 1 sub a AVG)</strong> — Je geeft expliciete toestemming bij het inplannen van een afspraak via het aanvinken van de toestemmingsvakje.</li>
        <li><strong>Gerechtvaardigd belang (Art. 6 lid 1 sub f AVG)</strong> — Voor het beschermen van onze diensten tegen misbruik (IP-adres hashing, rate limiting).</li>
      </ul>

      <h2>5. Hoe beschermen wij jouw gegevens?</h2>
      <div class="privacy-highlight">
        <p>Wij nemen de bescherming van jouw gegevens zeer serieus. Alle persoonsgegevens worden versleuteld opgeslagen met AES-256-GCM encryptie. IP-adressen worden uitsluitend als hash opgeslagen, nooit in leesbare vorm. Onze database is niet toegankelijk via het internet.</p>
      </div>
      <p>Aanvullende beveiligingsmaatregelen:</p>
      <ul>
        <li>Versleutelde opslag van alle persoonsgegevens (AES-256-GCM)</li>
        <li>Hashing van IP-adressen en e-mailadressen voor lookups</li>
        <li>Bescherming tegen dubbelboekingen via exclusieve databasetransacties</li>
        <li>Rate limiting om misbruik te voorkomen</li>
        <li>Audit logging van alle data-toegang en wijzigingen</li>
        <li>Beveiligde serveromgeving bij TransIP (Nederland)</li>
      </ul>

      <h2>6. Bewaartermijn</h2>
      <p>Wij bewaren jouw persoonsgegevens niet langer dan noodzakelijk. De bewaartermijn is maximaal <strong>365 dagen</strong> na het aanmaken van de afspraak. Na deze periode worden jouw gegevens automatisch geanonimiseerd en zijn ze niet meer herleidbaar tot jou als persoon.</p>

      <h2>7. Jouw rechten</h2>
      <p>Op grond van de AVG heb je de volgende rechten:</p>
      <ul>
        <li><strong>Recht op inzage (Art. 15)</strong> — Je kunt opvragen welke gegevens wij van jou verwerken.</li>
        <li><strong>Recht op rectificatie (Art. 16)</strong> — Je kunt onjuiste gegevens laten corrigeren.</li>
        <li><strong>Recht op verwijdering (Art. 17)</strong> — Je kunt verzoeken om al jouw gegevens te laten verwijderen ("recht op vergetelheid").</li>
        <li><strong>Recht op beperking (Art. 18)</strong> — Je kunt verzoeken om de verwerking van jouw gegevens te beperken.</li>
        <li><strong>Recht op overdraagbaarheid (Art. 20)</strong> — Je kunt jouw gegevens in een gestructureerd formaat opvragen.</li>
        <li><strong>Recht om toestemming in te trekken (Art. 7)</strong> — Je kunt op elk moment jouw toestemming intrekken.</li>
      </ul>
      <p>Om gebruik te maken van een van deze rechten, stuur een e-mail naar <a href="mailto:info@automationsequre.nl">info@automationsequre.nl</a>. Wij reageren binnen 30 dagen op jouw verzoek, conform de wettelijke termijn.</p>

      <h2>8. Delen met derden</h2>
      <p>Wij delen jouw persoonsgegevens niet met derden, tenzij dit noodzakelijk is voor onze dienstverlening of wij hiertoe wettelijk verplicht zijn. E-mailberichten worden verzonden via de mailserver van onze hostingprovider (TransIP, gevestigd in Nederland).</p>

      <h2>9. Cookies</h2>
      <p>Onze website maakt geen gebruik van tracking cookies of analytische cookies. Wij gebruiken uitsluitend functionele sessie-opslag (sessionStorage) voor het onthouden van gebruikersvoorkeuren tijdens jouw bezoek, zoals het sluiten van de urgentiebanner. Deze data wordt niet opgeslagen op onze servers en verdwijnt na het sluiten van je browser.</p>

      <h2>10. Hosting</h2>
      <p>Onze website en database worden gehost bij TransIP B.V., een Nederlandse hostingprovider. Jouw gegevens worden opgeslagen op servers in Nederland en verlaten de Europese Economische Ruimte (EER) niet.</p>

      <h2>11. Klacht indienen</h2>
      <p>Heb je een klacht over hoe wij met jouw persoonsgegevens omgaan? Neem dan eerst contact met ons op via <a href="mailto:info@automationsequre.nl">info@automationsequre.nl</a>. Komen wij er samen niet uit, dan heb je het recht om een klacht in te dienen bij de Autoriteit Persoonsgegevens (AP):</p>
      <p>Autoriteit Persoonsgegevens<br>
      Postbus 93374, 2509 AJ Den Haag<br>
      <a href="https://autoriteitpersoonsgegevens.nl" target="_blank" rel="noopener">autoriteitpersoonsgegevens.nl</a></p>

      <h2>12. Wijzigingen</h2>
      <p>Wij behouden ons het recht voor om deze privacyverklaring te wijzigen. De meest actuele versie is altijd beschikbaar op deze pagina. Bij ingrijpende wijzigingen stellen wij je hiervan op de hoogte.</p>

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
        "name": "Privacyverklaring",
        "item": "https://automationsequre.nl/privacy"
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
