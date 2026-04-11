<?php
$page_title = 'Kennisbank';
$page_description = 'Artikelen en inzichten over AI-automatisering en AI governance voor bedrijven en gemeenten.';
$page_canonical = 'https://automationsequre.nl/kennisbank';
$current_page = '';
?>
<!DOCTYPE html>
<html lang="nl">
<head>
<?php include '../includes/head.php'; ?>
</head>
<body data-page="kennisbank">

  <!-- ==================== HEADER ==================== -->
  <?php if (file_exists(__DIR__ . '/../includes/header.php')): ?>
    <?php include '../includes/header.php'; ?>
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
        <li aria-current="page">Kennisbank</li>
      </ol>
    </div>
  </nav>

  <!-- ==================== PAGE HEADER ==================== -->
  <section class="page-header page-header--neutral">
    <div class="container">
      <div class="page-header__content">
        <h1 class="page-header__title">Kennisbank</h1>
        <p class="page-header__subtitle">Artikelen en inzichten over AI-automatisering en AI governance voor bedrijven en gemeenten.</p>
      </div>
    </div>
  </section>

  <!-- ==================== CONTENT ==================== -->
  <section class="section" style="padding: var(--section-y) 0;">
    <div class="container">
      <div class="card" style="background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); padding: var(--card-pad); max-width: 720px;">
        <p style="font-size: 1.05rem; color: var(--text); line-height: 1.7; margin-bottom: 32px;">
          Binnenkort verschijnen hier artikelen over AI-automatisering en AI governance.
        </p>

        <h2 style="font-size: var(--h3); margin-bottom: 16px;">Aanbevolen pagina's</h2>
        <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 12px;">
          <li>
            <a href="/ai-automatisering" style="display: inline-flex; align-items: center; gap: 8px; font-weight: 500; color: var(--accent); transition: var(--ease-fast);">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
              AI Automatisering voor bedrijven
            </a>
          </li>
          <li>
            <a href="/ai-governance-gemeenten" style="display: inline-flex; align-items: center; gap: 8px; font-weight: 500; color: var(--accent2); transition: var(--ease-fast);">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
              AI Governance voor gemeenten
            </a>
          </li>
        </ul>
      </div>
    </div>
  </section>

  <!-- ==================== FOOTER ==================== -->
  <?php if (file_exists(__DIR__ . '/../includes/footer.php')): ?>
    <?php include '../includes/footer.php'; ?>
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
    "name": "Kennisbank - Automation SeQure",
    "description": "Artikelen en inzichten over AI-automatisering en AI governance voor bedrijven en gemeenten.",
    "url": "https://automationsequre.nl/kennisbank",
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
        "name": "Kennisbank",
        "item": "https://automationsequre.nl/kennisbank"
      }
    ]
  }
  </script>

  <?php if (file_exists(__DIR__ . '/../includes/schema.php')): ?>
    <?php include '../includes/schema.php'; ?>
  <?php endif; ?>

  <script src="/script.js"></script>
</body>
</html>
