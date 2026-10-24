<!DOCTYPE html>
<html lang="gu">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>@yield('title', 'એડમિન ડેશબોર્ડ') | LPS Junagadh Trust</title>
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><circle cx='50' cy='50' r='48' fill='%23b45309'/><text x='50' y='64' font-size='38' font-weight='bold' fill='%23fef08a' text-anchor='middle'>LPS</text></svg>">
    
    <!-- Remix Icons -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet"/>

    <!-- Master Design System & Admin Stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/lps-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/lps-admin.css') }}">
    @stack('styles')
</head>
<body>

    <!-- Mobile Drawer Backdrop Overlay -->
    <div id="adminBackdrop" class="admin-backdrop" onclick="toggleAdminDrawer(false)"></div>

    <div class="admin-layout">
        <!-- Sidebar Navigation (Desktop Fixed / Mobile Off-Canvas Drawer) -->
        <aside id="adminSidebar" class="admin-sidebar" aria-label="Admin Navigation">
            <!-- Brand Header -->
            <div class="admin-brand-header">
                <a href="{{ route('admin.dashboard') }}" class="admin-brand-link">
                    <div class="admin-brand-emblem">
                        <i class="ri-shield-check-fill"></i>
                    </div>
                    <div class="admin-brand-info">
                        <h3>LPS Junagadh</h3>
                        <span>ટ્રસ્ટ એડમિન પોર્ટલ</span>
                    </div>
                </a>
                <button type="button" class="admin-close-drawer-btn" onclick="toggleAdminDrawer(false)" aria-label="Close Menu">
                    <i class="ri-close-line"></i>
                </button>
            </div>

            <!-- Navigation Sections -->
            <div class="admin-nav-group">
                <div class="admin-nav-label">મુખ્ય સંચાલન (Core Operations)</div>
                <ul class="admin-nav">
                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="ri-dashboard-3-line"></i>
                            <span>ડેશબોર્ડ Overview</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.bhumidans') }}" class="{{ request()->routeIs('admin.bhumidans*') ? 'active' : '' }}">
                            <i class="ri-hand-heart-line"></i>
                            <span>ભૂમિદાન વ્યવસ્થાપન</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.bookings') }}" class="{{ request()->routeIs('admin.bookings*') ? 'active' : '' }}">
                            <i class="ri-calendar-check-line"></i>
                            <span>હોલ / પ્લોટ બુકિંગ</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.members') }}" class="{{ request()->routeIs('admin.members*') ? 'active' : '' }}">
                            <i class="ri-user-shared-line"></i>
                            <span>જ્ઞાતિ સભ્યો ડિરેક્ટરી</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="admin-nav-group">
                <div class="admin-nav-label">પ્રવૃત્તિઓ & મીડિયા (Media & Events)</div>
                <ul class="admin-nav">
                    <li>
                        <a href="{{ route('admin.events') }}" class="{{ request()->routeIs('admin.events*') ? 'active' : '' }}">
                            <i class="ri-calendar-event-line"></i>
                            <span>કાર્યક્રમો (ઇવેન્ટ્સ)</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.gallery') }}" class="{{ request()->routeIs('admin.gallery*') ? 'active' : '' }}">
                            <i class="ri-gallery-line"></i>
                            <span>ગેલેરી વ્યવસ્થાપન</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.messages') }}" class="{{ request()->routeIs('admin.messages*') ? 'active' : '' }}">
                            <i class="ri-chat-3-line"></i>
                            <span>સંપર્ક સંદેશાઓ</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="admin-nav-group">
                <div class="admin-nav-label">પ્રશાસન & સુરક્ષા (Administration)</div>
                <ul class="admin-nav">
                    <li>
                        <a href="{{ route('admin.logs') }}" class="{{ request()->routeIs('admin.logs*') ? 'active' : '' }}">
                            <i class="ri-history-line"></i>
                            <span>એક્ટિવિટી & સબમિશન લૉગ્સ</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.security') }}" class="{{ request()->routeIs('admin.security*') ? 'active' : '' }}">
                            <i class="ri-shield-keyhole-line"></i>
                            <span>સુરક્ષા & પાસવર્ડ</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Sidebar User Profile Footer -->
            <div class="admin-sidebar-footer">
                <div class="admin-user-card">
                    <div class="admin-user-avatar">
                        {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                    </div>
                    <div class="admin-user-details">
                        <div class="admin-user-name">{{ Auth::user()->name ?? 'Admin' }}</div>
                        <div class="admin-user-role">{{ Auth::user()->email ?? 'admin@lpsjunagadh.com' }}</div>
                    </div>
                </div>

                <a href="{{ route('home') }}" target="_blank" class="admin-quick-pill" style="justify-content: center; width: 100%; font-size: 0.8rem; background: rgba(255,255,255,0.06); color: #f1f5f9; border-color: rgba(255,255,255,0.12);">
                    <i class="ri-external-link-line" style="color: #fbbf24;"></i>
                    <span>પબ્લિક વેબસાઇટ જુઓ</span>
                </a>

                <form action="{{ route('admin.logout') }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit" class="admin-logout-btn">
                        <i class="ri-logout-box-r-line"></i>
                        <span>લૉગ આઉટ (Sign Out)</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content Wrapper -->
        <div class="admin-main-wrap">
            <!-- Top Sticky Header -->
            <header class="admin-header">
                <div class="admin-header-left">
                    <button type="button" class="admin-menu-toggle" onclick="toggleAdminDrawer(true)" aria-label="Open Navigation">
                        <i class="ri-menu-2-line"></i>
                    </button>
                    <div>
                        <h1 class="admin-header-title">@yield('header_title', 'ડેશબોર્ડ')</h1>
                    </div>
                    <span class="admin-header-badge">
                        <i class="ri-shield-check-fill"></i> ટ્રસ્ટ પોર્ટલ
                    </span>
                </div>

                <div class="admin-header-right">
                    <a href="{{ route('home') }}" target="_blank" class="admin-header-btn admin-header-btn-site" title="વેબસાઇટ જુઓ">
                        <i class="ri-external-link-line"></i>
                        <span>સાઇટ જુઓ</span>
                    </a>

                    <form action="{{ route('admin.logout') }}" method="POST" style="margin: 0;">
                        @csrf
                        <button type="submit" class="admin-header-btn admin-header-btn-logout" title="લૉગ આઉટ">
                            <i class="ri-logout-box-r-line"></i>
                            <span>લૉગ આઉટ</span>
                        </button>
                    </form>
                </div>
            </header>

            <!-- Main Body -->
            <main class="admin-main">
                @if(session('success'))
                    <div class="alert alert-success" style="margin-bottom: 1.25rem;">
                        <i class="ri-checkbox-circle-fill"></i>
                        <div>{{ session('success') }}</div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger" style="margin-bottom: 1.25rem; background: #fef2f2; border-left: 4px solid #ef4444; color: #991b1b; padding: 0.75rem 1rem; border-radius: var(--radius-md);">
                        <i class="ri-error-warning-fill"></i>
                        <div>{{ session('error') }}</div>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <!-- Mobile Native-Style Bottom Navigation Bar (Thumb Friendly) -->
    <nav class="admin-bottom-nav" aria-label="Mobile Navigation">
        <a href="{{ route('admin.dashboard') }}" class="admin-bottom-tab {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="ri-dashboard-3-line"></i>
            <span>ડેશબોર્ડ</span>
        </a>
        <a href="{{ route('admin.bhumidans') }}" class="admin-bottom-tab {{ request()->routeIs('admin.bhumidans*') ? 'active' : '' }}">
            <i class="ri-hand-heart-line"></i>
            <span>ભૂમિદાન</span>
        </a>
        <a href="{{ route('admin.bookings') }}" class="admin-bottom-tab {{ request()->routeIs('admin.bookings*') ? 'active' : '' }}">
            <i class="ri-calendar-check-line"></i>
            <span>બુકિંગ</span>
        </a>
        <a href="{{ route('admin.members') }}" class="admin-bottom-tab {{ request()->routeIs('admin.members*') ? 'active' : '' }}">
            <i class="ri-user-shared-line"></i>
            <span>સભ્યો</span>
        </a>
        <button type="button" class="admin-bottom-tab" onclick="toggleAdminDrawer(true)" aria-label="Open Menu Drawer">
            <i class="ri-menu-line"></i>
            <span>મેનુ</span>
        </button>
    </nav>

    <!-- Global App Scripts -->
    <script src="{{ asset('js/lps-app.js') }}"></script>
    <script src="{{ asset('js/gujarati-transliterate.js') }}"></script>

    <script>
        function toggleAdminDrawer(isOpen) {
            const sidebar = document.getElementById('adminSidebar');
            const backdrop = document.getElementById('adminBackdrop');
            if (!sidebar || !backdrop) return;

            if (isOpen) {
                sidebar.classList.add('open');
                backdrop.classList.add('show');
                document.body.style.overflow = 'hidden';
            } else {
                sidebar.classList.remove('open');
                backdrop.classList.remove('show');
                document.body.style.overflow = '';
            }
        }

        // Close drawer on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                toggleAdminDrawer(false);
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
