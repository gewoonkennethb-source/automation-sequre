/* ============================================================
   Automation SeQure — Main Script
   ============================================================ */

(function () {
  'use strict';

  // -----------------------------------------------------------
  // 1. STICKY HEADER — add .scrolled class on scroll
  // -----------------------------------------------------------
  var header = document.getElementById('header');
  if (header) {
    function handleScroll() {
      header.classList.toggle('scrolled', window.scrollY > 40);
    }
    window.addEventListener('scroll', handleScroll, { passive: true });
    handleScroll();
  }

  // -----------------------------------------------------------
  // 2. MOBILE MENU
  // -----------------------------------------------------------
  var hamburger = document.getElementById('hamburger');
  var navLinks = document.getElementById('navLinks');

  if (hamburger && navLinks) {
    hamburger.addEventListener('click', function () {
      var isActive = hamburger.classList.toggle('active');
      navLinks.classList.toggle('active');
      hamburger.setAttribute('aria-expanded', isActive ? 'true' : 'false');
      document.body.style.overflow = isActive ? 'hidden' : '';
    });

    // Close on link click
    navLinks.querySelectorAll('a').forEach(function (link) {
      link.addEventListener('click', function () {
        hamburger.classList.remove('active');
        navLinks.classList.remove('active');
        hamburger.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = '';
      });
    });
  }

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

  if (reveals.length > 0 && 'IntersectionObserver' in window) {
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
  } else {
    // Fallback: show everything immediately
    reveals.forEach(function (el) {
      el.classList.add('visible');
    });
  }

  // -----------------------------------------------------------
  // 5. ACTIVE NAV HIGHLIGHT on scroll
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
            a.style.color = 'var(--accent)';
          }
        });
      }
    });
  }

  window.addEventListener('scroll', highlightNav, { passive: true });

  // -----------------------------------------------------------
  // 6. URGENCY BANNER (with dynamic availability)
  // -----------------------------------------------------------
  var urgencyBar = document.getElementById('urgencyBar');
  var urgencyClose = document.getElementById('urgencyClose');

  if (urgencyBar) {
    // Check if user dismissed it this session
    if (sessionStorage.getItem('urgencyDismissed')) {
      urgencyBar.style.display = 'none';
    } else {
      document.body.classList.add('has-urgency');

      // Fetch dynamic weekly availability from API
      var urgencySlotsEl = document.getElementById('urgencySlots');
      var urgencyPeriodEl = document.getElementById('urgencyPeriod');

      var xhr = new XMLHttpRequest();
      xhr.open('GET', 'api/availability.php', true);
      xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
          try {
            var data = JSON.parse(xhr.responseText);
            var remaining = data.remainingSlots;

            if (urgencySlotsEl) {
              urgencySlotsEl.textContent = remaining + (remaining === 1 ? ' plek' : ' plekken');
            }

            // Show week period with formatted dates (e.g. "Week 14 apr - 18 apr:")
            if (urgencyPeriodEl && data.weekStart && data.weekEnd) {
              var monthsNL = ['jan','feb','mrt','apr','mei','jun','jul','aug','sep','okt','nov','dec'];
              var start = new Date(data.weekStart);
              var end = new Date(data.weekEnd);
              var startDay = start.getDate();
              var endDay = end.getDate();
              var startMonth = monthsNL[start.getMonth()];
              var endMonth = monthsNL[end.getMonth()];

              var periodText = 'Week ' + startDay + ' ' + startMonth;
              if (startMonth !== endMonth) {
                periodText += ' - ' + endDay + ' ' + endMonth + ':';
              } else {
                periodText += ' - ' + endDay + ' ' + startMonth + ':';
              }
              urgencyPeriodEl.textContent = periodText;
            }

            // If no slots left, hide banner
            if (remaining === 0) {
              urgencyBar.style.display = 'none';
              document.body.classList.remove('has-urgency');
            }
          } catch (e) {
            // Keep static fallback on parse error
          }
        }
      };
      xhr.onerror = function () { /* Keep static fallback */ };
      xhr.send();
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
  // 7. FAQ ACCORDION
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
  // 8. SCAN FORM (Gratis Analyse)
  // -----------------------------------------------------------
  var scanForm = document.getElementById('scanForm');
  var scanFeedback = document.getElementById('scanFeedback');

  if (scanForm) {
    scanForm.addEventListener('submit', function (e) {
      e.preventDefault();

      var name    = document.getElementById('scanName').value.trim();
      var company = document.getElementById('scanCompany').value.trim();
      var email   = document.getElementById('scanEmail').value.trim();
      var phone   = document.getElementById('scanPhone') ? document.getElementById('scanPhone').value.trim() : '';
      var service = document.getElementById('scanService') ? document.getElementById('scanService').value : '';
      var message = document.getElementById('scanMessage') ? document.getElementById('scanMessage').value.trim() : '';

      if (!name || !company || !email) {
        scanFeedback.textContent = 'Vul minimaal naam, bedrijfsnaam en e-mailadres in.';
        scanFeedback.style.color = '#FF5F57';
        scanFeedback.style.display = 'block';
        return;
      }

      // Send to backend
      var xhr = new XMLHttpRequest();
      xhr.open('POST', 'scan.php', true);
      xhr.setRequestHeader('Content-Type', 'application/json');
      try {
        xhr.send(JSON.stringify({ name: name, company: company, email: email, phone: phone, service: service, message: message }));
      } catch (err) { /* graceful fail */ }

      scanFeedback.textContent = 'Aanvraag ontvangen! We nemen binnen 2 werkdagen contact met u op.';
      scanFeedback.style.color = '#34D399';
      scanFeedback.style.display = 'block';
      scanForm.reset();

      setTimeout(function () {
        scanFeedback.style.display = 'none';
      }, 6000);
    });
  }

})();
