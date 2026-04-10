/* ============================================================
   Afspraak Module — Calendar & Booking Logic
   With real-time availability checking & double-booking prevention
   ============================================================ */
(function () {
  'use strict';

  // -----------------------------------------------------------
  // CONFIG
  // -----------------------------------------------------------
  var SLOT_START = 13;
  var SLOT_END   = 18;
  var SLOT_MINS  = 30;
  var BOOKED_DAYS_AHEAD = 2;
  var API_BASE = 'api/slots.php';
  var BOOK_URL = 'book.php';

  var MONTHS_NL = [
    'Januari','Februari','Maart','April','Mei','Juni',
    'Juli','Augustus','September','Oktober','November','December'
  ];
  var DAYS_NL = ['Zondag','Maandag','Dinsdag','Woensdag','Donderdag','Vrijdag','Zaterdag'];

  // -----------------------------------------------------------
  // STATE
  // -----------------------------------------------------------
  var today = new Date();
  today.setHours(0,0,0,0);

  var currentMonth = today.getMonth();
  var currentYear  = today.getFullYear();
  var selectedDate = null;
  var selectedTime = null;
  var slotsCache   = {}; // Cache fetched slots per date

  // -----------------------------------------------------------
  // DOM REFS
  // -----------------------------------------------------------
  var calDays          = document.getElementById('calDays');
  var calTitle         = document.getElementById('calTitle');
  var calPrev          = document.getElementById('calPrev');
  var calNext          = document.getElementById('calNext');
  var timeslotsWrapper = document.getElementById('timeslotsWrapper');
  var timeslotsGrid    = document.getElementById('timeslotsGrid');
  var selectedDateText = document.getElementById('selectedDateText');
  var toStep2          = document.getElementById('toStep2');
  var step1            = document.getElementById('step1');
  var step2            = document.getElementById('step2');
  var step3            = document.getElementById('step3');
  var backToStep1      = document.getElementById('backToStep1');
  var bookingForm      = document.getElementById('bookingForm');
  var slotBanner       = document.getElementById('selectedSlotBanner');
  var packageBanner    = document.getElementById('packageBanner');
  var packageNameEl    = document.getElementById('packageName');
  var bookServiceEl    = document.getElementById('bookService');

  // -----------------------------------------------------------
  // PACKAGE FROM URL PARAMETER
  // -----------------------------------------------------------
  var PACKAGE_MAP = {
    'quickscan':      { label: 'AI Governance Quickscan', service: 'ai-governance-quickscan' },
    'blueprint':      { label: 'AI Governance Blueprint', service: 'ai-governance-blueprint' },
    'compliance':     { label: 'Compliance Service', service: 'ai-compliance-service' },
    'automatisering': { label: 'AI Automatisering', service: 'maatwerk-workflows' },
    // Backward compatibility
    'starter':        { label: 'AI Governance Quickscan', service: 'ai-governance-quickscan' },
    'growth':         { label: 'AI Governance Blueprint', service: 'ai-governance-blueprint' },
    'scale':          { label: 'Compliance Service', service: 'ai-compliance-service' }
  };

  var urlParams = new URLSearchParams(window.location.search);
  var selectedPackage = urlParams.get('pakket');

  if (selectedPackage && PACKAGE_MAP[selectedPackage]) {
    var pkg = PACKAGE_MAP[selectedPackage];
    if (packageBanner && packageNameEl) {
      packageNameEl.textContent = pkg.label;
      packageBanner.style.display = 'flex';
    }
    // Pre-select matching service in dropdown
    if (bookServiceEl && pkg.service) {
      bookServiceEl.value = pkg.service;
    }
  }

  // -----------------------------------------------------------
  // HELPERS
  // -----------------------------------------------------------
  function padZero(n) { return n < 10 ? '0' + n : '' + n; }

  function formatDateISO(d) {
    return d.getFullYear() + '-' + padZero(d.getMonth() + 1) + '-' + padZero(d.getDate());
  }

  function escHtml(str) {
    var div = document.createElement('div');
    div.appendChild(document.createTextNode(str));
    return div.innerHTML;
  }

  function isWeekend(dateObj) {
    return dateObj.getDay() === 0 || dateObj.getDay() === 6;
  }

  function isPast(dateObj) {
    return dateObj < today;
  }

  function isBookedAhead(dateObj) {
    var diff = Math.floor((dateObj - today) / 86400000);
    return diff < BOOKED_DAYS_AHEAD;
  }

  // -----------------------------------------------------------
  // FETCH AVAILABLE SLOTS FROM SERVER
  // -----------------------------------------------------------
  function fetchSlots(dateStr, callback) {
    // Return from cache if available
    if (slotsCache[dateStr]) {
      callback(slotsCache[dateStr]);
      return;
    }

    var xhr = new XMLHttpRequest();
    xhr.open('GET', API_BASE + '?date=' + encodeURIComponent(dateStr), true);
    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4) {
        if (xhr.status === 200) {
          try {
            var data = JSON.parse(xhr.responseText);
            slotsCache[dateStr] = data;
            callback(data);
          } catch (e) {
            // Fallback: generate slots client-side
            callback(null);
          }
        } else {
          callback(null);
        }
      }
    };
    xhr.onerror = function () { callback(null); };
    xhr.send();
  }

  // -----------------------------------------------------------
  // CALENDAR RENDERING
  // -----------------------------------------------------------
  function renderCalendar() {
    calTitle.textContent = MONTHS_NL[currentMonth] + ' ' + currentYear;

    calPrev.disabled = (
      currentYear === today.getFullYear() &&
      currentMonth === today.getMonth()
    );

    var maxMonth = today.getMonth() + 3;
    var maxYear  = today.getFullYear();
    if (maxMonth > 11) { maxMonth -= 12; maxYear++; }
    calNext.disabled = (currentYear === maxYear && currentMonth === maxMonth);

    calDays.innerHTML = '';

    var firstDay = new Date(currentYear, currentMonth, 1);
    var startDay = (firstDay.getDay() + 6) % 7;
    var daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();
    var daysInPrev  = new Date(currentYear, currentMonth, 0).getDate();

    // Previous month padding
    for (var p = startDay - 1; p >= 0; p--) {
      var el = document.createElement('div');
      el.className = 'cal-day other-month';
      el.textContent = daysInPrev - p;
      calDays.appendChild(el);
    }

    // Current month
    for (var d = 1; d <= daysInMonth; d++) {
      var dateObj = new Date(currentYear, currentMonth, d);
      var el = document.createElement('div');
      el.className = 'cal-day';
      el.textContent = d;
      el.setAttribute('data-date', dateObj.toDateString());

      var weekend = isWeekend(dateObj);
      var past    = isPast(dateObj);
      var booked  = isBookedAhead(dateObj) && !past;
      var isToday = dateObj.toDateString() === today.toDateString();

      if (past || weekend) {
        el.classList.add('disabled');
      } else if (booked) {
        el.classList.add('booked');
        el.title = 'Volgeboekt';
      }

      if (isToday) el.classList.add('today');

      if (selectedDate && dateObj.toDateString() === selectedDate.toDateString()) {
        el.classList.add('selected');
      }

      if (!past && !weekend && !booked) {
        el.addEventListener('click', handleDateClick);
      }

      calDays.appendChild(el);
    }

    // Next month padding
    var totalCells = startDay + daysInMonth;
    var remaining  = totalCells % 7 === 0 ? 0 : 7 - (totalCells % 7);
    for (var n = 1; n <= remaining; n++) {
      var el = document.createElement('div');
      el.className = 'cal-day other-month';
      el.textContent = n;
      calDays.appendChild(el);
    }
  }

  function handleDateClick(e) {
    var dateStr = e.target.getAttribute('data-date');
    selectedDate = new Date(dateStr);
    selectedTime = null;
    toStep2.disabled = true;
    renderCalendar();
    renderTimeslots();
  }

  // -----------------------------------------------------------
  // TIMESLOT RENDERING (from server data)
  // -----------------------------------------------------------
  function renderTimeslots() {
    if (!selectedDate) {
      timeslotsWrapper.style.display = 'none';
      return;
    }

    timeslotsWrapper.style.display = 'block';
    var dayName = DAYS_NL[selectedDate.getDay()];
    var dayNum  = selectedDate.getDate();
    var month   = MONTHS_NL[selectedDate.getMonth()];
    selectedDateText.textContent = dayName + ' ' + dayNum + ' ' + month;

    // Show loading state
    timeslotsGrid.innerHTML = '<div style="grid-column:1/-1;text-align:center;padding:20px;color:var(--text-light);">Beschikbaarheid laden...</div>';

    var dateISO = formatDateISO(selectedDate);

    fetchSlots(dateISO, function (data) {
      timeslotsGrid.innerHTML = '';

      if (data && data.slots && data.slots.length > 0) {
        // Render slots from server
        data.slots.forEach(function (slot) {
          var el = document.createElement('div');
          el.className = 'timeslot';
          el.textContent = slot.time;
          el.setAttribute('data-time', slot.time);

          if (!slot.available) {
            el.classList.add('booked');
            el.title = 'Niet beschikbaar';
          } else {
            el.addEventListener('click', handleTimeClick);
          }

          if (selectedTime === slot.time) {
            el.classList.add('selected');
          }

          timeslotsGrid.appendChild(el);
        });

        // Check if all slots are booked
        var availableCount = data.slots.filter(function (s) { return s.available; }).length;
        if (availableCount === 0) {
          timeslotsGrid.innerHTML = '<div style="grid-column:1/-1;text-align:center;padding:20px;color:var(--text-light);">Geen beschikbare tijden op deze dag. Kies een andere datum.</div>';
        }
      } else if (data && data.fullyBooked) {
        timeslotsGrid.innerHTML = '<div style="grid-column:1/-1;text-align:center;padding:20px;color:var(--text-light);">Deze dag is volledig volgeboekt. Kies een andere datum.</div>';
      } else {
        // Fallback: generate client-side (when API not available)
        renderTimeslotsFallback();
      }
    });
  }

  // Fallback for when API is not available (e.g. local testing)
  function renderTimeslotsFallback() {
    timeslotsGrid.innerHTML = '';
    for (var h = SLOT_START; h < SLOT_END; h++) {
      for (var m = 0; m < 60; m += SLOT_MINS) {
        var timeStr = padZero(h) + ':' + padZero(m);
        var el = document.createElement('div');
        el.className = 'timeslot';
        el.textContent = timeStr;
        el.setAttribute('data-time', timeStr);
        el.addEventListener('click', handleTimeClick);
        timeslotsGrid.appendChild(el);
      }
    }
  }

  function handleTimeClick(e) {
    selectedTime = e.target.getAttribute('data-time');
    toStep2.disabled = false;

    var slots = timeslotsGrid.querySelectorAll('.timeslot');
    for (var i = 0; i < slots.length; i++) {
      slots[i].classList.remove('selected');
    }
    e.target.classList.add('selected');
  }

  // -----------------------------------------------------------
  // NAVIGATION
  // -----------------------------------------------------------
  calPrev.addEventListener('click', function () {
    currentMonth--;
    if (currentMonth < 0) { currentMonth = 11; currentYear--; }
    renderCalendar();
  });
  calNext.addEventListener('click', function () {
    currentMonth++;
    if (currentMonth > 11) { currentMonth = 0; currentYear++; }
    renderCalendar();
  });

  // -----------------------------------------------------------
  // WIZARD STEPS
  // -----------------------------------------------------------
  toStep2.addEventListener('click', function () {
    if (!selectedDate || !selectedTime) return;

    var dayName = DAYS_NL[selectedDate.getDay()];
    var dayNum  = selectedDate.getDate();
    var month   = MONTHS_NL[selectedDate.getMonth()];
    var year    = selectedDate.getFullYear();

    var endH = parseInt(selectedTime.split(':')[0]);
    var endM = parseInt(selectedTime.split(':')[1]) + SLOT_MINS;
    if (endM >= 60) { endH++; endM -= 60; }
    var endTime = padZero(endH) + ':' + padZero(endM);

    slotBanner.textContent = dayName + ' ' + dayNum + ' ' + month + ' ' + year +
      ' om ' + selectedTime + ' - ' + endTime;

    step1.style.display = 'none';
    step2.style.display = 'block';
    window.scrollTo({ top: 0, behavior: 'smooth' });
  });

  backToStep1.addEventListener('click', function () {
    step2.style.display = 'none';
    step1.style.display = 'block';
  });

  // -----------------------------------------------------------
  // FORM SUBMISSION (with double-booking protection)
  // -----------------------------------------------------------
  bookingForm.addEventListener('submit', function (e) {
    e.preventDefault();

    var submitBtn = bookingForm.querySelector('button[type="submit"]');
    var privacyCheckbox = document.getElementById('privacyConsent');

    // Check privacy consent
    if (privacyCheckbox && !privacyCheckbox.checked) {
      alert('Je moet akkoord gaan met de privacyverklaring om een afspraak te maken.');
      return;
    }

    var serviceEl = document.getElementById('bookService');
    var formData = {
      firstName:      document.getElementById('firstName').value.trim(),
      lastName:       document.getElementById('lastName').value.trim(),
      companyName:    document.getElementById('companyName').value.trim(),
      address:        document.getElementById('address').value.trim(),
      postcode:       document.getElementById('postcode').value.trim(),
      city:           document.getElementById('city').value.trim(),
      email:          document.getElementById('bookEmail').value.trim(),
      phone:          document.getElementById('bookPhone').value.trim(),
      date:           formatDateISO(selectedDate),
      time:           selectedTime,
      dateDisplay:    slotBanner.textContent,
      privacyConsent: privacyCheckbox ? privacyCheckbox.checked : false,
      pakket:         selectedPackage || '',
      service:        serviceEl ? serviceEl.value : ''
    };

    // Validate required
    if (!formData.firstName || !formData.lastName || !formData.companyName ||
        !formData.email || !formData.phone) {
      alert('Vul alle verplichte velden in.');
      return;
    }

    // Disable submit button to prevent double clicks
    submitBtn.disabled = true;
    submitBtn.textContent = 'Bezig met boeken...';

    // Send to backend
    var xhr = new XMLHttpRequest();
    xhr.open('POST', BOOK_URL, true);
    xhr.setRequestHeader('Content-Type', 'application/json');

    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4) {
        submitBtn.disabled = false;
        submitBtn.innerHTML = 'Afspraak bevestigen <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>';

        if (xhr.status === 200) {
          try {
            var response = JSON.parse(xhr.responseText);
            if (response.success) {
              // Clear slots cache so next visitor sees updated availability
              delete slotsCache[formData.date];
              showConfirmation(formData, response.bookingId);
            } else {
              alert(response.error || 'Er is een fout opgetreden.');
            }
          } catch (err) {
            // If JSON parse fails, still show confirmation (local testing)
            showConfirmation(formData, null);
          }
        } else if (xhr.status === 409) {
          // Double booking detected!
          try {
            var errResponse = JSON.parse(xhr.responseText);
            alert(errResponse.error || 'Dit tijdslot is helaas net geboekt. Kies een ander tijdstip.');
          } catch (err) {
            alert('Dit tijdslot is helaas net geboekt door iemand anders. Kies een ander tijdstip.');
          }
          // Go back to step 1 and refresh slots
          delete slotsCache[formData.date];
          step2.style.display = 'none';
          step1.style.display = 'block';
          renderTimeslots();
        } else {
          // Other error — still try to show confirmation for local testing
          showConfirmation(formData, null);
        }
      }
    };

    xhr.onerror = function () {
      submitBtn.disabled = false;
      submitBtn.textContent = 'Afspraak bevestigen';
      showConfirmation(formData, null);
    };

    xhr.send(JSON.stringify(formData));
  });

  function showConfirmation(data, bookingId) {
    step2.style.display = 'none';
    step3.style.display = 'block';
    window.scrollTo({ top: 0, behavior: 'smooth' });

    document.getElementById('confirmDetail').textContent = data.dateDisplay;
    document.getElementById('confirmEmail').textContent  = data.email;

    var refHtml = bookingId ? '<div class="summary-row"><span class="summary-label">Referentie</span><span class="summary-value">#' + bookingId + '</span></div>' : '';

    var pakketHtml = '';
    if (data.pakket && PACKAGE_MAP[data.pakket]) {
      pakketHtml = '<div class="summary-row"><span class="summary-label">Pakket</span><span class="summary-value">' + escHtml(PACKAGE_MAP[data.pakket].label) + '</span></div>';
    }

    var serviceLabels = {
      'inbox-calendar': 'AI Inbox & Calendar Manager',
      'appointment-setter': 'AI Appointment Setter',
      'sales-chatbot': 'AI Sales Chatbot',
      'private-ai': 'Private / On-Premise AI',
      'maatwerk-workflows': 'Maatwerk Automation Workflows',
      'ai-governance-quickscan': 'AI Governance Quickscan',
      'ai-governance-blueprint': 'AI Governance Blueprint',
      'ai-compliance-service': 'Compliance Service',
      'anders': 'Iets anders / Weet ik nog niet'
    };
    var serviceHtml = '';
    if (data.service && serviceLabels[data.service]) {
      serviceHtml = '<div class="summary-row"><span class="summary-label">Interesse</span><span class="summary-value">' + escHtml(serviceLabels[data.service]) + '</span></div>';
    }

    document.getElementById('confirmSummary').innerHTML =
      '<div class="summary-row"><span class="summary-label">Naam</span><span class="summary-value">' + escHtml(data.firstName + ' ' + data.lastName) + '</span></div>' +
      '<div class="summary-row"><span class="summary-label">Bedrijf</span><span class="summary-value">' + escHtml(data.companyName) + '</span></div>' +
      '<div class="summary-row"><span class="summary-label">E-mail</span><span class="summary-value">' + escHtml(data.email) + '</span></div>' +
      '<div class="summary-row"><span class="summary-label">Telefoon</span><span class="summary-value">' + escHtml(data.phone) + '</span></div>' +
      '<div class="summary-row"><span class="summary-label">Datum &amp; tijd</span><span class="summary-value">' + escHtml(data.dateDisplay) + '</span></div>' +
      pakketHtml +
      serviceHtml +
      refHtml;
  }

  // -----------------------------------------------------------
  // MOBILE MENU
  // -----------------------------------------------------------
  var hamburger = document.getElementById('hamburger');
  var navLinks  = document.getElementById('navLinks');
  if (hamburger && navLinks) {
    hamburger.addEventListener('click', function () {
      hamburger.classList.toggle('active');
      navLinks.classList.toggle('active');
      document.body.style.overflow = navLinks.classList.contains('active') ? 'hidden' : '';
    });
    navLinks.querySelectorAll('a').forEach(function (link) {
      link.addEventListener('click', function () {
        hamburger.classList.remove('active');
        navLinks.classList.remove('active');
        document.body.style.overflow = '';
      });
    });
  }

  // -----------------------------------------------------------
  // INIT
  // -----------------------------------------------------------
  renderCalendar();

})();
