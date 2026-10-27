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

  window.openMobileDrawer = function () {
    const drawer = document.getElementById('mobileDrawer');
    const overlay = document.getElementById('drawerOverlay');
    if (drawer && overlay) {
      drawer.classList.add('active');
      overlay.classList.add('active');
      document.body.style.overflow = 'hidden';
    }
  };

  window.closeMobileDrawer = function () {
    const drawer = document.getElementById('mobileDrawer');
    const overlay = document.getElementById('drawerOverlay');
    if (drawer && overlay) {
      drawer.classList.remove('active');
      overlay.classList.remove('active');
      document.body.style.overflow = '';
    }
  };

  function openDrawer() {
    window.openMobileDrawer();
  }

  function closeDrawer() {
    window.closeMobileDrawer();
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

    // Update dynamic UPI intent pay button
    const dynamicUpiBtn = document.getElementById('dynamicUpiPayBtn');
    if (dynamicUpiBtn) {
      const upiUrl = `upi://pay?pa=9093390934@sbi&pn=Shree%20Samast%20Leuva%20Patel%20Samaj%20Trust&am=${total}&cu=INR&tn=LPS%20Junagadh%20Bhumidan%20(${yards}%20Yards)`;
      dynamicUpiBtn.href = upiUrl;
    }

    const homeDynamicUpi = document.getElementById('homeDynamicUpiBtn');
    if (homeDynamicUpi) {
      const homeUpiUrl = `upi://pay?pa=9093390934@sbi&pn=Shree%20Samast%20Leuva%20Patel%20Samaj%20Trust&am=${total}&cu=INR&tn=LPS%20Junagadh%20Bhumidan%20(${yards}%20Yards)`;
      homeDynamicUpi.href = homeUpiUrl;
    }

    // Update dynamic UPI QR Code image
    const dynamicQrImg = document.getElementById('dynamicUpiQrImg');
    if (dynamicQrImg) {
      delete dynamicQrImg.dataset.fallback;
      const qrData = encodeURIComponent(`upi://pay?pa=9093390934@sbi&pn=Shree Samast Leuva Patel Samaj Trust&am=${total}&cu=INR&tn=LPS Junagadh Bhumidan`);
      dynamicQrImg.src = `https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=${qrData}`;
      dynamicQrImg.onerror = function() {
        if (!this.dataset.fallback) {
          this.dataset.fallback = '1';
          this.src = `https://quickchart.io/qr?size=150&text=${qrData}`;
        }
      };
    }

    // Update QR amount text badge
    const qrAmountBadge = document.getElementById('upiQrAmountBadge');
    if (qrAmountBadge) {
      qrAmountBadge.innerText = formatIndianCurrency(total) + '/-';
    }

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

  // Initial calculation trigger if elements present
  if (yardInput) {
    updateCalculation(yardInput.value || 1);
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

// 1-Click Clipboard Copy with UI feedback
function copyUpiId(text, btnElement) {
  if (navigator.clipboard && navigator.clipboard.writeText) {
    navigator.clipboard.writeText(text).then(() => {
      const originalHtml = btnElement.innerHTML;
      btnElement.innerHTML = '<i class="ri-check-line"></i> કોપી થઈ ગયું!';
      btnElement.style.borderColor = '#16a34a';
      btnElement.style.color = '#16a34a';
      setTimeout(() => {
        btnElement.innerHTML = originalHtml;
        btnElement.style.borderColor = '';
        btnElement.style.color = '';
      }, 2500);
    });
  } else {
    // Fallback for older browsers
    const tempInput = document.createElement('input');
    tempInput.value = text;
    document.body.appendChild(tempInput);
    tempInput.select();
    document.execCommand('copy');
    document.body.removeChild(tempInput);
    alert('UPI ID કોપી થઈ ગયું: ' + text);
  }
}

// Native Web Share API with WhatsApp Fallback
function shareReceiptNative(title, text, url, fallbackWhatsappUrl) {
  if (navigator.share) {
    navigator.share({
      title: title,
      text: text,
      url: url
    }).catch(err => {
      console.log('Share canceled or failed', err);
    });
  } else if (fallbackWhatsappUrl) {
    window.open(fallbackWhatsappUrl, '_blank');
  }
}

