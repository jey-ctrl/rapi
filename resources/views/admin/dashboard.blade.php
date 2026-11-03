
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard Admin - RAPI-Sekolah</title>

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

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
            scroll-padding-top: 20px;
        }

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

        button,
        input,
        select,
        textarea {
            font: inherit;
        }

        button {
            cursor: pointer;
        }

        /* LAYOUT */

        .app {
            min-height: 100vh;
        }

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
            color: var(--white);

            overflow-y: auto;
            transition: transform .2s ease;
        }

        .main {
            min-width: 0;
            margin-left: 240px;
            padding: 0 30px 25px;
        }

        /* BRAND */

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
            background: var(--white);
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

        /* SIDEBAR MENU */

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
            color: var(--white);
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

        .sidebar-bottom {
            margin-top: auto;
            padding-top: 25px;
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

        .sidebar-version {
            padding: 12px 3px 0;
            color: #b8c5d5;
            font-size: 10px;
        }

        /* TOPBAR */

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

        .logout-form {
            margin-left: 5px;
        }

        .logout-button {
            padding: 8px 11px;
            border: 1px solid #e5c7c3;
            border-radius: 5px;
            background: var(--white);
            color: var(--red);
            font-size: 11px;
            font-weight: bold;
        }

        .logout-button:hover {
            background: #fbefed;
        }

        .menu-toggle {
            display: none;
            width: 36px;
            height: 36px;
            border: 1px solid var(--border);
            border-radius: 5px;
            background: var(--white);
            color: var(--navy);
        }

        /* PAGE INTRODUCTION */

        .page-intro {
            margin-bottom: 28px;
            padding: 23px 25px;
            border: 1px solid var(--border);
            border-left: 4px solid var(--navy);
            border-radius: 5px;
            background: var(--white);
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

        /* SECTIONS */

        .section {
            min-width: 0;
            margin-bottom: 30px;
            scroll-margin-top: 20px;
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

        .section-index {
            color: #8a929d;
            font-size: 12px;
        }

        /* STATISTICS */

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 14px;
        }

        .stat-card {
            min-width: 0;
            padding: 18px;
            border: 1px solid var(--border);
            border-radius: 5px;
            background: var(--white);
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
            line-height: 1.3;
            overflow-wrap: anywhere;
        }

        .stat-note {
            margin: 8px 0 0;
            color: var(--muted);
            font-size: 10px;
        }

        /* PARTIAL CONTENT */

        .partial-section {
            min-width: 0;
        }

        .main .card {
            width: 100%;
            min-width: 0;
            margin: 0;
            overflow: hidden;
            border: 1px solid var(--border);
            border-radius: 5px;
            background: var(--white);
            box-shadow: none;
        }

        .main .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
            padding: 16px 18px;
            border: 0;
            border-bottom: 1px solid var(--border);
            border-radius: 0;
            background: var(--white);
        }

        .main .card-header h1,
        .main .card-header h2,
        .main .card-header h3,
        .main .card-header h4,
        .main .card-header h5,
        .main .card-header h6 {
            margin: 0;
            color: var(--navy);
            font-size: 15px;
            font-weight: 700;
        }

        .main .card-body {
            width: 100%;
            min-width: 0;
            padding: 18px;
        }

        /* TABLES */

        .main .table-responsive {
            display: block;
            width: 100%;
            max-width: 100%;
            min-width: 0;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .main table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
        }

        .main .table-responsive table {
            min-width: 760px;
        }

        .main table th,
        .main table td {
            padding: 12px;
            border-bottom: 1px solid #edf0f3;
            text-align: left;
            vertical-align: middle;
            font-size: 11px;
            line-height: 1.6;
        }

        .main table th {
            background: #f5f6f8;
            color: #596474;
            font-size: 10px;
            font-weight: 700;
        }

        .main table td {
            color: #3d4652;
        }

        .main table tbody tr:hover {
            background: #f9fafb;
        }

        .main table tbody tr:last-child td {
            border-bottom: 0;
        }

        /* BUTTONS */

        .main .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            min-height: 32px;
            padding: 7px 11px;
            border: 1px solid transparent;
            border-radius: 5px;
            font-size: 10px;
            font-weight: 700;
            line-height: 1.5;
        }

        .main .btn:hover {
            filter: brightness(.95);
        }

        .main .btn-primary,
        .main .btn-success {
            background: var(--navy);
            color: var(--white);
        }

        .main .btn-danger {
            background: var(--red);
            color: var(--white);
        }

        .main .btn-outline-danger {
            border-color: #e5c7c3;
            background: var(--white);
            color: var(--red);
        }

        .main .btn-warning {
            border-color: #e4d7b8;
            background: #f8f4e9;
            color: #80652d;
        }

        .main .btn-secondary {
            background: #eceff2;
            color: #3d4652;
        }

        .main .btn-light {
            border-color: var(--border);
            background: var(--white);
            color: var(--text);
        }

        .main .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: 700;
            line-height: 1.5;
        }

        .main .bg-success {
            background: #e7f3e9;
            color: #28663a;
        }

        .main .bg-warning {
            background: #f8f0dc;
            color: #80652d;
        }

        .main .bg-danger {
            background: #f9e8e6;
            color: #a32f26;
        }

        .main .bg-secondary {
            background: #eceff2;
            color: #56606b;
        }

        .main .text-dark {
            color: var(--text);
        }

        .main .text-muted {
            color: var(--muted);
        }

        .main .d-flex {
            display: flex;
        }

        .main .gap-2 {
            gap: 8px;
        }

        .main .align-middle {
            vertical-align: middle;
        }

        .main .text-center {
            text-align: center;
        }

        .main .text-nowrap {
            white-space: nowrap;
        }

        .main .fw-bold,
        .main .fw-semibold {
            font-weight: 700;
        }

        .main .small {
            font-size: 11px;
        }

        .main .mb-0 {
            margin-bottom: 0;
        }

        .main .mt-2 {
            margin-top: 8px;
        }

        .main .py-5 {
            padding-top: 40px;
            padding-bottom: 40px;
        }

        .main .rounded-3 {
            border-radius: 5px;
        }

        .main .border-0 {
            border: 0;
        }

        .main .bg-white {
            background: var(--white);
        }

        /* ALERTS */

        .main .alert {
            width: 100%;
            margin-bottom: 14px;
            padding: 12px 14px;
            border: 1px solid var(--border);
            border-radius: 5px;
            font-size: 11px;
            overflow-wrap: anywhere;
        }

        .main .alert-success {
            background: #f0f6f1;
            color: #28663a;
        }

        .main .alert-danger {
            background: #fbefed;
            color: #a32f26;
        }

        .main .alert-info {
            background: #eef3f8;
            color: #294f75;
        }

        .main .alert-warning {
            background: #f8f4e9;
            color: #80652d;
        }

        .main .alert ul {
            padding-left: 20px;
        }

        .main .btn-close {
            float: right;
            border: 0;
            background: transparent;
            color: inherit;
            font-size: 16px;
        }

        /* FORMS */

        .main form {
            min-width: 0;
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
            background: var(--white);
            color: var(--text);
            outline: none;
        }

        .main input:focus,
        .main select:focus,
        .main textarea:focus {
            border-color: var(--navy);
        }

        .main label {
            color: #3d4652;
            font-size: 11px;
            font-weight: 700;
        }

        /* MODALS */

        .modal {
            position: fixed;
            inset: 0;
            z-index: 2000;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 20px;
            background: rgb(0 0 0 / 45%);
            overflow-y: auto;
        }

        .modal.show {
            display: flex;
        }

        .modal-dialog {
            width: 100%;
            max-width: 560px;
            margin: auto;
        }

        .modal-content {
            overflow: hidden;
            border: 1px solid var(--border);
            border-radius: 6px;
            background: var(--white);
        }

        .modal-header,
        .modal-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 15px 18px;
        }

        .modal-header {
            border-bottom: 1px solid var(--border);
        }

        .modal-footer {
            justify-content: flex-end;
            border-top: 1px solid var(--border);
        }

        .modal-body {
            padding: 18px;
        }

        .modal-title {
            margin: 0;
            font-size: 16px;
            font-weight: 700;
        }

        /* FOOTER */

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

        .footer strong {
            color: var(--navy);
        }

        .sidebar-overlay {
            display: none;
        }

        /* RESPONSIVE */

        @media (max-width: 1100px) {
            .main {
                padding-right: 22px;
                padding-left: 22px;
            }

            .stats-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 760px) {
            .sidebar {
                width: 250px;
                max-width: 85vw;
                transform: translateX(-100%);
            }

            .sidebar.open {
                transform: translateX(0);
            }

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

            .topbar {
                min-height: 72px;
                margin-bottom: 20px;
            }

            .topbar-title {
                font-size: 15px;
            }

            .date-display,
            .profile-text {
                display: none;
            }

            .profile {
                padding-left: 0;
                border-left: 0;
            }

            .page-intro {
                padding: 18px;
            }

            .page-intro h2 {
                font-size: 20px;
            }

            .main .card-header,
            .main .card-body {
                padding: 15px;
            }

            .footer {
                margin-top: 25px;
            }
        }

        @media (max-width: 450px) {
            .main {
                padding-right: 12px;
                padding-left: 12px;
            }

            .topbar-left {
                gap: 8px;
            }

            .topbar-title {
                font-size: 13px;
            }

            .menu-toggle {
                width: 32px;
                height: 32px;
            }

            .profile-avatar {
                width: 32px;
                height: 32px;
            }

            .logout-button {
                padding: 7px 8px;
                font-size: 10px;
            }

            .stats-grid {
                gap: 9px;
            }

            .stat-card {
                padding: 13px;
            }

            .stat-number {
                font-size: 25px;
            }

            .stat-label {
                font-size: 10px;
            }

            .section-heading h2 {
                font-size: 16px;
            }

            .main .card-header,
            .main .card-body {
                padding: 12px;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            html {
                scroll-behavior: auto;
            }

            *,
            *::before,
            *::after {
                transition: none !important;
            }
        }
    </style>
</head>

<body>
<div class="app">

    {{-- SIDEBAR --}}
    <aside class="sidebar" id="sidebar">

        <a href="#overview" class="brand">
            <div class="brand-symbol">R</div>
            <div>
                <h2 class="brand-title">RAPI-Sekolah</h2>
                <span class="brand-subtitle">ROOM MANAGEMENT</span>
            </div>
        </a>

        <p class="nav-caption">Menu Utama</p>

        <nav class="nav-group">
            <a href="#overview" class="nav-item active">
                <span class="nav-symbol">⌂</span>
                <span>Dashboard</span>
            </a>

            <a href="#persetujuan" class="nav-item">
                <span class="nav-symbol">▤</span>
                <span>Persetujuan Peminjaman</span>
            </a>

            <a href="#pemindahan" class="nav-item">
                <span class="nav-symbol">⇄</span>
                <span>Pemindahan Ruangan</span>
            </a>

            <a href="#pengaduan" class="nav-item">
                <span class="nav-symbol">⚑</span>
                <span>Pengaduan Fasilitas</span>
            </a>
        </nav>

        <div class="nav-separator"></div>

        <p class="nav-caption">Data Master</p>

        <nav class="nav-group">
            <a href="#data-ruangan" class="nav-item">
                <span class="nav-symbol">▦</span>
                <span>Data Ruangan</span>
            </a>

            <a href="#data-pengguna" class="nav-item">
                <span class="nav-symbol">♙</span>
                <span>Data Pengguna</span>
            </a>
        </nav>

        <div class="sidebar-bottom">
            <div class="sidebar-info">
                <h3 class="sidebar-info-title">Panel Administrator</h3>
                <p>
                    Kelola peminjaman, ruangan, pengguna,
                    dan laporan fasilitas sekolah.
                </p>
            </div>

            <div class="sidebar-version">
                RAPI-Sekolah &middot; Admin / Waka
            </div>
        </div>

    </aside>

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    {{-- MAIN CONTENT --}}
    <main class="main" id="overview">

        {{-- TOPBAR --}}
        <header class="topbar">

            <div class="topbar-left">
                <button
                    type="button"
                    class="menu-toggle"
                    id="menuToggle"
                    aria-label="Buka navigasi"
                    aria-expanded="false">
                    ☰
                </button>

                <div>
                    <p class="breadcrumb">
                        RAPI-Sekolah / <span>Dashboard</span>
                    </p>
                    <h1 class="topbar-title">Dashboard Admin / Waka</h1>
                </div>
            </div>

            <div class="topbar-right">

                <div class="date-display" id="todayLabel">
                    Memuat tanggal...
                </div>

                <div class="profile">
                    <div class="profile-avatar">
                        {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                    </div>

                    <div class="profile-text">
                        <p class="profile-name">
                            {{ auth()->user()->name ?? 'Administrator' }}
                        </p>
                        <span class="profile-role">Admin / Waka</span>
                    </div>

                    <form
                        action="{{ route('logout') }}"
                        method="POST"
                        class="logout-form"
                        onsubmit="return confirm('Yakin ingin logout?')">
                        @csrf

                        <button type="submit" class="logout-button">
                            Logout
                        </button>
                    </form>
                </div>

            </div>
        </header>

        {{-- INTRODUCTION --}}
        <section class="page-intro">
            <h2>Selamat datang, {{ auth()->user()->name ?? 'Administrator' }}</h2>
            <p>
                Gunakan dashboard ini untuk mengelola peminjaman
                ruangan, memantau pengaduan fasilitas, dan mengatur
                data pengguna RAPI-Sekolah.
            </p>
        </section>

        {{-- STATISTIK --}}
        <section class="section">

            <div class="section-heading">
                <div>
                    <h2>Ringkasan Sistem</h2>
                    <p class="section-description">
                        Informasi utama sistem RAPI-Sekolah.
                    </p>
                </div>
                <span class="section-index">01</span>
            </div>

            <div class="stats-grid">

                <article class="stat-card">
                    <span class="stat-label">Total Ruangan</span>
                    <strong class="stat-number">
                        {{ $totalRooms ?? 0 }}
                    </strong>
                    <p class="stat-note">Ruangan terdata di sistem</p>
                </article>

                <article class="stat-card">
                    <span class="stat-label">Total Agenda</span>
                    <strong class="stat-number">
                        {{ $totalEvents ?? 0 }}
                    </strong>
                    <p class="stat-note">Agenda kegiatan sekolah</p>
                </article>

                <article class="stat-card">
                    <span class="stat-label">Pengaduan Aktif</span>
                    <strong class="stat-number">
                        {{ $pendingComplaints ?? 0 }}
                    </strong>
                    <p class="stat-note">Laporan perlu ditindaklanjuti</p>
                </article>

                <article class="stat-card">
                    <span class="stat-label">Total Pengguna</span>
                    <strong class="stat-number">
                        {{ $totalUsers ?? 0 }}
                    </strong>
                    <p class="stat-note">Pengguna terdaftar</p>
                </article>

            </div>
        </section>

        {{-- PERSETUJUAN PEMINJAMAN --}}
        <section class="section partial-section" id="persetujuan">
            <div class="section-heading">
                <div>
                    <h2>Persetujuan Peminjaman</h2>
                    <p class="section-description">
                        Periksa dan proses pengajuan peminjaman ruangan.
                    </p>
                </div>
                <span class="section-index">02</span>
            </div>

            @include('admin.persetujuan_peminjaman')
        </section>

        {{-- PEMINDAHAN RUANGAN --}}
        <section class="section partial-section" id="pemindahan">
            <div class="section-heading">
                <div>
                    <h2>Pemindahan Ruangan</h2>
                    <p class="section-description">
                        Kelola pemindahan ruangan untuk kegiatan sekolah.
                    </p>
                </div>
                <span class="section-index">03</span>
            </div>

            @include('admin.pemindahan_ruang')
        </section>

        {{-- PENGADUAN FASILITAS --}}
        <section class="section partial-section" id="pengaduan">
            <div class="section-heading">
                <div>
                    <h2>Pengaduan Fasilitas</h2>
                    <p class="section-description">
                        Pantau laporan kerusakan fasilitas sekolah.
                    </p>
                </div>
                <span class="section-index">04</span>
            </div>

            @include('admin.pengaduan')
        </section>

        {{-- DATA RUANGAN --}}
        <section class="section partial-section" id="data-ruangan">
            <div class="section-heading">
                <div>
                    <h2>Data Ruangan</h2>
                    <p class="section-description">
                        Informasi ruangan yang tersedia di sekolah.
                    </p>
                </div>
                <span class="section-index">05</span>
            </div>

            @include('admin.data_ruang')
        </section>

        {{-- DATA PENGGUNA --}}
        <section class="section partial-section" id="data-pengguna">
            <div class="section-heading">
                <div>
                    <h2>Data Pengguna</h2>
                    <p class="section-description">
                        Informasi akun yang terdaftar di sistem.
                    </p>
                </div>
                <span class="section-index">06</span>
            </div>

            @include('admin.data_pengguna')
        </section>

        {{-- FOOTER --}}
        <footer class="footer">
            <span>
                &copy; {{ date('Y') }} <strong>RAPI-Sekolah</strong>
            </span>
            <span>Room and Facility Management System</span>
        </footer>

    </main>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // Tanggal hari ini
    const todayLabel = document.getElementById('todayLabel');

    if (todayLabel) {
        todayLabel.textContent = new Intl.DateTimeFormat('id-ID', {
            weekday: 'long',
            day: 'numeric',
            month: 'long',
            year: 'numeric'
        }).format(new Date());
    }

    // Sidebar untuk tampilan HP
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
        if (event.key === 'Escape') {
            closeSidebar();
        }
    });

    window.addEventListener('resize', function () {
        if (window.innerWidth > 760) {
            closeSidebar();
        }
    });

    // Menu aktif mengikuti bagian yang diklik
    const navItems = document.querySelectorAll('.nav-item');

    navItems.forEach(function (item) {
        item.addEventListener('click', function () {
            navItems.forEach(function (nav) {
                nav.classList.remove('active');
            });

            item.classList.add('active');
            closeSidebar();
        });
    });

    // Menutup alert
    document.querySelectorAll('.main .btn-close').forEach(function (button) {
        button.addEventListener('click', function () {
            const alert = button.closest('.alert');

            if (alert) {
                alert.remove();
            }
        });
    });

    // Modal sederhana untuk tombol data-bs Bootstrap
    document.querySelectorAll('[data-bs-toggle="modal"]').forEach(
        function (button) {
            button.addEventListener('click', function (event) {
                const selector = button.getAttribute('data-bs-target');

                if (!selector) return;

                let modal;

                try {
                    modal = document.querySelector(selector);
                } catch (error) {
                    return;
                }

                if (!modal) return;

                event.preventDefault();
                modal.classList.add('show');
                modal.setAttribute('aria-hidden', 'false');
            });
        }
    );

    document.querySelectorAll('.modal').forEach(function (modal) {

        modal.addEventListener('click', function (event) {
            if (event.target === modal) {
                modal.classList.remove('show');
                modal.setAttribute('aria-hidden', 'true');
            }
        });

        modal.querySelectorAll('[data-bs-dismiss="modal"]').forEach(
            function (button) {
                button.addEventListener('click', function () {
                    modal.classList.remove('show');
                    modal.setAttribute('aria-hidden', 'true');
                });
            }
        );
    });

});
</script>

</body>
</html>
