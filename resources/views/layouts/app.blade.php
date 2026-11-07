
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Dashboard') - RAPI-Sekolah</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        :root {
            --navy: #17365d;
            --navy-dark: #102744;
            --white: #ffffff;
            --background: #f5f6f8;
            --border: #e1e5ea;
            --text: #252b33;
            --muted: #707985;
            --red: #c0392b;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            background: var(--background);
            color: var(--text);
            font-family: Arial, Helvetica, sans-serif;
            font-size: 14px;
            line-height: 1.6;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        button, input, select, textarea {
            font: inherit;
        }

        .app { min-height: 100vh; }

        .sidebar {
            position: fixed;
            inset: 0 auto 0 0;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            width: 240px;
            height: 100vh;
            padding: 24px 16px;
            background: var(--navy-dark);
            color: white;
            overflow-y: auto;
            transition: transform .2s ease;
        }

        .main {
            min-width: 0;
            margin-left: 240px;
            padding: 0 30px 25px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 0 8px;
            margin-bottom: 35px;
        }

        .brand-symbol {
            display: grid;
            place-items: center;
            width: 40px;
            height: 40px;
            flex-shrink: 0;
            border-radius: 6px;
            background: white;
            color: var(--navy);
            font-size: 22px;
            font-weight: bold;
        }

        .brand-title {
            margin: 0;
            font-size: 16px;
            font-weight: 700;
        }

        .brand-subtitle {
            display: block;
            color: #c0ccda;
            font-size: 9px;
            letter-spacing: 1px;
        }

        .nav-caption {
            margin: 0 10px 10px;
            color: #b8c5d5;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .nav-group {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 11px;
            min-height: 42px;
            padding: 10px 12px;
            border-radius: 5px;
            color: #e0e6ee;
            font-size: 12px;
        }

        .nav-item:hover,
        .nav-item.active {
            background: #29496f;
            color: white;
        }

        .nav-symbol {
            width: 20px;
            text-align: center;
            font-size: 16px;
        }

        .nav-separator {
            height: 1px;
            margin: 20px 8px;
            background: rgb(255 255 255 / 15%);
        }

        .sidebar-info {
            padding: 13px;
            border: 1px solid rgb(255 255 255 / 15%);
            border-radius: 6px;
        }

        .sidebar-info-title {
            margin: 0 0 5px;
            font-size: 12px;
        }

        .sidebar-info p {
            margin: 0;
            color: #c0ccda;
            font-size: 11px;
        }

        .sidebar-bottom {
            margin-top: auto;
            padding-top: 25px;
            color: #b8c5d5;
            font-size: 10px;
        }

        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            min-height: 80px;
            margin-bottom: 25px;
            border-bottom: 1px solid var(--border);
        }

        .topbar-left,
        .topbar-right {
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 0;
        }

        .breadcrumb {
            margin: 0 0 3px;
            color: var(--muted);
            font-size: 11px;
        }

        .breadcrumb span {
            color: var(--navy);
            font-weight: bold;
        }

        .topbar-title {
            margin: 0;
            font-size: 18px;
            font-weight: 700;
        }

        .date-display {
            color: var(--muted);
            font-size: 11px;
            white-space: nowrap;
        }

        .profile {
            display: flex;
            align-items: center;
            gap: 9px;
            padding-left: 13px;
            border-left: 1px solid var(--border);
        }

        .profile-avatar {
            display: grid;
            place-items: center;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: #e8edf3;
            color: var(--navy);
            font-weight: bold;
        }

        .profile-name {
            margin: 0;
            font-size: 11px;
            font-weight: bold;
        }

        .profile-role {
            display: block;
            color: var(--muted);
            font-size: 10px;
        }

        .logout-form { margin-left: 5px; }

        .logout-button {
            padding: 8px 11px;
            border: 1px solid #e5c7c3;
            border-radius: 5px;
            background: white;
            color: var(--red);
            font-size: 11px;
            font-weight: bold;
        }

        .logout-button:hover { background: #fbefed; }

        .menu-toggle {
            display: none;
            width: 36px;
            height: 36px;
            border: 1px solid var(--border);
            border-radius: 5px;
            background: white;
            color: var(--navy);
        }

        .page-intro {
            margin-bottom: 28px;
            padding: 23px 25px;
            border: 1px solid var(--border);
            border-left: 4px solid var(--navy);
            border-radius: 5px;
            background: white;
        }

        .page-intro h2 {
            margin: 0 0 6px;
            color: var(--navy);
            font-size: 22px;
        }

        .page-intro p {
            max-width: 650px;
            margin: 0;
            color: var(--muted);
            font-size: 12px;
        }

        .section {
            min-width: 0;
            margin-bottom: 30px;
        }

        .section-heading {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 15px;
        }

        .section-heading h2 {
            margin: 0;
            font-size: 18px;
            font-weight: 700;
        }

        .section-description {
            margin: 4px 0 0;
            color: var(--muted);
            font-size: 11px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 14px;
        }

        .stat-card {
            min-width: 0;
            padding: 18px;
            border: 1px solid var(--border);
            border-radius: 5px;
            background: white;
        }

        .stat-label {
            display: block;
            margin-bottom: 12px;
            color: var(--muted);
            font-size: 11px;
        }

        .stat-number {
            display: block;
            color: var(--navy);
            font-size: 30px;
            font-weight: 700;
        }

        .stat-note {
            margin: 8px 0 0;
            color: var(--muted);
            font-size: 10px;
        }

        .main .card {
            width: 100%;
            min-width: 0;
            margin: 0;
            overflow: hidden;
            border: 1px solid var(--border);
            border-radius: 5px;
            background: white;
            box-shadow: none;
        }

        .main .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
            padding: 16px 18px;
            border-bottom: 1px solid var(--border);
            background: white;
        }

        .main .card-header h1,
        .main .card-header h2,
        .main .card-header h3,
        .main .card-header h4,
        .main .card-header h5 {
            margin: 0;
            color: var(--navy);
            font-size: 15px;
            font-weight: 700;
        }

        .main .card-body { padding: 18px; }

        .main .table-responsive {
            width: 100%;
            overflow-x: auto;
        }

        .main table {
            width: 100%;
            border-collapse: collapse;
        }

        .main .table-responsive table { min-width: 760px; }

        .main table th,
        .main table td {
            padding: 12px;
            border-bottom: 1px solid #edf0f3;
            text-align: left;
            vertical-align: middle;
            font-size: 11px;
        }

        .main table th {
            background: #f5f6f8;
            color: #596474;
            font-size: 10px;
        }

        .main table tbody tr:hover { background: #f9fafb; }

        .main .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            min-height: 32px;
            padding: 7px 11px;
            border-radius: 5px;
            font-size: 10px;
            font-weight: 700;
        }

        .main .btn-primary,
        .main .btn-success {
            background: var(--navy);
            color: white;
        }

        .main .btn-danger {
            background: var(--red);
            color: white;
        }

        .main .alert {
            width: 100%;
            margin-bottom: 14px;
            padding: 12px 14px;
            border: 1px solid var(--border);
            border-radius: 5px;
            font-size: 11px;
        }

        .main input:not([type="checkbox"]):not([type="radio"]):not([type="hidden"]),
        .main select,
        .main textarea {
            display: block;
            width: 100%;
            max-width: 100%;
            min-width: 0;
            padding: 9px 11px;
            border: 1px solid #d5dbe2;
            border-radius: 5px;
            background: white;
        }

        .footer {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
            padding-top: 18px;
            margin-top: 35px;
            border-top: 1px solid var(--border);
            color: var(--muted);
            font-size: 10px;
        }

        .footer strong { color: var(--navy); }

        .sidebar-overlay { display: none; }

        @media (max-width: 1100px) {
            .main { padding-right: 22px; padding-left: 22px; }
        }

        @media (max-width: 760px) {
            .sidebar {
                width: 250px;
                max-width: 85vw;
                transform: translateX(-100%);
            }

            .sidebar.open { transform: translateX(0); }

            .sidebar-overlay.show {
                display: block;
                position: fixed;
                inset: 0;
                z-index: 999;
                background: rgb(0 0 0 / 40%);
            }

            .main {
                margin-left: 0;
                padding: 0 16px 22px;
            }

            .menu-toggle {
                display: block;
                flex-shrink: 0;
            }

            .topbar { min-height: 72px; margin-bottom: 20px; }
            .topbar-title { font-size: 15px; }
            .date-display, .profile-text { display: none; }
            .profile { padding-left: 0; border-left: 0; }
            .page-intro { padding: 18px; }
            .main .card-header, .main .card-body { padding: 15px; }
        }

        @media (max-width: 450px) {
            .main { padding-right: 12px; padding-left: 12px; }
            .topbar-left { gap: 8px; }
            .topbar-title { font-size: 13px; }
            .menu-toggle { width: 32px; height: 32px; }
            .profile-avatar { width: 32px; height: 32px; }
            .logout-button { padding: 7px 8px; font-size: 10px; }
            .stats-grid { grid-template-columns: 1fr; gap: 9px; }
            .stat-card { padding: 13px; }
            .stat-number { font-size: 25px; }
        }
    </style>

    @stack('styles')
