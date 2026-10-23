/**
 * LPS Junagadh - Gujarati English-to-Gujarati Transliteration & Suggestions Engine
 * Automatically attaches to each and every text input across public & admin forms.
 * Powered by Google Input Tools API with smart caching, offline phonetic fallback,
 * tactile suggestion box, mobile touch support, and Ctrl+G toggle.
 */

(function () {
  'use strict';

  // State Management
  const STORAGE_KEY = 'lps_guj_transliterate_enabled';
  let isEnabled = localStorage.getItem(STORAGE_KEY) !== 'false'; // Enabled by default
  let activeInput = null;
  let currentWord = '';
  let wordStartIndex = 0;
  let candidates = [];
  let selectedIndex = 0;
  let debounceTimer = null;
  let abortController = null;
  const cache = new Map();

  // Basic Phonetic Fallback Dictionary for common terms
  const phoneticCommonWords = {
    'ramesh': ['રમેશ', 'રામેશ', 'રમેશભાઈ'],
    'rameshbhai': ['રમેશભાઈ', 'રમેશભાઇ'],
    'patel': ['પટેલ', 'પટેલશ્રી', 'પટૅલ'],
    'junagadh': ['જૂનાગઢ', 'જુનાગઢ'],
    'shree': ['શ્રી', 'શ્રીમાન'],
    'samast': ['સમસ્ત'],
    'leuva': ['લેઉવા', 'લેવા'],
    'samaj': ['સમાજ', 'સામાજિક'],
    'trust': ['ટ્રસ્ટ'],
    'bhumidan': ['ભૂમિદાન', 'ભૂમિદાન યોજના'],
    'sankalp': ['સંકલ્પ', 'સેવા સંકલ્પ'],
    'khodaldham': ['ખોડલધામ'],
    'sardar': ['સરદાર', 'જય સરદાર'],
    'jay': ['જય', 'જયશ્રી'],
    'bhai': ['ભાઈ', 'ભાઇ'],
    'ben': ['બેન', 'બહેન'],
    'kumar': ['કુમાર'],
    'sinh': ['સિંહ'],
    'gam': ['ગામ'],
    'khalilpur': ['ખલીલપુર'],
    'vanthali': ['વંથલી'],
    'keshod': ['કેશોદ'],
    'visavadar': ['વિસાવદર'],
    'rajkot': ['રાજકોટ'],
    'ahmedabad': ['અમદાવાદ'],
    'surat': ['સુરત'],
    'baroda': ['વડોદરા', 'બરોડા'],
    'booking': ['બુકિંગ'],
    'hall': ['હોલ'],
    'party': ['પાર્ટી'],
    'plot': ['પ્લોટ'],
    'event': ['કાર્યક્રમ', 'ઇવેન્ટ']
  };

  // Check if an element is eligible for Gujarati transliteration
  function isEligibleInput(el) {
    if (!el || el.disabled || el.readOnly) return false;
    const tag = el.tagName.toLowerCase();
    if (tag === 'textarea') {
      return el.dataset.noGujarati !== 'true' && !el.classList.contains('no-gujarati');
    }
    if (tag === 'input') {
      const type = (el.type || 'text').toLowerCase();
      const excludedTypes = [
        'password', 'email', 'number', 'tel', 'date', 'time',
        'datetime-local', 'file', 'checkbox', 'radio', 'hidden',
        'range', 'color', 'submit', 'button', 'reset'
      ];
      if (excludedTypes.includes(type)) return false;
      if (el.dataset.noGujarati === 'true' || el.classList.contains('no-gujarati')) return false;
      return true;
    }
    return false;
  }

  // Create UI Elements: Suggestion Box & Floating Switch
  let suggestBox = null;
  let floatingToggleBtn = null;

  function createUI() {
    // 1. Floating Suggestion Box
    suggestBox = document.createElement('div');
    suggestBox.className = 'guj-suggest-box';
    suggestBox.id = 'gujSuggestBox';
    suggestBox.innerHTML = `
      <div class="guj-suggest-header">
        <span><i class="ri-translate-2"></i> ગુજરાતી સૂચન</span>
        <span style="font-size:0.68rem; opacity:0.85; cursor:pointer;" id="gujDismissBtn" title="બંધ કરો">ESC ✕</span>
      </div>
      <ul class="guj-suggest-list" id="gujSuggestList"></ul>
      <div class="guj-suggest-footer">
        Space / Enter / નંબર થી પસંદ કરો
      </div>
    `;
    document.body.appendChild(suggestBox);

    // Dismiss button click
    const dismissBtn = suggestBox.querySelector('#gujDismissBtn');
    if (dismissBtn) {
      dismissBtn.addEventListener('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        hideSuggestions();
      });
    }

    // 2. Floating Global Language Toggle Button
    floatingToggleBtn = document.createElement('button');
    floatingToggleBtn.type = 'button';
    floatingToggleBtn.className = 'guj-toggle-floating-btn ' + (isEnabled ? 'active' : 'disabled');
    floatingToggleBtn.id = 'gujFloatingToggleBtn';
    floatingToggleBtn.setAttribute('title', 'ગુજરાતી / English સ્વિચ કરો (Shortcut: Ctrl + G)');
    floatingToggleBtn.innerHTML = `
      <span class="indicator-dot"></span>
      <span class="btn-text">${isEnabled ? 'ગુજરાતી' : 'English'}</span>
      <span style="opacity:0.75; font-size:0.65rem; font-weight:600;">(Ctrl+G)</span>
    `;
    document.body.appendChild(floatingToggleBtn);

    floatingToggleBtn.addEventListener('click', function (e) {
      e.preventDefault();
      toggleTransliteration();
    });
  }

  // Toggle Transliteration On/Off
  function toggleTransliteration(forceState) {
    if (typeof forceState === 'boolean') {
      isEnabled = forceState;
    } else {
      isEnabled = !isEnabled;
    }
    localStorage.setItem(STORAGE_KEY, isEnabled ? 'true' : 'false');

    if (floatingToggleBtn) {
      floatingToggleBtn.className = 'guj-toggle-floating-btn ' + (isEnabled ? 'active' : 'disabled');
      const textSpan = floatingToggleBtn.querySelector('.btn-text');
      if (textSpan) {
        textSpan.textContent = isEnabled ? 'ગુજરાતી' : 'English';
      }
    }

    showToast(isEnabled ? '✓ ગુજરાતી ટાઈપિંગ ચાલુ થયું' : '✕ English ટાઈપિંગ સક્રિય');

    if (!isEnabled) {
      hideSuggestions();
    }
  }

  // Lightweight Toast Notification
  function showToast(msg) {
    let toast = document.getElementById('gujToast');
    if (!toast) {
      toast = document.createElement('div');
      toast.id = 'gujToast';
      toast.style.cssText = `
        position: fixed;
        bottom: 130px;
        right: 20px;
        background: rgba(24, 24, 27, 0.95);
        color: #fff;
        padding: 0.5rem 1rem;
        border-radius: 9999px;
        font-size: 0.82rem;
        font-weight: 700;
        z-index: 1000000;
        box-shadow: 0 4px 14px rgba(0,0,0,0.25);
        pointer-events: none;
        transition: opacity 0.25s ease, transform 0.25s ease;
        opacity: 0;
        transform: translateY(10px);
      `;
      document.body.appendChild(toast);
    }
    toast.textContent = msg;
    toast.style.opacity = '1';
    toast.style.transform = 'translateY(0)';
    setTimeout(() => {
      toast.style.opacity = '0';
      toast.style.transform = 'translateY(10px)';
    }, 2200);
  }

  // Hide the suggestions box
  function hideSuggestions() {
    if (suggestBox) {
      suggestBox.style.display = 'none';
    }
    candidates = [];
    selectedIndex = 0;
  }

  // Position the floating suggestion box directly near the active input
  function positionSuggestBox(input) {
    if (!suggestBox || !input) return;
    const rect = input.getBoundingClientRect();
    const boxHeight = 220; // approximate maximum height
    const boxWidth = Math.max(rect.width, 240);
    const windowHeight = window.innerHeight;
    const windowWidth = window.innerWidth;

    // Check if enough space below input, otherwise position above
    let top = rect.bottom + window.scrollY + 6;
    if (rect.bottom + boxHeight > windowHeight && rect.top > boxHeight) {
      top = rect.top + window.scrollY - boxHeight - 6;
    }

    // Align left with input, keeping within screen bounds
    let left = rect.left + window.scrollX;
    if (left + boxWidth > windowWidth - 10) {
      left = Math.max(10, windowWidth - boxWidth - 10);
    }

    suggestBox.style.top = `${top}px`;
    suggestBox.style.left = `${left}px`;
    suggestBox.style.width = `${Math.min(boxWidth, 340)}px`;
    suggestBox.style.display = 'block';
  }

  // Render Candidates into Dropdown
  function renderSuggestions(cands) {
    if (!suggestBox || !activeInput) return;
    const list = suggestBox.querySelector('#gujSuggestList');
    if (!list) return;

    list.innerHTML = '';
    if (!cands || cands.length === 0) {
      hideSuggestions();
      return;
    }

    candidates = cands;
    selectedIndex = 0;

    candidates.forEach((cand, idx) => {
      const li = document.createElement('li');
      li.className = 'guj-suggest-item' + (idx === 0 ? ' active' : '');
      li.dataset.index = idx;
      li.innerHTML = `
        <span class="candidate-text">${cand}</span>
        <span class="candidate-idx">${idx + 1}</span>
      `;

      // Click or touch selection
      li.addEventListener('mousedown', function (e) {
        e.preventDefault(); // Prevent input blur
        selectCandidate(idx, true);
      });

      li.addEventListener('mouseenter', function () {
        setSelectedIndex(idx);
      });

      list.appendChild(li);
    });

    // Also add option to keep original English word as last item
    const originalLi = document.createElement('li');
    originalLi.className = 'guj-suggest-item';
    originalLi.dataset.index = candidates.length;
    originalLi.innerHTML = `
      <span class="candidate-text" style="font-family:var(--font-latin); color:#52525b; font-size:0.85rem;">${currentWord} (English)</span>
      <span class="candidate-idx" style="font-size:0.65rem;">ESC</span>
    `;
    originalLi.addEventListener('mousedown', function (e) {
      e.preventDefault();
      hideSuggestions();
    });
    list.appendChild(originalLi);

    positionSuggestBox(activeInput);
  }

  function setSelectedIndex(idx) {
    if (!suggestBox) return;
    const items = suggestBox.querySelectorAll('.guj-suggest-item');
    items.forEach((item, i) => {
      if (i === idx) {
        item.classList.add('active');
        item.scrollIntoView({ block: 'nearest' });
      } else {
        item.classList.remove('active');
      }
    });
    selectedIndex = idx;
  }

  // Select candidate and replace current word in active input
  function selectCandidate(idx, addSpaceAfter) {
    if (!activeInput || candidates.length === 0) return;
    const chosen = candidates[idx] || candidates[0];
    if (!chosen) return;

    const val = activeInput.value;
    const cursorPos = activeInput.selectionStart;
    const textBefore = val.substring(0, cursorPos);
    const textAfter = val.substring(cursorPos);

    // Replace the trailing English word
    const match = textBefore.match(/[a-zA-Z]+$/);
    if (match) {
      const startIdx = cursorPos - match[0].length;
      const spaceStr = addSpaceAfter ? ' ' : '';
      const newBefore = textBefore.substring(0, startIdx) + chosen + spaceStr;
      activeInput.value = newBefore + textAfter;
      const newCursor = newBefore.length;
      activeInput.setSelectionRange(newCursor, newCursor);

      // Trigger standard input/change events
      activeInput.dispatchEvent(new Event('input', { bubbles: true }));
      activeInput.dispatchEvent(new Event('change', { bubbles: true }));
    }

    hideSuggestions();
  }

  // Fetch Transliteration from Google Input Tools API with caching & fallback
  async function fetchTransliteration(word) {
    const lowerWord = word.toLowerCase();

    // 1. Check in-memory cache
    if (cache.has(lowerWord)) {
      renderSuggestions(cache.get(lowerWord));
      return;
    }

    // 2. Abort previous in-flight request
    if (abortController) {
      abortController.abort();
    }
    abortController = new AbortController();

    try {
      const apiUrl = `https://inputtools.google.com/request?text=${encodeURIComponent(word)}&itc=gu-t-i0-und&num=5&cp=0&cs=1&ie=utf-8&oe=utf-8`;
      const response = await fetch(apiUrl, {
        signal: abortController.signal
      });

      if (!response.ok) {
        throw new Error(`HTTP error ${response.status}`);
      }

      const data = await response.json();
      if (data && data[0] === 'SUCCESS' && data[1] && data[1][0] && data[1][0][1]) {
        const results = data[1][0][1];
        cache.set(lowerWord, results);
        // Only render if still on the same word
        if (currentWord.toLowerCase() === lowerWord) {
          renderSuggestions(results);
        }
        return;
      }
    } catch (err) {
      if (err.name === 'AbortError') return;
      console.warn('Google Transliterate API offline, falling back to local phonetic:', err);
    }

    // 3. Fallback to local dictionary
    if (phoneticCommonWords[lowerWord]) {
      const fallbackList = phoneticCommonWords[lowerWord];
      cache.set(lowerWord, fallbackList);
      renderSuggestions(fallbackList);
    } else {
      hideSuggestions();
    }
  }

  // Handle Input Event
  function handleInputEvent(e) {
    if (!isEnabled) return;
    const target = e.target;
    if (!isEligibleInput(target)) return;

    activeInput = target;
    const val = target.value;
    const cursorPos = target.selectionStart;
    const textBefore = val.substring(0, cursorPos);

    // Look for English/Latin letters directly preceding the caret
    const match = textBefore.match(/[a-zA-Z]+$/);
    if (!match || match[0].length < 1) {
      hideSuggestions();
      return;
    }

    currentWord = match[0];
    wordStartIndex = cursorPos - currentWord.length;

    // Debounce API calls by 120ms for buttery-smooth performance
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(() => {
      fetchTransliteration(currentWord);
    }, 120);
  }

  // Handle Keydown Event
  function handleKeyDownEvent(e) {
    // Global Shortcut: Ctrl + G toggles Gujarati / English typing
    if (e.ctrlKey && (e.key === 'g' || e.key === 'G')) {
      e.preventDefault();
      toggleTransliteration();
      return;
    }

    if (!isEnabled) return;
    const target = e.target;
    if (!isEligibleInput(target)) return;

    activeInput = target;

    // When suggestion box is visible
    if (suggestBox && suggestBox.style.display === 'block' && candidates.length > 0) {
      // 1. Space: Select active candidate and append a space
      if (e.key === ' ') {
        e.preventDefault();
        selectCandidate(selectedIndex, true);
        return;
      }

      // 2. Enter: Select active candidate without submitting form
      if (e.key === 'Enter') {
        e.preventDefault();
        selectCandidate(selectedIndex, false);
        return;
      }

      // 3. Arrow Down: Move selection down
      if (e.key === 'ArrowDown') {
        e.preventDefault();
        const nextIdx = (selectedIndex + 1) % candidates.length;
        setSelectedIndex(nextIdx);
        return;
      }

      // 4. Arrow Up: Move selection up
      if (e.key === 'ArrowUp') {
        e.preventDefault();
        const prevIdx = (selectedIndex - 1 + candidates.length) % candidates.length;
        setSelectedIndex(prevIdx);
        return;
      }

      // 5. Escape: Dismiss suggestions and keep English word
      if (e.key === 'Escape') {
        e.preventDefault();
        hideSuggestions();
        return;
      }

      // 6. Number keys (1 to 5): Directly pick candidate
      if (!e.ctrlKey && !e.altKey && !e.metaKey && e.key >= '1' && e.key <= '5') {
        const num = parseInt(e.key, 10) - 1;
        if (num < candidates.length) {
          e.preventDefault();
          selectCandidate(num, true);
          return;
        }
      }
    }
  }

  // Focus and Blur listeners
  function handleFocusIn(e) {
    if (!isEligibleInput(e.target)) return;
    activeInput = e.target;
    activeInput.classList.add('has-guj-enabled');
  }

  function handleFocusOut(e) {
    // Delay hiding so clicks on candidates can register
    setTimeout(() => {
      if (document.activeElement !== activeInput) {
        hideSuggestions();
      }
    }, 200);
  }

  // Initialize on DOM ready
  document.addEventListener('DOMContentLoaded', function () {
    createUI();

    // Event Delegation on document - covers EVERY input on public & admin pages
    document.addEventListener('input', handleInputEvent, true);
    document.addEventListener('keydown', handleKeyDownEvent, true);
    document.addEventListener('focusin', handleFocusIn, true);
    document.addEventListener('focusout', handleFocusOut, true);

    // Dismiss suggestions on outside click
    document.addEventListener('click', function (e) {
      if (suggestBox && !suggestBox.contains(e.target) && e.target !== activeInput) {
        hideSuggestions();
      }
    });

    // Reposition suggestion box on window resize / scroll
    window.addEventListener('resize', function () {
      if (activeInput && suggestBox && suggestBox.style.display === 'block') {
        positionSuggestBox(activeInput);
      }
    });
  });

  // Expose Global Helper API for window
  window.GujaratiTransliterate = {
    toggle: toggleTransliteration,
    enable: () => toggleTransliteration(true),
    disable: () => toggleTransliteration(false),
    isEnabled: () => isEnabled,
    hide: hideSuggestions
  };

})();
