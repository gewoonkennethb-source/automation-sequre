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

    // Close on link click (skip dropdown parent links on mobile)
    navLinks.querySelectorAll('a').forEach(function (link) {
      link.addEventListener('click', function () {
        // Don't close menu if this is a dropdown toggle on mobile
        if (window.innerWidth < 768 && link.parentElement && link.parentElement.classList.contains('nav-item--has-dropdown')) {
          return;
        }
        hamburger.classList.remove('active');
        navLinks.classList.remove('active');
        hamburger.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = '';
      });
    });

    // Mobile dropdown toggle for .nav-dropdown
    var dropdownItems = document.querySelectorAll('.nav-dropdown');
    dropdownItems.forEach(function (item) {
      var toggle = item.querySelector('.nav-dropdown-toggle');
      if (!toggle) return;

      toggle.addEventListener('click', function (e) {
        if (window.innerWidth >= 768) return; // Let CSS handle desktop hover
        e.preventDefault();

        // Close other open dropdowns
        dropdownItems.forEach(function (other) {
          if (other !== item) other.classList.remove('open');
        });

        // Toggle this dropdown
        item.classList.toggle('open');
        toggle.setAttribute('aria-expanded', item.classList.contains('open') ? 'true' : 'false');
      });
    });
  }

  // -----------------------------------------------------------
  // 3. SMOOTH SCROLL for same-page anchor links only
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

  // Don't intercept cross-page links with anchors (e.g. /page#section)
  // Those use full hrefs and won't match a[href^="#"], so they navigate normally.

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
  // 5. ACTIVE NAV HIGHLIGHT
  // -----------------------------------------------------------
  var sections = document.querySelectorAll('section[id]');
  var navAnchors = document.querySelectorAll('.nav-links a[href^="#"]');
  var allNavItems = document.querySelectorAll('.nav-links a');

  // Page-level active state: mark nav item matching data-page
  var currentPage = document.body.dataset.page;
  if (currentPage) {
    allNavItems.forEach(function (a) {
      if (a.dataset.page === currentPage) {
        a.classList.add('active');
      }
    });
  }

  // Scroll-spy only on pages that have sections with IDs
  if (sections.length > 0 && navAnchors.length > 0) {
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
  }

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
  // 8. CONTACT FORM (contact.php and legacy scanForm)
  // -----------------------------------------------------------
  function setupContactForm(formId, feedbackId, fieldPrefix) {
    var form = document.getElementById(formId);
    var feedback = document.getElementById(feedbackId);
    if (!form || !feedback) return;

    form.addEventListener('submit', function (e) {
      e.preventDefault();

      var name    = document.getElementById(fieldPrefix + 'Name').value.trim();
      var company = document.getElementById(fieldPrefix + 'Company').value.trim();
      var email   = document.getElementById(fieldPrefix + 'Email').value.trim();
      var phoneEl = document.getElementById(fieldPrefix + 'Phone');
      var phone   = phoneEl ? phoneEl.value.trim() : '';
      var serviceEl = document.getElementById(fieldPrefix + 'Service');
      var service = serviceEl ? serviceEl.value : '';
      var messageEl = document.getElementById(fieldPrefix + 'Message');
      var message = messageEl ? messageEl.value.trim() : '';

      if (!name || !company || !email) {
        feedback.textContent = 'Vul minimaal naam, bedrijfsnaam en e-mailadres in.';
        feedback.style.color = '#FF5F57';
        feedback.style.display = 'block';
        return;
      }

      // Disable submit button
      var submitBtn = form.querySelector('button[type="submit"]');
      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.style.opacity = '0.6';
      }

      var xhr = new XMLHttpRequest();
      xhr.open('POST', '/scan.php', true);
      xhr.setRequestHeader('Content-Type', 'application/json');
      xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
          if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.style.opacity = '';
          }
          if (xhr.status >= 200 && xhr.status < 300) {
            feedback.textContent = 'Bericht ontvangen! We nemen binnen 2 werkdagen contact met u op.';
            feedback.style.color = '#34D399';
            feedback.style.display = 'block';
            form.reset();
          } else {
            feedback.textContent = 'Er ging iets mis. Probeer het opnieuw of mail ons op info@automationsequre.nl.';
            feedback.style.color = '#FF5F57';
            feedback.style.display = 'block';
          }
          setTimeout(function () { feedback.style.display = 'none'; }, 6000);
        }
      };
      xhr.onerror = function () {
        if (submitBtn) {
          submitBtn.disabled = false;
          submitBtn.style.opacity = '';
        }
        feedback.textContent = 'Verbindingsfout. Controleer uw internetverbinding en probeer het opnieuw.';
        feedback.style.color = '#FF5F57';
        feedback.style.display = 'block';
      };
      xhr.send(JSON.stringify({ name: name, company: company, email: email, phone: phone, service: service, message: message }));
    });
  }

  // Contact page form
  setupContactForm('contactForm', 'contactFeedback', 'contact');
  // Legacy scan form (backup pages)
  setupContactForm('scanForm', 'scanFeedback', 'scan');

  // -----------------------------------------------------------
  // 9. CASES FILTER
  // -----------------------------------------------------------
  var filterBtns = document.querySelectorAll('.cases-filter-btn');
  var caseCards = document.querySelectorAll('.case-card');

  if (filterBtns.length > 0 && caseCards.length > 0) {
    filterBtns.forEach(function (btn) {
      btn.addEventListener('click', function () {
        var filter = btn.dataset.filter;

        // Update active state on buttons
        filterBtns.forEach(function (b) {
          b.classList.remove('active');
        });
        btn.classList.add('active');

        // Filter cards
        caseCards.forEach(function (card) {
          if (filter === 'all' || card.dataset.route === filter) {
            card.classList.remove('hidden');
          } else {
            card.classList.add('hidden');
          }
        });
      });
    });
  }

})();
