/**
 * LPS Junagadh - Toast Notification & Multi-Validation System
 * Pure Vanilla JavaScript • Toastr-compatible API • Zero Dependencies
 *
 * Provides right-side slide-in notifications with auto-hide, progress timer,
 * hover-pause, and consolidated display for multiple validation errors.
 */
(function (window, document) {
    'use strict';

    var CONTAINER_ID = 'lps-toast-container';

    var DEFAULTS = {
        duration: 5000,           // 5 seconds default
        validationDuration: 8000, // 8 seconds for multi-error lists
        closeButton: true,
        progressBar: true,
        pauseOnHover: true,
        maxToasts: 5
    };

    var ICONS = {
        success: 'ri-checkbox-circle-fill',
        error: 'ri-error-warning-fill',
        warning: 'ri-alert-fill',
        info: 'ri-information-fill',
        validation: 'ri-error-warning-line'
    };

    var DEFAULT_TITLES = {
        success: 'સફળતા',
        error: 'ક્ષતિ / ભૂલ',
        warning: 'ધ્યાન આપો',
        info: 'માહિતી',
        validation: 'કૃપા કરીને ભૂલો સુધારો'
    };

    function getContainer() {
        var container = document.getElementById(CONTAINER_ID);
        if (!container) {
            container = document.createElement('div');
            container.id = CONTAINER_ID;
            container.className = 'lps-toast-container';
            container.setAttribute('aria-live', 'polite');
            container.setAttribute('role', 'region');
            container.setAttribute('aria-label', 'Notifications');
            document.body.appendChild(container);
        }
        return container;
    }

    function createToast(type, message, title, options) {
        options = Object.assign({}, DEFAULTS, options || {});
        var container = getContainer();

        // Enforce max toasts limit by removing oldest
        while (container.children.length >= options.maxToasts) {
            removeToast(container.firstElementChild, true);
        }

        var isValidation = (type === 'validation');
        var duration = isValidation ? (options.duration || options.validationDuration) : options.duration;

        var toast = document.createElement('div');
        toast.className = 'lps-toast lps-toast-' + type;
        toast.setAttribute('role', isValidation || type === 'error' ? 'alert' : 'status');

        // Left Icon Badge
        var iconClass = ICONS[type] || ICONS.info;
        var iconEl = document.createElement('div');
        iconEl.className = 'lps-toast-icon';
        iconEl.innerHTML = '<i class="' + iconClass + '"></i>';
        toast.appendChild(iconEl);

        // Content Area
        var contentEl = document.createElement('div');
        contentEl.className = 'lps-toast-content';

        // Header (Title + Badge + Close)
        var headerEl = document.createElement('div');
        headerEl.className = 'lps-toast-header';

        var titleText = title || DEFAULT_TITLES[type] || '';
        var titleEl = document.createElement('div');
        titleEl.className = 'lps-toast-title';
        titleEl.textContent = titleText;

        headerEl.appendChild(titleEl);

        if (options.closeButton) {
            var closeBtn = document.createElement('button');
            closeBtn.type = 'button';
            closeBtn.className = 'lps-toast-close';
            closeBtn.setAttribute('aria-label', 'Close notification');
            closeBtn.innerHTML = '<i class="ri-close-line"></i>';
            closeBtn.addEventListener('click', function (e) {
                e.stopPropagation();
                removeToast(toast);
            });
            headerEl.appendChild(closeBtn);
        }
        contentEl.appendChild(headerEl);

        // Body: Message or Validation List
        var bodyEl = document.createElement('div');
        bodyEl.className = 'lps-toast-body';

        if (Array.isArray(message)) {
            // Render consolidated validation items together
            var listEl = document.createElement('ul');
            listEl.className = 'lps-toast-validation-list';

            message.forEach(function (msg) {
                if (!msg) return;
                var item = document.createElement('li');
                item.className = 'lps-toast-validation-item';
                item.innerHTML = '<i class="ri-arrow-right-s-fill"></i><span>' + escapeHtml(msg) + '</span>';
                listEl.appendChild(item);
            });

            // Add count pill in title if more than 1
            if (message.length > 1) {
                var badge = document.createElement('span');
                badge.className = 'lps-toast-badge';
                badge.textContent = message.length + ' ભૂલો';
                titleEl.appendChild(badge);
            }

            bodyEl.appendChild(listEl);
        } else {
            var p = document.createElement('div');
            p.className = 'lps-toast-message';
            p.innerHTML = escapeHtml(String(message));
            bodyEl.appendChild(p);
        }
        contentEl.appendChild(bodyEl);
        toast.appendChild(contentEl);

        // Bottom Progress Bar
        var progressBarInner;
        if (options.progressBar && duration > 0) {
            var progressWrap = document.createElement('div');
            progressWrap.className = 'lps-toast-progress';
            progressBarInner = document.createElement('div');
            progressBarInner.className = 'lps-toast-progress-bar';
            progressWrap.appendChild(progressBarInner);
            toast.appendChild(progressWrap);
        }

        // Timer & Hover Pause Handling
        var remaining = duration;
        var startTime = Date.now();
        var timerId = null;

        function startTimer() {
            if (duration <= 0) return;
            startTime = Date.now();
            if (progressBarInner) {
                progressBarInner.style.transition = 'width ' + remaining + 'ms linear';
                progressBarInner.style.width = '0%';
            }
            timerId = setTimeout(function () {
                removeToast(toast);
            }, remaining);
        }

        function pauseTimer() {
            if (duration <= 0) return;
            clearTimeout(timerId);
            var elapsed = Date.now() - startTime;
            remaining = Math.max(0, remaining - elapsed);
            if (progressBarInner) {
                var computedWidth = window.getComputedStyle(progressBarInner).width;
                progressBarInner.style.transition = 'none';
                progressBarInner.style.width = computedWidth;
            }
        }

        if (options.pauseOnHover && duration > 0) {
            toast.addEventListener('mouseenter', pauseTimer);
            toast.addEventListener('mouseleave', function () {
                if (remaining > 0) {
                    startTimer();
                } else {
                    removeToast(toast);
                }
            });
        }

        container.appendChild(toast);
        startTimer();

        return toast;
    }

    function removeToast(toast, immediate) {
        if (!toast || toast._isRemoving) return;
        toast._isRemoving = true;

        if (immediate) {
            if (toast.parentNode) toast.parentNode.removeChild(toast);
            return;
        }

        toast.classList.add('lps-toast-hiding');
        setTimeout(function () {
            if (toast.parentNode) {
                toast.parentNode.removeChild(toast);
            }
        }, 320);
    }

    function escapeHtml(str) {
        var div = document.createElement('div');
        div.textContent = str;
        return div.innerHTML;
    }

    // Public Toastr API
    var toastr = {
        success: function (message, title, options) {
            return createToast('success', message, title || DEFAULT_TITLES.success, options);
        },
        error: function (message, title, options) {
            return createToast('error', message, title || DEFAULT_TITLES.error, options);
        },
        warning: function (message, title, options) {
            return createToast('warning', message, title || DEFAULT_TITLES.warning, options);
        },
        info: function (message, title, options) {
            return createToast('info', message, title || DEFAULT_TITLES.info, options);
        },
        /**
         * Display all validation messages together in a single consolidated toast
         * @param {Array<string>|Object|string} errors - List or map of validation errors
         * @param {string} [title] - Optional custom title
         * @param {Object} [options] - Optional toast configurations
         */
        validation: function (errors, title, options) {
            var messages = [];
            if (Array.isArray(errors)) {
                messages = errors;
            } else if (typeof errors === 'object' && errors !== null) {
                Object.keys(errors).forEach(function (key) {
                    var val = errors[key];
                    if (Array.isArray(val)) {
                        messages = messages.concat(val);
                    } else if (typeof val === 'string') {
                        messages.push(val);
                    }
                });
            } else if (typeof errors === 'string') {
                messages = [errors];
            }

            if (!messages.length) return null;

            return createToast('validation', messages, title || DEFAULT_TITLES.validation, options);
        },
        clear: function () {
            var container = document.getElementById(CONTAINER_ID);
            if (container) {
                var toasts = Array.prototype.slice.call(container.children);
                toasts.forEach(function (t) {
                    removeToast(t);
                });
            }
        },
        remove: function (toast) {
            removeToast(toast, true);
        }
    };

    // Client-side HTML5 Form Multi-Validation Interceptor
    // Shows all invalid fields in a single consolidated toast on form submit
    function initClientFormValidation() {
        // Suppress browser native single tooltip popups
        document.addEventListener('invalid', function (e) {
            e.preventDefault();
        }, true);

        function applyNovalidate(root) {
            var forms = (root || document).querySelectorAll('form');
            for (var i = 0; i < forms.length; i++) {
                if (!forms[i].hasAttribute('data-native-validation')) {
                    forms[i].setAttribute('novalidate', 'true');
                }
            }
        }

        applyNovalidate();

        if (window.MutationObserver) {
            var observer = new MutationObserver(function (mutations) {
                mutations.forEach(function (m) {
                    m.addedNodes.forEach(function (node) {
                        if (node.nodeType === 1) {
                            if (node.tagName === 'FORM' && !node.hasAttribute('data-native-validation')) {
                                node.setAttribute('novalidate', 'true');
                            } else if (node.querySelectorAll) {
                                applyNovalidate(node);
                            }
                        }
                    });
                });
            });
            observer.observe(document.body || document.documentElement, { childList: true, subtree: true });
        }

        document.addEventListener('submit', function (e) {
            var form = e.target;
            if (!form || !form.matches || !form.matches('form')) return;

            // Allow bypass if explicitly tagged
            if (form.hasAttribute('data-no-toast-validation') || form.hasAttribute('data-native-validation')) return;

            if (form.checkValidity && !form.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();

                var invalidElements = form.querySelectorAll(':invalid');
                var errors = [];
                var firstInvalid = null;

                invalidElements.forEach(function (el) {
                    if (!firstInvalid) firstInvalid = el;

                    var labelText = '';
                    var parentGroup = el.closest('.form-group') || el.parentElement;
                    var label = form.querySelector('label[for="' + el.id + '"]') || (parentGroup ? parentGroup.querySelector('.form-label, label') : null);

                    if (label) {
                        labelText = label.innerText.replace(/[*:]/g, '').trim();
                    } else if (el.placeholder) {
                        labelText = el.placeholder.replace(/[*:]/g, '').trim();
                    } else if (el.name) {
                        labelText = el.name;
                    }

                    var msg = '';
                    if (el.validity.valueMissing) {
                        msg = labelText ? (labelText + ' દાખલ કરવું ફરજિયાત છે.') : 'આ વિગત દાખલ કરવી જરૂરી છે.';
                    } else if (el.validity.typeMismatch && el.type === 'email') {
                        msg = labelText ? ('સાચો ' + labelText + ' (ઇમેઇલ) દાખલ કરો.') : 'સાચો ઇમેઇલ દાખલ કરો.';
                    } else if (el.validity.patternMismatch) {
                        msg = labelText ? (labelText + ' યોગ્ય ફોર્મેટમાં દાખલ કરો.') : 'અમાન્ય ફોર્મેટ.';
                    } else if (el.validity.rangeUnderflow || el.validity.rangeOverflow) {
                        msg = labelText ? (labelText + ': માન્ય સંખ્યા દાખલ કરો.') : 'માન્ય સંખ્યા દાખલ કરો.';
                    } else if (el.validity.tooShort) {
                        msg = labelText ? (labelText + ' ઓછામાં ઓછું ' + el.minLength + ' અક્ષરનું હોવું જોઈએ.') : 'વિગત ખૂબ ટૂંકી છે.';
                    } else {
                        msg = (labelText ? labelText + ': ' : '') + el.validationMessage;
                    }

                    if (msg && errors.indexOf(msg) === -1) {
                        errors.push(msg);
                    }

                    el.classList.add('is-invalid');
                });

                if (errors.length > 0) {
                    toastr.validation(errors, 'કૃપા કરીને નીચેની જરૂરી વિગતો ભરો:');
                }

                if (firstInvalid && typeof firstInvalid.focus === 'function') {
                    firstInvalid.focus();
                }
            }
        }, true);

        // Remove is-invalid state when user modifies the input
        document.addEventListener('input', function (e) {
            var target = e.target;
            if (target && target.classList && target.classList.contains('is-invalid')) {
                if (target.checkValidity()) {
                    target.classList.remove('is-invalid');
                }
            }
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initClientFormValidation);
    } else {
        initClientFormValidation();
    }

    // Expose both window.toastr and window.LpsToast
    window.toastr = toastr;
    window.LpsToast = toastr;

})(window, document);