</head>

<body>
@php
    $roleId = auth()->user()->role_id ?? null;

    $roleName = match ((int) $roleId) {
        1 => 'Admin',
        2 => 'PIC Ruang',
        3 => 'Guru',
        default => 'Pengguna',
    };

    $dashboardRoute = match ((int) $roleId) {
        1 => 'admin.dashboard',
        2 => 'pic.dashboard',
        3 => 'guru.dashboard',
        default => 'calendar',
    };

    $menus = [
        ['label' => 'Dashboard', 'icon' => '⌂', 'route' => $dashboardRoute],
        ['label' => 'Kalender Agenda', 'icon' => '▦', 'route' => 'calendar'],
    ];

    if ((int) $roleId === 1) {
        $menus = array_merge($menus, [
            ['label' => 'Persetujuan Peminjaman', 'icon' => '✓', 'route' => 'admin.dashboard'],
            ['label' => 'Pemindahan Ruangan', 'icon' => '⇄', 'route' => 'admin.events.manage'],
            ['label' => 'Data Ruangan', 'icon' => '▣', 'route' => 'admin.rooms.index'],
            ['label' => 'Data Pengguna', 'icon' => '♙', 'route' => 'admin.users.index'],
            ['label' => 'Pengaduan Kerusakan', 'icon' => '⚒', 'route' => 'complaints.index'],
        ]);
    } elseif ((int) $roleId === 2) {
        $menus[] = ['label' => 'Pengaduan Kerusakan', 'icon' => '⚒', 'route' => 'pic.dashboard'];
    } elseif ((int) $roleId === 3) {
        $menus = array_merge($menus, [
            ['label' => 'Booking Ruangan', 'icon' => '＋', 'route' => 'booking.index'],
            ['label' => 'Pengaduan Kerusakan', 'icon' => '⚒', 'route' => 'complaints.index'],
        ]);
    }
