/**
 * LPS Junagadh - High-Accuracy Client Telemetry Collector
 * Detects: Exact Device Model, GPU Architecture, Screen Viewport, and Geolocation (City, State, Postal, ISP)
 */
(function() {
    window._lpsClientTelemetry = {
        city: '',
        region: '',
        country: 'India',
        postal: '',
        isp: '',
        location: '',
        deviceModel: '',
        gpuRenderer: '',
        screen: (window.screen ? window.screen.width + 'x' + window.screen.height : ''),
        viewport: window.innerWidth + 'x' + window.innerHeight,
        pixelRatio: window.devicePixelRatio || 1,
        touch: ('ontouchstart' in window || navigator.maxTouchPoints > 0) ? 'yes' : 'no',
        timezone: Intl.DateTimeFormat().resolvedOptions().timeZone || '',
        language: navigator.language || '',
        platform: navigator.platform || ''
    };

    // 1. Hardware / GPU detection via WebGL (reveals Intel Iris, NVIDIA GeForce, Apple M-Series)
    try {
        var canvas = document.createElement('canvas');
        var gl = canvas.getContext('webgl') || canvas.getContext('experimental-webgl');
        if (gl) {
            var debugInfo = gl.getExtension('WEBGL_debug_renderer_info');
            if (debugInfo) {
                window._lpsClientTelemetry.gpuRenderer = gl.getParameter(debugInfo.UNMASKED_RENDERER_WEBGL) || '';
            }
        }
    } catch (e) {}

    // 2. High-Entropy Client Hints (Chromium: Android, Chrome, Edge - gives exact model e.g. SM-S928B)
    if (navigator.userAgentData && typeof navigator.userAgentData.getHighEntropyValues === 'function') {
        navigator.userAgentData.getHighEntropyValues(['model', 'platform', 'platformVersion', 'architecture'])
            .then(function(hints) {
                if (hints && hints.model) {
                    window._lpsClientTelemetry.deviceModel = hints.model;
                }
                if (hints && hints.platform) {
                    window._lpsClientTelemetry.platform = hints.platform + (hints.platformVersion ? ' ' + hints.platformVersion : '');
                }
            })
            .catch(function() {});
    }

    // 3. Fast HTTPS IP Geolocation in background (Non-blocking)
    fetch('https://ipwho.is/')
        .then(function(res) { return res.json(); })
        .then(function(data) {
            if (data && data.success) {
                window._lpsClientTelemetry.city = data.city || '';
                window._lpsClientTelemetry.region = data.region || '';
                window._lpsClientTelemetry.country = data.country || 'India';
                window._lpsClientTelemetry.postal = data.postal || '';
                window._lpsClientTelemetry.isp = (data.connection && data.connection.isp) ? data.connection.isp : '';

                var locParts = [];
                if (data.city) locParts.push(data.city);
                if (data.region && data.region !== data.city) locParts.push(data.region);
                if (data.postal) locParts.push('(' + data.postal + ')');
                if (data.country) locParts.push(data.country);

                var fullLoc = locParts.join(', ');
                if (window._lpsClientTelemetry.isp) {
                    fullLoc += ' • ' + window._lpsClientTelemetry.isp;
                }
                window._lpsClientTelemetry.location = fullLoc;
            }
        })
        .catch(function() {
            // Secondary fallback: ipapi.co
            fetch('https://ipapi.co/json/')
                .then(function(res) { return res.json(); })
                .then(function(data) {
                    if (data && data.city) {
                        window._lpsClientTelemetry.city = data.city || '';
                        window._lpsClientTelemetry.region = data.region || '';
                        window._lpsClientTelemetry.country = data.country_name || 'India';
                        window._lpsClientTelemetry.postal = data.postal || '';
                        window._lpsClientTelemetry.isp = data.org || '';
                        window._lpsClientTelemetry.location = [data.city, data.region, data.country_name].filter(Boolean).join(', ');
                    }
                })
                .catch(function() {});
        });

    // 4. Telemetry Injection into Form Submissions
    function injectTelemetry(form) {
        if (!form || form.tagName !== 'FORM') return;
        var input = form.querySelector('input[name="_client_system"]');
        if (!input) {
            input = document.createElement('input');
            input.type = 'hidden';
            input.name = '_client_system';
            form.appendChild(input);
        }
        var latest = Object.assign({}, window._lpsClientTelemetry || {}, {
            screen: (window.screen ? window.screen.width + 'x' + window.screen.height : ''),
            viewport: window.innerWidth + 'x' + window.innerHeight
        });
        input.value = JSON.stringify(latest);
    }

    document.addEventListener('submit', function(e) {
        injectTelemetry(e.target);
    }, true);

    window.injectClientTelemetry = injectTelemetry;
})();
