/**
 * LPS Junagadh - Master Interactive JavaScript
 * Native App Feel & Mobile Responsive Interactions
 */

document.addEventListener('DOMContentLoaded', function () {
  // 1. Slide-over Mobile Navigation Drawer
  const mobileToggle = document.getElementById('mobileToggle');
  const bottomNavMenuBtn = document.getElementById('bottomNavMenuBtn');
  const drawerOverlay = document.getElementById('drawerOverlay');
  const mobileDrawer = document.getElementById('mobileDrawer');
  const drawerCloseBtn = document.getElementById('drawerCloseBtn');

  function openDrawer() {
    if (mobileDrawer && drawerOverlay) {
      mobileDrawer.classList.add('active');
      drawerOverlay.classList.add('active');
      document.body.style.overflow = 'hidden';
    }
  }

  function closeDrawer() {
    if (mobileDrawer && drawerOverlay) {
      mobileDrawer.classList.remove('active');
      drawerOverlay.classList.remove('active');
      document.body.style.overflow = '';
    }
  }

  if (mobileToggle) {
    mobileToggle.addEventListener('click', function (e) {
      e.preventDefault();
      openDrawer();
    });
  }
  if (bottomNavMenuBtn) {
    bottomNavMenuBtn.addEventListener('click', function (e) {
      e.preventDefault();
      openDrawer();
    });
  }
  if (drawerCloseBtn) {
    drawerCloseBtn.addEventListener('click', function (e) {
      e.preventDefault();
      closeDrawer();
    });
  }
  if (drawerOverlay) {
    drawerOverlay.addEventListener('click', function (e) {
      e.preventDefault();
      closeDrawer();
    });
  }

  // Close drawer on clicking any menu link
  const drawerLinks = document.querySelectorAll('.drawer-menu a');
  drawerLinks.forEach(link => {
    link.addEventListener('click', closeDrawer);
  });

  // 2. Bhumidan Live Yard Calculator
  const yardInput = document.getElementById('calcYards');
  const amountDisplay = document.getElementById('calcAmountDisplay');
  const pillButtons = document.querySelectorAll('.calc-pill-btn');
  const formYardInput = document.getElementById('formSqYards');
  const formAmountInput = document.getElementById('formTotalAmount');

  function formatIndianCurrency(num) {
    return '₹ ' + Number(num).toLocaleString('en-IN');
  }

  function updateCalculation(yards) {
    yards = parseInt(yards) || 1;
    if (yards < 1) yards = 1;

    const rate = 2500;
    const total = yards * rate;

    if (amountDisplay) {
      amountDisplay.innerText = formatIndianCurrency(total) + '/-';
    }

    if (formYardInput) formYardInput.value = yards;
    if (formAmountInput) formAmountInput.value = total;

    // Update active state on buttons
    pillButtons.forEach(btn => {
      if (parseInt(btn.dataset.yards) === yards) {
        btn.classList.add('active');
      } else {
        btn.classList.remove('active');
      }
    });
  }

  pillButtons.forEach(btn => {
    btn.addEventListener('click', function () {
      const yards = parseInt(this.dataset.yards);
      if (yardInput) yardInput.value = yards;
      updateCalculation(yards);
    });
  });

  if (yardInput) {
    yardInput.addEventListener('input', function () {
      updateCalculation(this.value);
    });
  }

  // 3. Facility Section Auto-populate in Booking Page
  const sectionSelect = document.getElementById('bookingSectionSelect');
  const facilitySelect = document.getElementById('bookingFacilitySelect');

  if (sectionSelect && facilitySelect) {
    const facilitiesMap = {
      'વિભાગ-૧': [
        'પાર્ટી પ્લોટ (૧૫૦૦ વ્યક્તિ માટે)',
        'બેન્કવેટ હોલ (૬૦૦ વ્યક્તિ માટે)',
        'ભોજનાલય (૮૦૦ વ્યક્તિ માટે)',
        'અતિથિ ભવન (૬૦ રૂમ)',
        'સમગ્ર વિભાગ-૧ સંકુલ'
      ],
      'વિભાગ-૨': [
        'પાર્ટી પ્લોટ (૫૦૦ વ્યક્તિ માટે)',
        'બેન્કવેટ હોલ (૫૦૦ વ્યક્તિ માટે)',
        'ભોજનાલય (૫૦૦ વ્યક્તિ માટે)',
        'ઉતારા માટે (૨૦ રૂમ)',
        'સમગ્ર વિભાગ-૨ સંકુલ'
      ],
      'અતિથિ ભવન': [
        'અતિથિ ભવન એ.સી. રૂમ (વિભાગ-૧)',
        'ઉતારા રૂમ (વિભાગ-૨)'
      ]
    };

    sectionSelect.addEventListener('change', function () {
      const selected = this.value;
      const options = facilitiesMap[selected] || [];

      facilitySelect.innerHTML = '<option value="">-- સુવિધા પસંદ કરો --</option>';
      options.forEach(f => {
        const opt = document.createElement('option');
        opt.value = f;
        opt.textContent = f;
        facilitySelect.appendChild(opt);
      });
    });
  }
});

// Digital Receipt Print Trigger
function printReceipt() {
  window.print();
}