@endphp

<div class="app">

    <aside class="sidebar" id="sidebar">
        <a href="{{ route($dashboardRoute) }}" class="brand">
            <div class="brand-symbol">R</div>
            <div>
                <h2 class="brand-title">RAPI-Sekolah</h2>
                <span class="brand-subtitle">ROOM MANAGEMENT</span>
            </div>
        </a>

        <p class="nav-caption">Menu Utama</p>

        <nav class="nav-group">
            @foreach ($menus as $menu)
                @php
                    $menuRouteExists = \Illuminate\Support\Facades\Route::has($menu['route']);
                    $menuUrl = $menuRouteExists ? route($menu['route']) : '#';
                    $isActive = request()->routeIs($menu['route']);
                @endphp

                <a href="{{ $menuUrl }}"
                   class="nav-item {{ $isActive ? 'active' : '' }}">
                    <span class="nav-symbol">{{ $menu['icon'] }}</span>
                    <span>{{ $menu['label'] }}</span>
                </a>
            @endforeach
        </nav>

        <div class="nav-separator"></div>

        <p class="nav-caption">Informasi</p>

        <div class="sidebar-info">
            <h3 class="sidebar-info-title">Panel {{ $roleName }}</h3>
            <p>Room and Facility Management System untuk pengelolaan fasilitas sekolah.</p>
        </div>

        <div class="sidebar-bottom">
            RAPI-Sekolah &middot; {{ $roleName }}
        </div>
    </aside>

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <main class="main">

        <header class="topbar">
            <div class="topbar-left">
                <button type="button" class="menu-toggle" id="menuToggle"
                        aria-label="Buka navigasi" aria-expanded="false">
                    ☰
                </button>

                <div>
                    <p class="breadcrumb">
                        RAPI-Sekolah / <span>@yield('page-title', 'Dashboard')</span>
                    </p>
                    <h1 class="topbar-title">@yield('page-title', 'Dashboard')</h1>
                </div>
            </div>

            <div class="topbar-right">
                <div class="date-display" id="todayLabel"></div>

                <div class="profile">
                    <div class="profile-avatar">
                        {{ strtoupper(substr(auth()->user()->fullname ?? 'U', 0, 1)) }}
                    </div>

                    <div class="profile-text">
                        <p class="profile-name">
                            {{ auth()->user()->fullname ?? 'Pengguna' }}
                        </p>
                        <span class="profile-role">{{ $roleName }}</span>
                    </div>

                    <form action="{{ route('logout') }}" method="POST"
                          class="logout-form"
                          onsubmit="return confirm('Yakin ingin logout?')">
                        @csrf
                        <button type="submit" class="logout-button">Logout</button>
                    </form>
                </div>
            </div>
        </header>

        @yield('content')

        <footer class="footer">
            <span>&copy; {{ date('Y') }} <strong>RAPI-Sekolah</strong></span>
            <span>Room and Facility Management System</span>
        </footer>

    </main>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const todayLabel = document.getElementById('todayLabel');

    if (todayLabel) {
        todayLabel.textContent = new Intl.DateTimeFormat('id-ID', {
            weekday: 'long',
            day: 'numeric',
            month: 'long',
            year: 'numeric'
        }).format(new Date());
    }

    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    const menuToggle = document.getElementById('menuToggle');

    function closeSidebar() {
        sidebar.classList.remove('open');
        overlay.classList.remove('show');
        menuToggle.setAttribute('aria-expanded', 'false');
    }

    menuToggle.addEventListener('click', function () {
        const isOpen = sidebar.classList.toggle('open');
        overlay.classList.toggle('show', isOpen);
        menuToggle.setAttribute('aria-expanded', String(isOpen));
    });

    overlay.addEventListener('click', closeSidebar);

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') closeSidebar();
    });

    window.addEventListener('resize', function () {
        if (window.innerWidth > 760) closeSidebar();
    });
});
</script>

@stack('scripts')
</body>
</html>
