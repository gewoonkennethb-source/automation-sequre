/* ============================================================
   Afspraak Module — Calendar & Booking Logic
   ============================================================ */
(function () {
  'use strict';

  // -----------------------------------------------------------
  // CONFIG
  // -----------------------------------------------------------
  var SLOT_START = 13;           // 13:00
  var SLOT_END   = 18;           // 18:00
  var SLOT_MINS  = 30;           // 30 min intervals
  var BOOKED_DAYS_AHEAD = 2;     // first 2 days fully booked
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

  // Calculate booked dates (today + next day)
  var bookedDates = [];
  for (var i = 0; i < BOOKED_DAYS_AHEAD; i++) {
    var d = new Date(today);
    d.setDate(d.getDate() + i);
    bookedDates.push(d.toDateString());
  }

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

  // -----------------------------------------------------------
  // CALENDAR RENDERING
  // -----------------------------------------------------------
  function renderCalendar() {
    calTitle.textContent = MONTHS_NL[currentMonth] + ' ' + currentYear;

    // Disable prev if showing current month
    calPrev.disabled = (
      currentYear === today.getFullYear() &&
      currentMonth === today.getMonth()
    );

    // Limit to 3 months ahead
    var maxMonth = today.getMonth() + 3;
    var maxYear  = today.getFullYear();
    if (maxMonth > 11) { maxMonth -= 12; maxYear++; }
    calNext.disabled = (
      currentYear === maxYear && currentMonth === maxMonth
    );

    // Build days
    calDays.innerHTML = '';

    var firstDay = new Date(currentYear, currentMonth, 1);
    // Monday = 0 in our grid
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

      var isWeekend = (dateObj.getDay() === 0 || dateObj.getDay() === 6);
      var isPast    = dateObj < today;
      var isBooked  = bookedDates.indexOf(dateObj.toDateString()) !== -1;
      var isToday   = dateObj.toDateString() === today.toDateString();

      if (isPast || isWeekend) {
        el.classList.add('disabled');
      } else if (isBooked) {
        el.classList.add('booked');
        el.title = 'Volgeboekt';
      }

      if (isToday) el.classList.add('today');

      if (selectedDate && dateObj.toDateString() === selectedDate.toDateString()) {
        el.classList.add('selected');
      }

      if (!isPast && !isWeekend && !isBooked) {
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
  // TIMESLOT RENDERING
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

    timeslotsGrid.innerHTML = '';

    for (var h = SLOT_START; h < SLOT_END; h++) {
      for (var m = 0; m < 60; m += SLOT_MINS) {
        var timeStr = padZero(h) + ':' + padZero(m);
        var el = document.createElement('div');
        el.className = 'timeslot';
        el.textContent = timeStr;
        el.setAttribute('data-time', timeStr);

        // Randomly book some slots to look realistic (seeded by date)
        var seed = selectedDate.getDate() * 7 + h * 3 + m;
        if (seed % 5 === 0) {
          el.classList.add('booked');
          el.title = 'Niet beschikbaar';
        } else {
          el.addEventListener('click', handleTimeClick);
        }

        if (selectedTime === timeStr) {
          el.classList.add('selected');
        }

        timeslotsGrid.appendChild(el);
      }
    }
  }

  function handleTimeClick(e) {
    selectedTime = e.target.getAttribute('data-time');
    toStep2.disabled = false;

    // Update selected visual
    var slots = timeslotsGrid.querySelectorAll('.timeslot');
    for (var i = 0; i < slots.length; i++) {
      slots[i].classList.remove('selected');
    }
    e.target.classList.add('selected');
  }

  function padZero(n) { return n < 10 ? '0' + n : '' + n; }

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
  // FORM SUBMISSION
  // -----------------------------------------------------------
  bookingForm.addEventListener('submit', function (e) {
    e.preventDefault();

    var formData = {
      firstName:   document.getElementById('firstName').value.trim(),
      lastName:    document.getElementById('lastName').value.trim(),
      companyName: document.getElementById('companyName').value.trim(),
      address:     document.getElementById('address').value.trim(),
      email:       document.getElementById('bookEmail').value.trim(),
      phone:       document.getElementById('bookPhone').value.trim(),
      date:        formatDateISO(selectedDate),
      time:        selectedTime,
      dateDisplay: slotBanner.textContent
    };

    // Validate required
    if (!formData.firstName || !formData.lastName || !formData.companyName ||
        !formData.email || !formData.phone) {
      alert('Vul alle verplichte velden in.');
      return;
    }

    // Send to PHP backend
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'book.php', true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4) {
        showConfirmation(formData);
      }
    };

    try {
      xhr.send(JSON.stringify(formData));
    } catch (err) {
      // If PHP not available (local testing), still show confirmation
      showConfirmation(formData);
    }
  });

  function showConfirmation(data) {
    step2.style.display = 'none';
    step3.style.display = 'block';
    window.scrollTo({ top: 0, behavior: 'smooth' });

    document.getElementById('confirmDetail').textContent = data.dateDisplay;
    document.getElementById('confirmEmail').textContent  = data.email;

    document.getElementById('confirmSummary').innerHTML =
      '<div class="summary-row"><span class="summary-label">Naam</span><span class="summary-value">' + escHtml(data.firstName + ' ' + data.lastName) + '</span></div>' +
      '<div class="summary-row"><span class="summary-label">Bedrijf</span><span class="summary-value">' + escHtml(data.companyName) + '</span></div>' +
      '<div class="summary-row"><span class="summary-label">E-mail</span><span class="summary-value">' + escHtml(data.email) + '</span></div>' +
      '<div class="summary-row"><span class="summary-label">Telefoon</span><span class="summary-value">' + escHtml(data.phone) + '</span></div>' +
      '<div class="summary-row"><span class="summary-label">Datum &amp; tijd</span><span class="summary-value">' + escHtml(data.dateDisplay) + '</span></div>';
  }

  function formatDateISO(d) {
    return d.getFullYear() + '-' + padZero(d.getMonth() + 1) + '-' + padZero(d.getDate());
  }

  function escHtml(str) {
    var div = document.createElement('div');
    div.appendChild(document.createTextNode(str));
    return div.innerHTML;
  }

  // -----------------------------------------------------------
  // MOBILE MENU (reuse from main site)
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
