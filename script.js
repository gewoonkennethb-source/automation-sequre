/* ============================================================
   Automation SeQure — Main Script
   ============================================================ */

(function () {
  'use strict';

  // -----------------------------------------------------------
  // 1. STICKY HEADER — add .scrolled class on scroll
  // -----------------------------------------------------------
  const header = document.getElementById('header');
  let lastScroll = 0;

  function handleScroll() {
    const y = window.scrollY;
    header.classList.toggle('scrolled', y > 40);
    lastScroll = y;
  }
  window.addEventListener('scroll', handleScroll, { passive: true });
  handleScroll();

  // -----------------------------------------------------------
  // 2. MOBILE MENU
  // -----------------------------------------------------------
  const hamburger = document.getElementById('hamburger');
  const navLinks = document.getElementById('navLinks');

  hamburger.addEventListener('click', function () {
    hamburger.classList.toggle('active');
    navLinks.classList.toggle('active');
    document.body.style.overflow = navLinks.classList.contains('active') ? 'hidden' : '';
  });

  // Close on link click
  navLinks.querySelectorAll('a').forEach(function (link) {
    link.addEventListener('click', function () {
      hamburger.classList.remove('active');
      navLinks.classList.remove('active');
      document.body.style.overflow = '';
    });
  });

  // -----------------------------------------------------------
  // 3. SMOOTH SCROLL for anchor links
  // -----------------------------------------------------------
  document.querySelectorAll('a[href^="#"]').forEach(function (anchor) {
    anchor.addEventListener('click', function (e) {
      var href = this.getAttribute('href');
      if (href === '#') return;
      var target = document.querySelector(href);
      if (!target) return;
      e.preventDefault();
      var offset = 80;
      var y = target.getBoundingClientRect().top + window.pageYOffset - offset;
      window.scrollTo({ top: y, behavior: 'smooth' });
    });
  });

  // -----------------------------------------------------------
  // 4. SCROLL REVEAL ANIMATIONS
  // -----------------------------------------------------------
  var reveals = document.querySelectorAll('.reveal');

  var revealObserver = new IntersectionObserver(
    function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
        }
      });
    },
    { threshold: 0.08, rootMargin: '0px 0px -30px 0px' }
  );

  reveals.forEach(function (el) {
    revealObserver.observe(el);
  });

  // -----------------------------------------------------------
  // 5. HERO FLOW ANIMATION — cycle through flow items
  // -----------------------------------------------------------
  var flowItems = document.querySelectorAll('.flow-item');
  var activeIndex = 0;

  function cycleFlow() {
    flowItems.forEach(function (item) {
      item.classList.remove('active');
    });
    flowItems[activeIndex].classList.add('active');
    activeIndex = (activeIndex + 1) % flowItems.length;
  }

  if (flowItems.length > 0) {
    setInterval(cycleFlow, 2000);
  }

  // -----------------------------------------------------------
  // 6. CONTACT FORM — frontend-only with feedback
  // -----------------------------------------------------------
  var contactForm = document.getElementById('contactForm');
  var formFeedback = document.getElementById('formFeedback');

  if (contactForm) {
    contactForm.addEventListener('submit', function (e) {
      e.preventDefault();

      // Collect form data
      var formData = new FormData(contactForm);
      var data = {};
      formData.forEach(function (value, key) {
        data[key] = value;
      });

      // Basic validation
      if (!data.name || !data.email) {
        formFeedback.textContent = 'Vul alsjeblieft je naam en e-mailadres in.';
        formFeedback.style.color = '#FF5F57';
        formFeedback.style.display = 'block';
        return;
      }

      // Show success (frontend-only for now)
      formFeedback.textContent = 'Bedankt voor je bericht! We nemen zo snel mogelijk contact met je op.';
      formFeedback.style.color = '#00E676';
      formFeedback.style.display = 'block';
      contactForm.reset();

      // Hide feedback after 5 seconds
      setTimeout(function () {
        formFeedback.style.display = 'none';
      }, 5000);

      // Log to console (can be replaced with actual API call)
      console.log('Form submission:', data);
    });
  }

  // -----------------------------------------------------------
  // 7. ACTIVE NAV HIGHLIGHT on scroll
  // -----------------------------------------------------------
  var sections = document.querySelectorAll('section[id]');
  var navAnchors = document.querySelectorAll('.nav-links a[href^="#"]');

  function highlightNav() {
    var scrollY = window.scrollY + 120;

    sections.forEach(function (section) {
      var top = section.offsetTop;
      var height = section.offsetHeight;
      var id = section.getAttribute('id');

      if (scrollY >= top && scrollY < top + height) {
        navAnchors.forEach(function (a) {
          a.style.color = '';
          if (a.getAttribute('href') === '#' + id && !a.classList.contains('nav-cta')) {
            a.style.color = '#6C5CE7';
          }
        });
      }
    });
  }

  window.addEventListener('scroll', highlightNav, { passive: true });

  // -----------------------------------------------------------
  // 8. URGENCY BANNER
  // -----------------------------------------------------------
  var urgencyBar = document.getElementById('urgencyBar');
  var urgencyClose = document.getElementById('urgencyClose');

  if (urgencyBar) {
    // Check if user dismissed it this session
    if (sessionStorage.getItem('urgencyDismissed')) {
      urgencyBar.style.display = 'none';
    } else {
      document.body.classList.add('has-urgency');
    }

    if (urgencyClose) {
      urgencyClose.addEventListener('click', function () {
        urgencyBar.style.display = 'none';
        document.body.classList.remove('has-urgency');
        sessionStorage.setItem('urgencyDismissed', '1');
      });
    }
  }

  // -----------------------------------------------------------
  // 9. FAQ ACCORDION
  // -----------------------------------------------------------
  var faqItems = document.querySelectorAll('.faq-item');

  faqItems.forEach(function (item) {
    var btn = item.querySelector('.faq-question');
    if (!btn) return;

    btn.addEventListener('click', function () {
      var isOpen = item.classList.contains('open');

      // Close all
      faqItems.forEach(function (other) {
        other.classList.remove('open');
        var otherBtn = other.querySelector('.faq-question');
        if (otherBtn) otherBtn.setAttribute('aria-expanded', 'false');
      });

      // Toggle current
      if (!isOpen) {
        item.classList.add('open');
        btn.setAttribute('aria-expanded', 'true');
      }
    });
  });

  // -----------------------------------------------------------
  // 10. WEBSITE SCAN FORM
  // -----------------------------------------------------------
  var scanForm = document.getElementById('scanForm');
  var scanFeedback = document.getElementById('scanFeedback');

  if (scanForm) {
    scanForm.addEventListener('submit', function (e) {
      e.preventDefault();

      var url   = document.getElementById('scanUrl').value.trim();
      var name  = document.getElementById('scanName').value.trim();
      var email = document.getElementById('scanEmail').value.trim();

      if (!url || !name || !email) {
        scanFeedback.textContent = 'Vul alle velden in.';
        scanFeedback.style.color = '#FF5F57';
        scanFeedback.style.display = 'block';
        return;
      }

      // Send to backend (can be connected to PHP or n8n later)
      var xhr = new XMLHttpRequest();
      xhr.open('POST', 'scan.php', true);
      xhr.setRequestHeader('Content-Type', 'application/json');
      try {
        xhr.send(JSON.stringify({ url: url, name: name, email: email }));
      } catch (err) { /* graceful fail */ }

      scanFeedback.textContent = 'Aanvraag ontvangen! Je ontvangt je gratis analyse binnen 48 uur.';
      scanFeedback.style.color = '#00E676';
      scanFeedback.style.display = 'block';
      scanForm.reset();

      setTimeout(function () {
        scanFeedback.style.display = 'none';
      }, 6000);
    });
  }

})();
