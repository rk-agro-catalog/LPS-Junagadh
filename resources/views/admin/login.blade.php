<!DOCTYPE html>
<html lang="gu">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>એડમિન લૉગિન | શ્રી સમસ્ત લેઉવા પટેલ સમાજ ટ્રસ્ટ - જૂનાગઢ</title>
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><circle cx='50' cy='50' r='48' fill='%23b45309'/><text x='50' y='64' font-size='38' font-weight='bold' fill='%23fef08a' text-anchor='middle'>LPS</text></svg>">
    
    <!-- Remix Icons -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet"/>

    <!-- Master CSS -->
    <link rel="stylesheet" href="{{ asset('css/lps-style.css') }}">
    
    <style>
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: radial-gradient(circle at 50% 20%, #450a0a 0%, #1f0404 60%, #0d0101 100%);
            padding: 1.5rem;
            position: relative;
            overflow-x: hidden;
        }
        .login-card {
            width: 100%;
            max-width: 440px;
            background: #ffffff;
            border-radius: var(--radius-xl);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.4), 0 0 0 1px rgba(245, 158, 11, 0.2);
            padding: clamp(2rem, 5vw, 2.5rem);
            position: relative;
            z-index: 10;
        }
        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        .login-emblem {
            width: 68px;
            height: 68px;
            background: var(--gradient-royal);
            color: #fef08a;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            box-shadow: 0 10px 20px -5px rgba(180, 83, 9, 0.4);
            margin-bottom: 1rem;
            border: 2px solid var(--color-gold);
        }
        .input-icon-wrap {
            position: relative;
        }
        .input-icon-wrap i.input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            font-size: 1.15rem;
            pointer-events: none;
        }
        .input-icon-wrap .form-control {
            padding-left: 2.85rem;
        }
        .toggle-password {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #9ca3af;
            cursor: pointer;
            font-size: 1.2rem;
            padding: 0;
            display: flex;
            align-items: center;
        }
        .toggle-password:hover {
            color: var(--color-maroon);
        }
        .demo-credentials-box {
            background: #fffbeb;
            border: 1px dashed #f59e0b;
            border-radius: var(--radius-md);
            padding: 0.75rem 1rem;
            margin-top: 1.5rem;
            font-size: 0.82rem;
            color: #78350f;
        }
    </style>
