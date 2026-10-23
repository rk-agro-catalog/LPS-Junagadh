<!DOCTYPE html>
<html lang="gu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>@yield('title', 'શ્રી સમસ્ત લેઉવા પટેલ સમાજ ટ્રસ્ટ - જૂનાગઢ') | LPS Junagadh</title>
    <meta name="description" content="શ્રી સમસ્ત લેઉવા પટેલ સમાજ ટ્રસ્ટ - જૂનાગઢ (LPS Junagadh) સત્તાવાર પોર્ટલ. પ્રમુખ સેવા સંકલ્પ વિભાગ-૧ & વિભાગ-૨, ભૂમિદાન યોજના (રૂા. ૨૫૦૦/- પ્રતિ ચોરસ વાર), હોલ-પ્લોટ બુકિંગ.">
    <meta name="theme-color" content="#881337">
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><circle cx='50' cy='50' r='48' fill='%23b45309'/><text x='50' y='64' font-size='38' font-weight='bold' fill='%23fef08a' text-anchor='middle'>LPS</text></svg>">
    
    <!-- Remix Icons -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet"/>

    <!-- Custom LPS Style -->
    <link rel="stylesheet" href="{{ asset('css/lps-style.css') }}">
    
    @stack('styles')
</head>
<body>

    <!-- Desktop Topbar (Hidden on mobile for sleek app feel) -->
    <div class="topbar desktop-only">
        <div class="container topbar-content">
            <div class="topbar-left">
                <div class="topbar-item">
                    <i class="ri-map-pin-2-fill"></i>
                    <span>જૂનાગઢ બાયપાસ, ખલીલપુર ચોકડી પાસે, સોનરખ નદીના કાંઠે, જૂનાગઢ</span>
                </div>
                <div class="topbar-item">
                    <i class="ri-phone-fill"></i>
                    <a href="tel:9093390934" style="color: #fef08a; font-weight:700;">909 33 909 34</a>
                </div>
            </div>
            <div class="topbar-right">
                <div class="topbar-item">
                    <span style="color:#fef08a; font-weight:700;">॥ સંગઠન એ જ શક્તિ ॥</span>
                </div>
                <div class="topbar-social">
                    <a href="https://www.instagram.com/explore/locations/265511100633813/khodaldham-yuva-samiti-junagadh/" target="_blank" title="Instagram"><i class="ri-instagram-line"></i></a>
                    <a href="https://www.youtube.com/@ShreeLeuvaPatelTrustJunagadh" target="_blank" title="YouTube"><i class="ri-youtube-line"></i></a>
                    <a href="https://wa.me/919093390934" target="_blank" title="WhatsApp"><i class="ri-whatsapp-line"></i></a>
                    <a href="{{ route('admin.dashboard') }}" style="background: rgba(245,158,11,0.25);" title="Admin"><i class="ri-lock-line"></i></a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Navigation Header -->
    <header class="main-header">
        <div class="container navbar">
            <a href="{{ route('home') }}" class="brand-logo">
                <div class="brand-emblem">
                    <i class="ri-shield-star-fill"></i>
                </div>
                <div class="brand-text">
                    <h1>શ્રી સમસ્ત લેઉવા પટેલ સમાજ ટ્રસ્ટ</h1>
                    <span>LPS JUNAGADH • જૂનાગઢ</span>
                </div>
            </a>

            <!-- Desktop Menu -->
            <ul class="nav-menu desktop-menu desktop-only" id="navMenu">
                <li><a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">મુખ્ય પૃષ્ઠ</a></li>
                <li><a href="{{ route('sankalp') }}" class="nav-link {{ request()->routeIs('sankalp') ? 'active' : '' }}">સેવા સંકલ્પ</a></li>
                <li><a href="{{ route('bhumidan') }}" class="nav-link {{ request()->routeIs('bhumidan') ? 'active' : '' }}">ભૂમિદાન યોજના</a></li>
                <li><a href="{{ route('booking') }}" class="nav-link {{ request()->routeIs('booking') ? 'active' : '' }}">હોલ / પ્લોટ બુકિંગ</a></li>
                <li><a href="{{ route('trustees') }}" class="nav-link {{ request()->routeIs('trustees') ? 'active' : '' }}">ટ્રસ્ટી મંડળ</a></li>
                <li><a href="{{ route('gallery') }}" class="nav-link {{ request()->routeIs('gallery') ? 'active' : '' }}">ગેલેરી</a></li>
                <li><a href="{{ route('membership') }}" class="nav-link {{ request()->routeIs('membership') ? 'active' : '' }}">સમાજ ડિરેક્ટરી</a></li>
                <li><a href="{{ route('contact') }}" class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}">સંપર્ક</a></li>
            </ul>

            <!-- Header Right Actions -->
            <div class="nav-actions">
                <a href="{{ route('bhumidan') }}" class="btn btn-primary desktop-only">
                    <i class="ri-heart-fill"></i> ભૂમિદાન આપો
                </a>

                <!-- Mobile Quick Action Buttons in Header -->
                <div class="mobile-header-actions mobile-only">
                    <a href="tel:9093390934" class="mobile-icon-btn call" title="Call">
                        <i class="ri-phone-fill"></i>
                    </a>
                    <button class="mobile-toggle" id="mobileToggle" aria-label="Toggle Menu">
                        <i class="ri-menu-line"></i>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Slide-over Mobile Navigation Drawer -->
    <div class="mobile-drawer-overlay" id="drawerOverlay"></div>
    <div class="mobile-drawer" id="mobileDrawer">
        <div class="drawer-header">
            <div class="brand-logo" style="gap: 0.6rem;">
                <div class="brand-emblem" style="width: 38px; height: 38px; font-size: 1.1rem;">
                    <i class="ri-shield-star-fill"></i>
                </div>
                <div class="brand-text">
                    <h2 style="font-size: 0.95rem; font-weight: 800; color: var(--color-maroon);">LPS Junagadh</h2>
                    <span style="font-size: 0.72rem;">શ્રી સમસ્ત લેઉવા પટેલ સમાજ</span>
                </div>
            </div>
            <button class="drawer-close-btn" id="drawerCloseBtn" aria-label="Close Menu">
                <i class="ri-close-line"></i>
            </button>
        </div>

        <div class="drawer-body">
            <ul class="drawer-menu">
                <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}"><i class="ri-home-4-line"></i> મુખ્ય પૃષ્ઠ</a></li>
                <li><a href="{{ route('sankalp') }}" class="{{ request()->routeIs('sankalp') ? 'active' : '' }}"><i class="ri-building-line"></i> સેવા સંકલ્પ (વિભાગ ૧ & ૨)</a></li>
                <li><a href="{{ route('bhumidan') }}" class="{{ request()->routeIs('bhumidan') ? 'active' : '' }}"><i class="ri-hand-heart-line"></i> એક ચોરસ વાર ભૂમિદાન (રૂા. ૨૫૦૦/-)</a></li>
                <li><a href="{{ route('booking') }}" class="{{ request()->routeIs('booking') ? 'active' : '' }}"><i class="ri-calendar-check-line"></i> પાર્ટી પ્લોટ & હોલ બુકિંગ</a></li>
                <li><a href="{{ route('trustees') }}" class="{{ request()->routeIs('trustees') ? 'active' : '' }}"><i class="ri-team-line"></i> ટ્રસ્ટી મંડળ & આગેવાનો</a></li>
                <li><a href="{{ route('gallery') }}" class="{{ request()->routeIs('gallery') ? 'active' : '' }}"><i class="ri-gallery-line"></i> ફોટો, વિડીયો & રીલ્સ</a></li>
                <li><a href="{{ route('membership') }}" class="{{ request()->routeIs('membership') ? 'active' : '' }}"><i class="ri-user-add-line"></i> જ્ઞાતિ સભ્ય નોંધણી</a></li>
                <li><a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}"><i class="ri-map-pin-line"></i> સંપર્ક & લોકેશન નકશો</a></li>
                <li><a href="{{ route('admin.dashboard') }}"><i class="ri-lock-line"></i> એડમિન પોર્ટલ</a></li>
            </ul>

            <div class="drawer-cta-box">
                <a href="{{ route('bhumidan') }}" class="btn btn-primary" style="width: 100%; font-size: 0.95rem;">
                    <i class="ri-heart-fill"></i> ઓનલાઇન ભૂમિદાન આપો
                </a>
                <div style="margin-top: 1rem; text-align: center;">
                    <a href="tel:9093390934" style="font-weight: 700; color: var(--color-maroon); font-size: 0.9rem; display: inline-flex; align-items: center; gap: 0.4rem;">
                        <i class="ri-phone-fill" style="color: var(--color-primary-light);"></i> 909 33 909 34
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Global Alert Notifications -->
    <div class="container alert-container">
        @if(session('success'))
            <div class="alert alert-success">
                <i class="ri-checkbox-circle-fill" style="font-size: 1.3rem;"></i>
                <div>{{ session('success') }}</div>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                <i class="ri-error-warning-fill" style="font-size: 1.3rem;"></i>
                <div>{{ session('error') }}</div>
            </div>
        @endif
    </div>

    <!-- Main Content -->
    <main class="page-content">
        @yield('content')
    </main>

    <!-- Master Footer -->
    <footer class="main-footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-brand">
                    <h4>શ્રી સમસ્ત લેઉવા પટેલ સમાજ ટ્રસ્ટ</h4>
                    <p style="color: var(--color-gold); font-weight:700; font-size: 0.9rem; margin-bottom: 0.5rem;">LPS Junagadh • જૂનાગઢ</p>
                    <p style="font-size: 0.88rem; line-height: 1.6; color: #a8a29e;">
                        લેઉવા પટેલ સમાજના ઉત્કર્ષ અને સુખાકારી માટે સમર્પિત ગૌરવવંતું સંકુલ નિર્માણ.
                    </p>
                    <div style="margin-top: 1rem; display: flex; gap: 0.5rem; flex-wrap: wrap;">
                        <span class="badge badge-gold" style="font-size: 0.75rem;">જય સરદાર</span>
                        <span class="badge badge-maroon" style="font-size: 0.75rem;">જય માઁ ખોડલ</span>
                    </div>
                </div>

                <div class="footer-col">
                    <h5>મુખ્ય વિભાગો</h5>
                    <ul class="footer-links">
                        <li><a href="{{ route('home') }}"><i class="ri-arrow-right-s-line"></i> મુખ્ય પૃષ્ઠ</a></li>
                        <li><a href="{{ route('sankalp') }}"><i class="ri-arrow-right-s-line"></i> સેવા સંકલ્પ (વિભાગ ૧ & ૨)</a></li>
                        <li><a href="{{ route('bhumidan') }}"><i class="ri-arrow-right-s-line"></i> ૧ ચોરસ વાર ભૂમિદાન</a></li>
                        <li><a href="{{ route('booking') }}"><i class="ri-arrow-right-s-line"></i> પાર્ટી પ્લોટ & હોલ બુકિંગ</a></li>
                        <li><a href="{{ route('trustees') }}"><i class="ri-arrow-right-s-line"></i> ટ્રસ્ટી મંડળ</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h5>સમાજ સેવાઓ</h5>
                    <ul class="footer-links">
                        <li><a href="{{ route('membership') }}"><i class="ri-arrow-right-s-line"></i> સભ્ય નોંધણી</a></li>
                        <li><a href="{{ route('gallery') }}"><i class="ri-arrow-right-s-line"></i> ગેલેરી & રીલ્સ</a></li>
                        <li><a href="{{ route('bhumidan') }}"><i class="ri-arrow-right-s-line"></i> દાતાશ્રીઓની યાદી</a></li>
                        <li><a href="{{ route('contact') }}"><i class="ri-arrow-right-s-line"></i> સંકુલ સંપર્ક</a></li>
                        <li><a href="{{ route('admin.dashboard') }}"><i class="ri-arrow-right-s-line"></i> એડમિન પોર્ટલ</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h5>સરનામું & સંપર્ક</h5>
                    <p style="font-size: 0.88rem; line-height: 1.5; margin-bottom: 0.75rem;">
                        <i class="ri-map-pin-fill" style="color: var(--color-gold);"></i> 
                        જૂનાગઢ બાયપાસ, ખલીલપુર ચોકડી પાસે, સોનરખ નદીના કાંઠે, જૂનાગઢ.
                    </p>
                    <p style="font-size: 0.88rem; margin-bottom: 0.75rem;">
                        <i class="ri-phone-fill" style="color: var(--color-gold);"></i> 
                        <a href="tel:9093390934" style="color: #fff; font-weight:700;">909 33 909 34</a>
                    </p>
                    <a href="https://wa.me/919093390934" target="_blank" class="btn btn-outline-gold" style="font-size: 0.82rem; padding: 0.4rem 0.8rem; width: 100%; border-color: #fef08a; color: #fff;">
                        <i class="ri-whatsapp-line"></i> વોટ્સએપ સંપર્ક
                    </a>
                </div>
            </div>

            <div class="footer-bottom">
                <div>
                    © {{ date('Y') }} શ્રી સમસ્ત લેઉવા પટેલ સમાજ ટ્રસ્ટ - જૂનાગઢ (LPS).
                </div>
                <div class="desktop-only">
                    સંકલ્પ: <span style="color: var(--color-gold);">૧ ચોરસ વાર ભૂમિદાન રૂા. ૨૫૦૦/-</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Native-style Mobile Bottom Navigation Bar (For Mobile App Feel) -->
    <nav class="mobile-bottom-nav mobile-only" aria-label="Mobile Navigation">
        <a href="{{ route('home') }}" class="bottom-nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
            <i class="ri-home-4-fill"></i>
            <span>હોમ</span>
        </a>

        <a href="{{ route('sankalp') }}" class="bottom-nav-item {{ request()->routeIs('sankalp') ? 'active' : '' }}">
            <i class="ri-building-line"></i>
            <span>સંકલ્પ</span>
        </a>

        <!-- Center Highlighted Bhumidan Action -->
        <a href="{{ route('bhumidan') }}" class="bottom-nav-item center-highlight {{ request()->routeIs('bhumidan') ? 'active' : '' }}">
            <div class="center-fab">
                <i class="ri-heart-3-fill"></i>
            </div>
            <span>ભૂમિદાન</span>
        </a>

        <a href="{{ route('booking') }}" class="bottom-nav-item {{ request()->routeIs('booking') ? 'active' : '' }}">
            <i class="ri-calendar-check-line"></i>
            <span>બુકિંગ</span>
        </a>

        <button type="button" class="bottom-nav-item" id="bottomNavMenuBtn">
            <i class="ri-menu-4-line"></i>
            <span>મેનુ</span>
        </button>
    </nav>

    <!-- Custom Scripts -->
    <script src="{{ asset('js/lps-app.js') }}"></script>
    @stack('scripts')
</body>
</html>
