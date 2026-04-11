<?php
/**
 * Site header with multi-page navigation
 *
 * Variables (set before including):
 *   $current_page — Active page identifier: 'home', 'ai-automatisering', 'gemeenten', 'cases', 'over-ons', 'contact', 'afspraak'
 */

$current_page = isset($current_page) ? $current_page : '';
?>

<!-- Urgency Banner -->
<div class="urgency-bar" id="urgencyBar">
  <div class="container">
    <div class="urgency-inner">
      <span class="urgency-pulse"></span>
      <p><strong id="urgencyPeriod">Deze week:</strong> Nog <strong id="urgencySlots">meerdere plekken</strong> beschikbaar voor een intakegesprek.
        <a href="/afspraak">Plan een kennismaking &rarr;</a>
      </p>
      <button class="urgency-close" id="urgencyClose" aria-label="Sluiten">&times;</button>
    </div>
  </div>
</div>

<!-- Header -->
<header class="header" id="header">
  <div class="container header-inner">
    <a href="/" class="logo" aria-label="Automation SeQure homepage">
      <span class="logo-icon">AS</span>
      <span class="logo-text">Automation <strong>SeQure</strong></span>
    </a>

    <nav class="nav-links" id="navLinks" aria-label="Hoofdnavigatie">

      <!-- AI Automatisering dropdown -->
      <div class="nav-dropdown">
        <button class="nav-dropdown-toggle<?= $current_page === 'ai-automatisering' ? ' active' : '' ?>" aria-expanded="false" aria-haspopup="true">
          AI Automatisering
          <svg class="nav-chevron" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
        </button>
        <div class="nav-dropdown-menu">
          <a href="/ai-automatisering">Overzicht</a>
          <a href="/ai-automatisering#inbox-manager">AI Inbox &amp; Calendar Manager</a>
          <a href="/ai-automatisering#sales-chatbot">AI Sales Chatbot</a>
          <a href="/ai-automatisering#appointment-setter">AI Appointment Setter</a>
          <a href="/ai-automatisering#private-ai">Private AI</a>
          <a href="/ai-automatisering#maatwerk-workflows">Maatwerk Workflows</a>
        </div>
      </div>

      <!-- Gemeenten dropdown -->
      <div class="nav-dropdown">
        <button class="nav-dropdown-toggle<?= $current_page === 'gemeenten' ? ' active' : '' ?>" aria-expanded="false" aria-haspopup="true">
          Gemeenten
          <svg class="nav-chevron" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
        </button>
        <div class="nav-dropdown-menu">
          <a href="/ai-governance-gemeenten">Overzicht</a>
          <a href="/ai-governance-gemeenten#quickscan">AI Quickscan</a>
          <a href="/ai-governance-gemeenten#blueprint">AI Blueprint</a>
          <a href="/ai-governance-gemeenten#compliance">Compliance Service</a>
        </div>
      </div>

      <a href="/cases"<?= $current_page === 'cases' ? ' class="active"' : '' ?>>Cases</a>
      <a href="/over-ons"<?= $current_page === 'over-ons' ? ' class="active"' : '' ?>>Over ons</a>
      <a href="/contact"<?= $current_page === 'contact' ? ' class="active"' : '' ?>>Contact</a>
      <a href="/afspraak" class="nav-cta">Plan een gesprek</a>
    </nav>

    <button class="hamburger" id="hamburger" aria-label="Menu openen" aria-expanded="false">
      <span></span><span></span><span></span>
    </button>
  </div>
</header>