</head>
<body>

    <div class="login-card">
        <div class="login-header">
            <div class="login-emblem">
                <i class="ri-shield-star-fill"></i>
            </div>
            <div style="font-size: 0.85rem; font-weight: 700; color: var(--color-primary-light); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.35rem;">
                ટ્રસ્ટ કાર્યાલય પોર્ટલ
            </div>
            <h1 style="font-size: 1.45rem; font-weight: 900; color: var(--color-maroon); line-height: 1.3;">
                શ્રી સમસ્ત લેઉવા પટેલ સમાજ ટ્રસ્ટ
            </h1>
            <p style="font-size: 0.85rem; color: var(--color-text-muted); margin-top: 0.35rem;">
                જૂનાગઢ • એડમિન લૉગિન
            </p>
        </div>

        @if(session('success'))
            <div class="alert alert-success" style="margin-bottom: 1.25rem;">
                <i class="ri-checkbox-circle-fill"></i>
                <div style="font-size: 0.88rem;">{{ session('success') }}</div>
            </div>
        @endif

        @if(session('warning'))
            <div class="alert" style="background: #fffbeb; border-left: 4px solid #f59e0b; color: #92400e; padding: 0.75rem 1rem; border-radius: var(--radius-md); margin-bottom: 1.25rem; display: flex; gap: 0.5rem; align-items: flex-start;">
                <i class="ri-time-line" style="font-size: 1.2rem; flex-shrink: 0; color: #d97706;"></i>
                <div style="font-size: 0.88rem;">{{ session('warning') }}</div>
            </div>
        @endif

        @if($errors->any())
            <div class="alert" style="background: #fef2f2; border-left: 4px solid #ef4444; color: #991b1b; padding: 0.75rem 1rem; border-radius: var(--radius-md); margin-bottom: 1.25rem; display: flex; gap: 0.5rem; align-items: flex-start;">
                <i class="ri-error-warning-fill" style="font-size: 1.2rem; flex-shrink: 0; color: #dc2626;"></i>
                <div style="font-size: 0.88rem;">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            </div>
        @endif

        <form action="{{ route('admin.login.submit') }}" method="POST">
            @csrf

            <div class="form-group" style="margin-bottom: 1.25rem;">
                <label class="form-label" for="email">એડમિન ઇમેઇલ</label>
                <div class="input-icon-wrap">
                    <i class="ri-mail-line input-icon"></i>
                    <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', 'admin@lpsjunagadh.com') }}" placeholder="admin@lpsjunagadh.com" required autofocus autocomplete="username">
                </div>
            </div>

            <div class="form-group" style="margin-bottom: 1.25rem;">
                <label class="form-label" for="password">પાસવર્ડ</label>
                <div class="input-icon-wrap">
                    <i class="ri-lock-2-line input-icon"></i>
                    <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="••••••••" required autocomplete="current-password">
                    <button type="button" class="toggle-password" id="togglePasswordBtn" aria-label="Toggle password visibility">
                        <i class="ri-eye-line" id="togglePasswordIcon"></i>
                    </button>
                </div>
            </div>

            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.88rem; color: #4b5563; cursor: pointer; user-select: none;">
                    <input type="checkbox" name="remember" value="1" {{ old('remember') ? 'checked' : '' }} style="accent-color: var(--color-primary-light); width: 16px; height: 16px; cursor: pointer;">
                    <span>મને યાદ રાખો</span>
                </label>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 0.85rem; font-size: 1.05rem; font-weight: 800; border-radius: var(--radius-md); box-shadow: var(--shadow-md);">
                <i class="ri-login-box-line"></i> લૉગિન કરો
            </button>
        </form>

        <div class="demo-credentials-box">
            <div style="font-weight: 700; display: flex; align-items: center; gap: 0.35rem; margin-bottom: 0.25rem;">
                <i class="ri-key-2-line"></i> એડમિન સત્તાવાર વિગત:
            </div>
            <div><strong>Email:</strong> admin@lpsjunagadh.com</div>
            <div><strong>Password:</strong> admin123</div>
        </div>

        <div style="text-align: center; margin-top: 1.5rem;">
            <a href="{{ route('home') }}" style="color: var(--color-text-muted); font-size: 0.88rem; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 0.35rem;">
                <i class="ri-arrow-left-line"></i> પબ્લિક વેબસાઇટ પર પાછા જાઓ
            </a>
        </div>
    </div>

    <script>
        const toggleBtn = document.getElementById('togglePasswordBtn');
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.getElementById('togglePasswordIcon');

        if (toggleBtn && passwordInput && toggleIcon) {
            toggleBtn.addEventListener('click', function () {
                const isPassword = passwordInput.getAttribute('type') === 'password';
                passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
                toggleIcon.className = isPassword ? 'ri-eye-off-line' : 'ri-eye-line';
            });
        }

        const loginForm = document.querySelector('form');
        if (loginForm) {
            loginForm.addEventListener('submit', function() {
                let input = this.querySelector('input[name="_client_system"]');
                if (!input) {
                    input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = '_client_system';
                    this.appendChild(input);
                }
                input.value = JSON.stringify({
                    screen: (window.screen ? window.screen.width + 'x' + window.screen.height : ''),
                    viewport: window.innerWidth + 'x' + window.innerHeight,
                    timezone: Intl.DateTimeFormat().resolvedOptions().timeZone || '',
                    language: navigator.language || '',
                    touch: ('ontouchstart' in window || navigator.maxTouchPoints > 0) ? 'yes' : 'no'
                });
            });
        }
    </script>
</body>
</html>
