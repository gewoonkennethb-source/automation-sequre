<?php
$page_title = 'AI Automatisering voor bedrijven | Automation SeQure';
$page_description = 'Automatiseer inbox, agenda, klantcontact en leadopvolging met veilige AI. Direct resultaat voor ondernemers en MKB.';
$page_canonical = 'https://automationsequre.nl/ai-automatisering';
$current_page = 'automatisering';
?>
<!DOCTYPE html>
<html lang="nl">
<head>
<?php include 'includes/head.php'; ?>
</head>
<body data-page="automatisering">

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
        <a href="/#diensten">Diensten</a>
        <a href="/#werkwijze">Werkwijze</a>
        <a href="/#resultaten">Resultaten</a>
        <a href="/#pakketten">Pakketten</a>
        <a href="/#faq">FAQ</a>
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
        <li aria-current="page">AI Automatisering</li>
      </ol>
    </div>
  </nav>

  <!-- ==================== HERO ==================== -->
  <section class="hero" id="hero">
    <div class="hero-glow"></div>
    <div class="container hero-content">
      <span class="hero-label">AI Automatisering voor bedrijven</span>
      <h1 class="hero-headline">AI-automatisering die uw bedrijf direct tijd bespaart</h1>
      <p class="hero-sub">Automatiseer uw inbox, agenda, klantcontact en leadopvolging met veilige AI-oplossingen. Minder handmatig werk, snellere opvolging en meer focus op wat er toe doet. Gebouwd voor ondernemers, directieleden en groeiende MKB-bedrijven.</p>
      <div class="hero-buttons">
        <a href="/afspraak?pakket=automatisering" class="btn btn-primary">Plan een intake
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </a>
        <a href="#werkwijze" class="btn btn-outline">Bekijk onze aanpak</a>
      </div>
      <div class="trust-bar">
        <div class="trust-item">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
          <span>5 tot 10 uur tijdswinst per week</span>
        </div>
        <div class="trust-item">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
          <span>Cloud &eacute;n private AI mogelijk</span>
        </div>
        <div class="trust-item">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
          <span>Security-first, AVG-compliant</span>
        </div>
      </div>
    </div>
  </section>

  <!-- ==================== PROBLEEMHERKENNING ==================== -->
  <section class="probleem" id="probleem">
    <div class="container">
      <div class="section-header reveal">
        <span class="section-label">Herkenbaar?</span>
        <h2 class="section-title">Uw tijd gaat op aan werk dat slimmer kan.</h2>
        <p class="section-intro">Ondernemers, directieleden en MKB-teams lopen dagelijks tegen dezelfde knelpunten aan. Handmatig werk dat tijd kost, leads die blijven liggen en processen die niet meeschalen met de groei.</p>
      </div>
      <div class="pain-list reveal">
        <div class="pain-item">
          <div class="pain-icon">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
          </div>
          <span>Inbox overload: belangrijke e-mails verdwijnen tussen de ruis, opvolging loopt vertraging op</span>
        </div>
        <div class="pain-item">
          <div class="pain-icon">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
          </div>
          <span>Te veel handmatig opvolgwerk tussen mailbox, agenda, CRM en interne processen</span>
        </div>
        <div class="pain-item">
          <div class="pain-icon">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
          </div>
          <span>Gemiste leads en trage reactietijden omdat er geen geautomatiseerde opvolging is</span>
        </div>
        <div class="pain-item">
          <div class="pain-icon">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
          </div>
          <span>Repetitieve processen die tijd kosten maar niet schalen met de groei van uw organisatie</span>
        </div>
        <div class="pain-item">
          <div class="pain-icon">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
          </div>
          <span>Zorgen over privacy en security bij het inzetten van AI-tools met bedrijfsgevoelige data</span>
        </div>
      </div>
      <p class="probleem-closing reveal">Losse AI-tools zijn niet het antwoord. Wat nodig is: <strong>veilige, op maat gemaakte automatiseringen die aansluiten op uw bestaande processen</strong>.</p>
    </div>
  </section>

  <!-- ==================== DIENSTEN ==================== -->
  <section class="diensten" id="diensten">
    <div class="container">
      <div class="section-header reveal">
        <span class="section-label">Onze diensten</span>
        <h2 class="section-title">Vijf AI-oplossingen die direct resultaat leveren</h2>
        <p class="section-intro">Elke oplossing wordt op maat ingericht op uw processen, tools en werkwijze. Veilig, schaalbaar en zonder technische kennis te gebruiken.</p>
      </div>

      <!-- Dienst 1: AI Inbox & Calendar Manager -->
      <div class="service-detail reveal" id="inbox-manager">
        <div class="service-detail-header">
          <div class="service-icon">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
          </div>
          <h3>AI Inbox &amp; Calendar Manager</h3>
        </div>
        <p class="service-detail-desc">Uw inbox en agenda worden automatisch georganiseerd door AI. E-mails worden geprioriteerd, conceptantwoorden voorbereid en follow-ups bewaakt. Uw agenda wordt gestructureerd met urgente signaleringen, zodat u zich kunt richten op wat er toe doet.</p>
        <ul class="service-detail-features">
          <li>Automatisch categoriseren en prioriteren van inkomende e-mails</li>
          <li>Conceptantwoorden genereren op basis van uw schrijfstijl</li>
          <li>Follow-up bewaking: geen e-mail valt meer tussen wal en schip</li>
          <li>Agenda-optimalisatie met urgente signaleringen</li>
          <li>Integratie met Outlook, Gmail en Microsoft 365</li>
        </ul>
        <div class="service-detail-usecase">
          <strong>Voorbeeld:</strong> Een CEO besteedde dagelijks 2-3 uur aan inbox en agenda. Na implementatie bespaart hij 8 uur per week en mist geen belangrijke berichten meer.
        </div>
        <a href="/afspraak?pakket=automatisering&dienst=inbox-calendar" class="btn btn-outline">Meer weten over Inbox &amp; Calendar Manager &rarr;</a>
      </div>

      <!-- Dienst 2: AI Sales Chatbot -->
      <div class="service-detail reveal" id="sales-chatbot">
        <div class="service-detail-header">
          <div class="service-icon">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
          </div>
          <h3>AI Sales Chatbot</h3>
        </div>
        <p class="service-detail-desc">Een AI-chatbot die uw leads 24/7 kwalificeert via uw website, WhatsApp of social media. Vragen worden direct beantwoord, interesse wordt vastgelegd en warme leads worden doorgestuurd naar uw salesteam. Zonder extra personeel.</p>
        <ul class="service-detail-features">
          <li>24/7 leadkwalificatie op website, WhatsApp en DM-kanalen</li>
          <li>Automatisch beantwoorden van veelgestelde vragen</li>
          <li>Warme leads direct doorsturen naar uw salesteam</li>
          <li>Consistente communicatie in uw tone of voice</li>
          <li>Hogere conversie door snellere en altijd beschikbare opvolging</li>
        </ul>
        <div class="service-detail-usecase">
          <strong>Voorbeeld:</strong> Een dienstverlener miste structureel leads buiten kantooruren. Na inzet van de AI Sales Chatbot werden leads binnen seconden beantwoord, met 40% meer ingeplande afspraken als resultaat.
        </div>
        <a href="/afspraak?pakket=automatisering&dienst=sales-chatbot" class="btn btn-outline">Meer weten over de AI Sales Chatbot &rarr;</a>
      </div>

      <!-- Dienst 3: AI Appointment Setter -->
      <div class="service-detail reveal" id="appointment-setter">
        <div class="service-detail-header">
          <div class="service-icon">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
          </div>
          <h3>AI Appointment Setter</h3>
        </div>
        <p class="service-detail-desc">Inbound leads worden automatisch opgevangen, vragen beantwoord en afspraken ingepland in uw agenda. Geen gemiste leads meer door trage reactietijden of drukke periodes. De AI werkt 24/7 en integreert met uw bestaande planningssysteem.</p>
        <ul class="service-detail-features">
          <li>Automatisch opvangen en kwalificeren van inbound leads</li>
          <li>Vragen beantwoorden op basis van uw dienstverlening</li>
          <li>Afspraken direct inplannen in de agenda van uw team</li>
          <li>Werkt buiten kantooruren, in het weekend en op feestdagen</li>
          <li>Integratie met Google Calendar, Outlook en CRM-systemen</li>
        </ul>
        <div class="service-detail-usecase">
          <strong>Voorbeeld:</strong> Een servicebedrijf kreeg dagelijks tientallen aanvragen maar kon niet snel genoeg reageren. De AI Appointment Setter plant nu automatisch afspraken in, waardoor het team zich kan richten op de uitvoering.
        </div>
        <a href="/afspraak?pakket=automatisering&dienst=appointment-setter" class="btn btn-outline">Meer weten over de AI Appointment Setter &rarr;</a>
      </div>

      <!-- Dienst 4: Private / On-Premise AI -->
      <div class="service-detail reveal" id="private-ai">
        <div class="service-detail-header">
          <div class="service-icon">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
          </div>
          <h3>Private / On-Premise AI</h3>
        </div>
        <p class="service-detail-desc">Voor organisaties die gevoelige data niet naar publieke AI-platformen willen sturen. Wij richten AI-oplossingen in die volledig binnen uw eigen omgeving draaien. Maximale controle over data, privacy en security zonder concessies aan functionaliteit.</p>
        <ul class="service-detail-features">
          <li>Lokale of afgeschermde AI-verwerking op uw eigen infrastructuur</li>
          <li>Data blijft volledig binnen uw eigen omgeving</li>
          <li>Geschikt voor privacygevoelige en bedrijfskritische data</li>
          <li>AVG-compliant en security-first ingericht</li>
          <li>Combineerbaar met al onze andere AI-oplossingen</li>
        </ul>
        <div class="service-detail-usecase">
          <strong>Voorbeeld:</strong> Een financieel dienstverlener wilde AI inzetten voor documentverwerking maar mocht klantdata niet naar externe platformen sturen. Met private AI draait de verwerking nu volledig intern, met dezelfde snelheid en kwaliteit.
        </div>
        <a href="/afspraak?pakket=automatisering&dienst=private-ai" class="btn btn-outline">Meer weten over Private AI &rarr;</a>
      </div>

      <!-- Dienst 5: Maatwerk Automation Workflows -->
      <div class="service-detail reveal" id="maatwerk-workflows">
        <div class="service-detail-header">
          <div class="service-icon">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>
          </div>
          <h3>Maatwerk Automation Workflows</h3>
        </div>
        <p class="service-detail-desc">Uw unieke processen verdienen een unieke oplossing. Wij bouwen geautomatiseerde workflows die uw tools, CRM, mailbox en formulieren slim verbinden. Minder handmatig werk, minder fouten en snellere doorlooptijden die meeschalen met uw groei.</p>
        <ul class="service-detail-features">
          <li>Automatisering tussen uw bestaande tools, CRM, mailbox en formulieren</li>
          <li>Processen die nu handmatig lopen volledig geautomatiseerd</li>
          <li>Minder fouten door gestandaardiseerde workflows</li>
          <li>Snellere doorlooptijden en betere schaalbaarheid</li>
          <li>Onderhoudbaar en uitbreidbaar naarmate uw organisatie groeit</li>
        </ul>
        <div class="service-detail-usecase">
          <strong>Voorbeeld:</strong> Een groeiend MKB-bedrijf verwerkte offerteaanvragen handmatig via e-mail, spreadsheets en CRM. Na automatisering wordt elke aanvraag automatisch verwerkt, het juiste team ge&iuml;nformeerd en de klant binnen minuten bevestigd.
        </div>
        <a href="/afspraak?pakket=automatisering&dienst=maatwerk-workflows" class="btn btn-outline">Meer weten over Maatwerk Workflows &rarr;</a>
      </div>

    </div>
  </section>

  <!-- ==================== WERKWIJZE ==================== -->
  <section class="werkwijze" id="werkwijze">
    <div class="container">
      <div class="section-header reveal">
        <span class="section-label">Onze aanpak</span>
        <h2 class="section-title">Van eerste gesprek naar werkende oplossing in vier stappen.</h2>
      </div>
      <div class="steps-grid reveal">
        <div class="step-card">
          <span class="step-number">01</span>
          <h3>Intake en procesanalyse</h3>
          <p>We brengen uw huidige werkprocessen in kaart: waar gaat tijd verloren, welke stappen zijn repetitief en waar biedt AI de meeste waarde?</p>
        </div>
        <div class="step-connector" aria-hidden="true">
          <svg width="40" height="24" viewBox="0 0 40 24" fill="none"><path d="M0 12h36M30 5l7 7-7 7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
        </div>
        <div class="step-card">
          <span class="step-number">02</span>
          <h3>Pilot of proof of value</h3>
          <p>We bouwen een werkend prototype op uw eigen data en processen. U ervaart direct het resultaat voordat u verder investeert.</p>
        </div>
        <div class="step-connector" aria-hidden="true">
          <svg width="40" height="24" viewBox="0 0 40 24" fill="none"><path d="M0 12h36M30 5l7 7-7 7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
        </div>
        <div class="step-card">
          <span class="step-number">03</span>
          <h3>Implementatie en training</h3>
          <p>De oplossing wordt volledig ge&iuml;mplementeerd, gekoppeld aan uw bestaande systemen en uw team wordt getraind in het gebruik.</p>
        </div>
        <div class="step-connector" aria-hidden="true">
          <svg width="40" height="24" viewBox="0 0 40 24" fill="none"><path d="M0 12h36M30 5l7 7-7 7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
        </div>
        <div class="step-card">
          <span class="step-number">04</span>
          <h3>Beheer en doorontwikkeling</h3>
          <p>Wij bewaken de werking, optimaliseren op basis van resultaten en breiden uit waar dat waarde oplevert. U houdt de regie.</p>
        </div>
      </div>
      <div class="section-cta reveal">
        <a href="/afspraak?pakket=automatisering" class="btn btn-outline">Wilt u weten wat AI voor uw bedrijf kan betekenen? &rarr;</a>
      </div>
    </div>
  </section>

  <!-- ==================== RESULTATEN ==================== -->
  <section class="resultaten" id="resultaten">
    <div class="container">
      <div class="section-header reveal">
        <span class="section-label">Impact</span>
        <h2 class="section-title">Concrete resultaten van AI-automatisering</h2>
      </div>
      <div class="results-list reveal">
        <div class="result-item">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
          <span><strong>5-10 uur tijdswinst per week</strong> door geautomatiseerd inbox- en agendabeheer</span>
        </div>
        <div class="result-item">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
          <span><strong>Leads binnen 2 minuten beantwoord</strong> door AI-gestuurde opvolging, ook buiten kantooruren</span>
        </div>
        <div class="result-item">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
          <span><strong>40% minder handmatig werk</strong> door automatisering van repetitieve processen</span>
        </div>
        <div class="result-item">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
          <span><strong>40% meer ingeplande afspraken</strong> door 24/7 leadkwalificatie via chatbot en appointment setter</span>
        </div>
        <div class="result-item">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
          <span><strong>Schalen zonder extra personeel</strong> door processen die meegroeien met uw organisatie</span>
        </div>
        <div class="result-item">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
          <span><strong>Volledige controle over data</strong> door private AI-opties en AVG-conforme verwerking</span>
        </div>
      </div>
      <p class="results-note reveal">Iedere organisatie is anders. Daarom beginnen we altijd met een intake om te bepalen waar de meeste waarde zit.</p>
    </div>
  </section>

  <!-- ==================== CASES ==================== -->
  <section class="cases" id="cases">
    <div class="container">
      <div class="section-header reveal">
        <span class="section-label">In de praktijk</span>
        <h2 class="section-title">Hoe bedrijven tijd besparen met AI-automatisering</h2>
      </div>
      <div class="cases-grid reveal">
        <div class="case-card">
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
        <div class="case-card">
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

  <!-- ==================== PAKKET ==================== -->
  <section class="pakketten" id="pakketten">
    <div class="container">
      <div class="section-header reveal">
        <span class="section-label">Traject</span>
        <h2 class="section-title">AI Automatisering &mdash; op maat voor uw bedrijf</h2>
      </div>
      <div class="pricing-grid pricing-grid--single reveal">

        <div class="pricing-card pricing-card--popular">
          <span class="popular-badge">AI Automatisering</span>
          <div class="pricing-header">
            <h3>Maatwerk traject</h3>
            <span class="pricing-indicator">Op maat / op aanvraag</span>
            <p class="pricing-desc">Inbox, agenda, leadopvolging of maatwerk workflows automatiseren met veilige AI-oplossingen. Prijs afhankelijk van scope en complexiteit.</p>
          </div>
          <ul class="pricing-features">
            <li>
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
              Intake en procesanalyse
            </li>
            <li>
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
              Pilot of proof of value
            </li>
            <li>
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
              Implementatie, training en koppeling met bestaande tools
            </li>
            <li>
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
              Cloud of private AI, naar keuze
            </li>
            <li>
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
              Doorlopend beheer en doorontwikkeling
            </li>
            <li>
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
              Security-first en AVG-compliant
            </li>
          </ul>
          <a href="/afspraak?pakket=automatisering" class="btn btn-primary pricing-cta">Plan een intake
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
          </a>
        </div>

      </div>
      <p class="pricing-note reveal">Niet zeker welke oplossing past? We brengen eerst in kaart waar uw organisatie staat en adviseren op basis van uw situatie.</p>
    </div>
  </section>

  <!-- ==================== FAQ ==================== -->
  <section class="faq-section" id="faq">
    <div class="container">
      <div class="section-header reveal">
        <span class="section-label">Veelgestelde vragen</span>
        <h2 class="section-title">Wat u wilt weten over AI-automatisering</h2>
      </div>
      <div class="faq-list reveal">
        <div class="faq-item">
          <button class="faq-question" aria-expanded="false">
            <span>Hoe lang duurt het voordat de automatisering draait?</span>
            <svg class="faq-chevron" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
          </button>
          <div class="faq-answer" role="region">
            <p>Na een intakegesprek kunnen we doorgaans binnen 1-2 weken starten met een pilot. Een eerste werkende oplossing staat er vaak binnen 4 weken, afhankelijk van de complexiteit.</p>
          </div>
        </div>
        <div class="faq-item">
          <button class="faq-question" aria-expanded="false">
            <span>Werkt dit met Outlook / Microsoft 365?</span>
            <svg class="faq-chevron" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
          </button>
          <div class="faq-answer" role="region">
            <p>Ja. Onze AI-oplossingen integreren met Microsoft 365, Outlook, Google Workspace en de meeste gangbare CRM- en planningsystemen. We stemmen de koppeling af op uw bestaande toolset.</p>
          </div>
        </div>
        <div class="faq-item">
          <button class="faq-question" aria-expanded="false">
            <span>Is dit veilig voor privacygevoelige data?</span>
            <svg class="faq-chevron" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
          </button>
          <div class="faq-answer" role="region">
            <p>Absoluut. Security en privacy staan bij ons voorop. We werken met data-minimalisatie, afgeschermde omgevingen en AVG-conforme verwerking. Elke implementatie wordt beoordeeld op dataveiligheid. Voor maximale controle bieden we ook private of on-premise AI aan.</p>
          </div>
        </div>
        <div class="faq-item">
          <button class="faq-question" aria-expanded="false">
            <span>Kan dit ook lokaal of on-premise draaien?</span>
            <svg class="faq-chevron" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
          </button>
          <div class="faq-answer" role="region">
            <p>Ja. Voor organisaties die privacygevoelige data niet naar publieke AI-platformen willen sturen, bieden wij private of on-premise AI-oplossingen. Data blijft dan volledig binnen uw eigen omgeving.</p>
          </div>
        </div>
        <div class="faq-item">
          <button class="faq-question" aria-expanded="false">
            <span>Moeten we hier intern veel capaciteit voor vrijmaken?</span>
            <svg class="faq-chevron" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
          </button>
          <div class="faq-answer" role="region">
            <p>Minimaal. Wij doen het zware werk: analyse, inrichting, implementatie en automatisering. Wat wij vragen is een aanspreekpunt en toegang tot de relevante systemen en stakeholders.</p>
          </div>
        </div>
        <div class="faq-item">
          <button class="faq-question" aria-expanded="false">
            <span>Is maatwerk mogelijk?</span>
            <svg class="faq-chevron" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
          </button>
          <div class="faq-answer" role="region">
            <p>Ja, maatwerk is ons uitgangspunt. Iedere organisatie heeft andere processen, tools en eisen. Wij ontwerpen en bouwen automatiseringen die passen bij uw specifieke situatie.</p>
          </div>
        </div>
        <div class="faq-item">
          <button class="faq-question" aria-expanded="false">
            <span>Voor welke bedrijven is dit geschikt?</span>
            <svg class="faq-chevron" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
          </button>
          <div class="faq-answer" role="region">
            <p>Onze oplossingen zijn geschikt voor ondernemers, CEO's, directieleden, MKB-bedrijven en organisaties met hoge eisen rondom privacy en security. Van eenmanszaak tot middelgrote organisatie.</p>
          </div>
        </div>
        <div class="faq-item">
          <button class="faq-question" aria-expanded="false">
            <span>Wat kost AI-automatisering?</span>
            <svg class="faq-chevron" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
          </button>
          <div class="faq-answer" role="region">
            <p>De investering hangt af van de scope en complexiteit van het traject. We werken altijd met een heldere offerte na de intake. De pilot geeft u direct inzicht in de waarde voordat u verder investeert.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ==================== SLOT CTA ==================== -->
  <section class="slot-cta" id="contact">
    <div class="container">
      <div class="slot-cta-content reveal">
        <h2>Klaar om tijd terug te winnen met veilige AI-automatisering?</h2>
        <p>Wij analyseren uw processen, bouwen een werkende oplossing en zorgen dat het veilig en schaalbaar draait. De eerste stap is een vrijblijvend intakegesprek.</p>
        <div class="slot-cta-buttons">
          <a href="/afspraak?pakket=automatisering" class="btn btn-primary btn-lg">Plan een intake
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
          </a>
          <a href="mailto:info@automationsequre.nl" class="btn btn-outline btn-lg">Of mail ons direct</a>
        </div>
      </div>
    </div>
  </section>

  <!-- ==================== FOOTER ==================== -->
  <?php if (file_exists(__DIR__ . '/includes/footer.php')): ?>
    <?php include 'includes/footer.php'; ?>
  <?php else: ?>
  <footer class="footer">
    <div class="container">
      <div class="footer-grid">
        <div class="footer-col footer-brand">
          <a href="/" class="logo" aria-label="Automation SeQure homepage">
            <span class="logo-icon">AS</span>
            <span class="logo-text">Automation <strong>SeQure</strong></span>
          </a>
          <p>Veilige AI-automatisering voor ondernemers en organisaties. Inbox, agenda, klantcontact, maatwerk workflows en AI governance.</p>
        </div>
        <div class="footer-col">
          <h4>Navigatie</h4>
          <ul class="footer-links">
            <li><a href="/#diensten">Diensten</a></li>
            <li><a href="/#werkwijze">Werkwijze</a></li>
            <li><a href="/#pakketten">Pakketten</a></li>
            <li><a href="/#faq">FAQ</a></li>
            <li><a href="/afspraak">Gesprek plannen</a></li>
          </ul>
        </div>
        <div class="footer-col">
          <h4>Contact</h4>
          <ul class="footer-links">
            <li><a href="mailto:info@automationsequre.nl">info@automationsequre.nl</a></li>
            <li>Almere, Nederland</li>
          </ul>
        </div>
        <div class="footer-col">
          <h4>Juridisch</h4>
          <ul class="footer-links">
            <li><a href="/privacy">Privacyverklaring</a></li>
          </ul>
        </div>
      </div>
      <div class="footer-bottom">
        <p>&copy; 2026 Automation SeQure. Alle rechten voorbehouden.</p>
      </div>
    </div>
  </footer>
  <?php endif; ?>

  <!-- ==================== FAQ SCHEMA ==================== -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "FAQPage",
    "mainEntity": [
      {
        "@type": "Question",
        "name": "Hoe lang duurt het voordat de automatisering draait?",
        "acceptedAnswer": {
          "@type": "Answer",
          "text": "Na een intakegesprek kunnen we doorgaans binnen 1-2 weken starten met een pilot. Een eerste werkende oplossing staat er vaak binnen 4 weken, afhankelijk van de complexiteit."
        }
      },
      {
        "@type": "Question",
        "name": "Werkt dit met Outlook / Microsoft 365?",
        "acceptedAnswer": {
          "@type": "Answer",
          "text": "Ja. Onze AI-oplossingen integreren met Microsoft 365, Outlook, Google Workspace en de meeste gangbare CRM- en planningsystemen. We stemmen de koppeling af op uw bestaande toolset."
        }
      },
      {
        "@type": "Question",
        "name": "Is dit veilig voor privacygevoelige data?",
        "acceptedAnswer": {
          "@type": "Answer",
          "text": "Absoluut. Security en privacy staan bij ons voorop. We werken met data-minimalisatie, afgeschermde omgevingen en AVG-conforme verwerking. Elke implementatie wordt beoordeeld op dataveiligheid. Voor maximale controle bieden we ook private of on-premise AI aan."
        }
      },
      {
        "@type": "Question",
        "name": "Kan dit ook lokaal of on-premise draaien?",
        "acceptedAnswer": {
          "@type": "Answer",
          "text": "Ja. Voor organisaties die privacygevoelige data niet naar publieke AI-platformen willen sturen, bieden wij private of on-premise AI-oplossingen. Data blijft dan volledig binnen uw eigen omgeving."
        }
      },
      {
        "@type": "Question",
        "name": "Moeten we hier intern veel capaciteit voor vrijmaken?",
        "acceptedAnswer": {
          "@type": "Answer",
          "text": "Minimaal. Wij doen het zware werk: analyse, inrichting, implementatie en automatisering. Wat wij vragen is een aanspreekpunt en toegang tot de relevante systemen en stakeholders."
        }
      },
      {
        "@type": "Question",
        "name": "Is maatwerk mogelijk?",
        "acceptedAnswer": {
          "@type": "Answer",
          "text": "Ja, maatwerk is ons uitgangspunt. Iedere organisatie heeft andere processen, tools en eisen. Wij ontwerpen en bouwen automatiseringen die passen bij uw specifieke situatie."
        }
      },
      {
        "@type": "Question",
        "name": "Voor welke bedrijven is dit geschikt?",
        "acceptedAnswer": {
          "@type": "Answer",
          "text": "Onze oplossingen zijn geschikt voor ondernemers, CEO's, directieleden, MKB-bedrijven en organisaties met hoge eisen rondom privacy en security. Van eenmanszaak tot middelgrote organisatie."
        }
      },
      {
        "@type": "Question",
        "name": "Wat kost AI-automatisering?",
        "acceptedAnswer": {
          "@type": "Answer",
          "text": "De investering hangt af van de scope en complexiteit van het traject. We werken altijd met een heldere offerte na de intake. De pilot geeft u direct inzicht in de waarde voordat u verder investeert."
        }
      }
    ]
  }
  </script>

  <!-- ==================== SERVICE SCHEMA ==================== -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "Service",
    "serviceType": "AI Automatisering",
    "provider": {
      "@type": "Organization",
      "name": "Automation SeQure",
      "url": "https://automationsequre.nl"
    },
    "areaServed": {
      "@type": "Country",
      "name": "Netherlands"
    },
    "description": "Automatiseer inbox, agenda, klantcontact en leadopvolging met veilige AI. Direct resultaat voor ondernemers en MKB.",
    "url": "https://automationsequre.nl/ai-automatisering"
  }
  </script>

  <!-- ==================== BREADCRUMB SCHEMA ==================== -->
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
        "name": "AI Automatisering",
        "item": "https://automationsequre.nl/ai-automatisering"
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
