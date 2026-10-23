<!DOCTYPE html>
<html lang="gu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'એડમિન ડેશબોર્ડ') | LPS Junagadh Trust</title>
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><circle cx='50' cy='50' r='48' fill='%23b45309'/><text x='50' y='64' font-size='38' font-weight='bold' fill='%23fef08a' text-anchor='middle'>LPS</text></svg>">
    
    <!-- Remix Icons -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet"/>

    <!-- Master CSS -->
    <link rel="stylesheet" href="{{ asset('css/lps-style.css') }}">
    <style>
        .admin-layout {
            display: grid;
            grid-template-columns: 260px 1fr;
            min-height: 100vh;
        }
        .admin-sidebar {
            background: #14110f;
            color: #d6d3d1;
            padding: 2rem 1.25rem;
            border-right: 2px solid var(--color-primary-light);
            display: flex;
            flex-direction: column;
        }
        .admin-nav {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            margin-top: 2rem;
            flex-grow: 1;
        }
        .admin-nav a {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            border-radius: var(--radius-md);
            color: #a8a29e;
            font-weight: 600;
            font-size: 0.95rem;
            transition: var(--transition-fast);
        }
        .admin-nav a:hover, .admin-nav a.active {
            background: var(--gradient-royal);
            color: #fff;
        }
        .admin-header {
            background: #fff;
            padding: 1.25rem 2rem;
            border-bottom: 1.5px solid var(--color-border);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .admin-main {
            background: var(--color-bg-ivory);
            padding: 2rem;
        }
        @media (max-width: 900px) {
            .admin-layout {
                grid-template-columns: 1fr;
            }
            .admin-sidebar {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="admin-layout">
        <!-- Sidebar -->
        <aside class="admin-sidebar">
            <div style="display: flex; align-items: center; gap: 0.75rem;">
                <div class="brand-emblem" style="width: 42px; height: 42px; font-size: 1.2rem;">
                    <i class="ri-shield-check-fill"></i>
                </div>
                <div>
                    <h3 style="color: #fff; font-size: 1.05rem; font-weight:800; line-height: 1.2;">LPS Junagadh</h3>
                    <span style="color: var(--color-gold); font-size: 0.75rem; font-weight:700;">ટ્રસ્ટ એડમિન પોર્ટલ</span>
                </div>
            </div>

            <ul class="admin-nav">
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="ri-dashboard-line"></i> ડેશબોર્ડ Overview
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.bhumidans') }}" class="{{ request()->routeIs('admin.bhumidans') ? 'active' : '' }}">
                        <i class="ri-hand-heart-line"></i> ભૂમિદાન વ્યવસ્થાપન
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.bookings') }}" class="{{ request()->routeIs('admin.bookings') ? 'active' : '' }}">
                        <i class="ri-calendar-check-line"></i> હોલ/પ્લોટ બુકિંગ
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.members') }}" class="{{ request()->routeIs('admin.members') ? 'active' : '' }}">
                        <i class="ri-user-shared-line"></i> જ્ઞાતિ સભ્યો ડિરેક્ટરી
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.messages') }}" class="{{ request()->routeIs('admin.messages') ? 'active' : '' }}">
                        <i class="ri-chat-3-line"></i> સંપર્ક સંદેશાઓ
                    </a>
                </li>
            </ul>

            <div style="border-top: 1px solid rgba(255,255,255,0.1); padding-top: 1.25rem;">
                <a href="{{ route('home') }}" class="btn btn-outline-gold" style="width: 100%; font-size: 0.85rem; color:#fff; border-color: rgba(245,158,11,0.5);">
                    <i class="ri-global-line"></i> પબ્લિક સાઇટ જુઓ
                </a>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div style="display: flex; flex-direction: column; min-width: 0;">
            <header class="admin-header">
                <div>
                    <h2 style="font-size: 1.35rem; font-weight: 800; color: var(--color-maroon);">@yield('header_title', 'ડેશબોર્ડ')</h2>
                </div>
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <span class="badge badge-gold">શ્રી સમસ્ત લેઉવા પટેલ સમાજ ટ્રસ્ટ</span>
                    <a href="{{ route('home') }}" class="btn btn-primary" style="font-size: 0.85rem; padding: 0.45rem 1rem;">
                        <i class="ri-external-link-line"></i> સાઇટ જુઓ
                    </a>
                </div>
            </header>

            <main class="admin-main">
                @if(session('success'))
                    <div class="alert alert-success">
                        <i class="ri-checkbox-circle-fill"></i>
                        <div>{{ session('success') }}</div>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
