<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Guru - RAPI-Sekolah</title>

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
            --green: #218838;
            --yellow: #d69e00;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
            scroll-padding-top: 20px;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 14px;
            line-height: 1.6;
            color: var(--text);
            background: var(--background);
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        button,
        input,
        select,
        textarea {
            font: inherit;
        }

        .app {
            min-height: 100vh;
        }

        /* SIDEBAR */

        .sidebar {
            position: fixed;
            inset: 0 auto 0 0;
            width: 240px;
            height: 100vh;
            padding: 24px 16px;
            background: var(--navy-dark);
            color: var(--white);
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            z-index: 1000;
            transition: transform 0.3s ease;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0 8px 28px;
            border-bottom: 1px solid rgba(255,255,255,0.15);
        }

        .brand-symbol {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            background: var(--white);
            color: var(--navy);
            font-size: 20px;
            font-weight: bold;
        }

        .brand-title {
            font-size: 17px;
            font-weight: bold;
            line-height: 1.3;
        }

        .brand-subtitle {
            margin-top: 3px;
            color: #c4d0df;
            font-size: 9px;
            letter-spacing: 1.3px;
        }

        .nav-caption {
            margin: 25px 10px 10px;
            color: #aab8ca;
            font-size: 10px;
            font-weight: bold;
            letter-spacing: 1.2px;
        }

        .nav-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 12px;
            border-radius: 6px;
            color: #d6deea;
            font-size: 13px;
            transition: 0.2s;
        }

        .nav-item:hover,
        .nav-item.active {
            background: rgba(255,255,255,0.13);
            color: var(--white);
        }

        .nav-symbol {
            width: 20px;
            text-align: center;
            font-size: 17px;
        }

        .nav-separator {
            height: 1px;
            margin: 20px 5px;
            background: rgba(255,255,255,0.15);
        }

        .sidebar-info {
            margin-top: auto;
            padding: 14px;
            border: 1px solid rgba(255,255,255,0.15);
            border-radius: 7px;
            color: #d6deea;
            font-size: 12px;
        }

        .sidebar-info strong {
            display: block;
            margin-bottom: 4px;
            color: var(--white);
        }

        .sidebar-bottom {
            padding: 18px 8px 0;
            color: #aab8ca;
            font-size: 11px;
        }

        .sidebar-version {
            margin-top: 4px;
            font-size: 10px;
        }

        /* MAIN */

        .main {
            min-height: 100vh;
            margin-left: 240px;
            padding: 0 30px 25px;
        }

        /* TOPBAR */

        .topbar {
            min-height: 80px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            border-bottom: 1px solid var(--border);
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .breadcrumb {
            color: var(--muted);
            font-size: 11px;
        }

        .breadcrumb span {
            margin: 0 5px;
        }

        .topbar-title {
            margin-top: 3px;
            font-size: 18px;
            font-weight: bold;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 22px;
        }

        .date-display {
            color: var(--muted);
            font-size: 12px;
        }

        .profile {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .profile-avatar {
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: var(--navy);
            color: var(--white);
            font-weight: bold;
        }

        .profile-name {
            font-size: 12px;
            font-weight: bold;
        }

        .profile-role {
            color: var(--muted);
            font-size: 11px;
        }

        .logout-form {
            margin-left: 5px;
        }

        .logout-button {
            padding: 7px 12px;
            border: 1px solid #e4b8b4;
            border-radius: 5px;
            background: var(--white);
            color: var(--red);
            cursor: pointer;
            font-size: 11px;
        }

        .logout-button:hover {
            background: #fff5f4;
        }

        .menu-toggle {
            display: none;
            padding: 7px 10px;
            border: 1px solid var(--border);
            border-radius: 5px;
            background: var(--white);
            color: var(--navy);
            cursor: pointer;
            font-size: 18px;
        }

        /* PAGE INTRO */

        .page-intro {
            padding: 28px 0 24px;
        }

        .page-intro h2 {
            margin-bottom: 5px;
            color: var(--navy-dark);
            font-size: 21px;
        }

        .page-intro p {
            color: var(--muted);
            font-size: 13px;
        }

        /* SECTION */

        .section {
            margin-bottom: 25px;
            scroll-margin-top: 20px;
        }

        .section-heading {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 15px;
            margin-bottom: 13px;
        }

        .section-heading h3 {
            color: var(--navy-dark);
            font-size: 16px;
        }

        .section-description {
            margin-top: 2px;
            color: var(--muted);
            font-size: 12px;
        }

        .section-index {
            color: #9aa3ae;
            font-size: 12px;
            font-weight: bold;
        }

        /* NOTIFICATION */

        .notification-card {
            margin-bottom: 12px;
            padding: 17px 18px;
            border: 1px solid var(--border);
            border-left: 4px solid var(--yellow);
            border-radius: 6px;
            background: var(--white);
        }

        .notification-card h4 {
            margin-bottom: 6px;
            color: var(--navy-dark);
            font-size: 13px;
        }

        .notification-card p {
            color: var(--text);
            font-size: 12px;
        }

        .notification-reason {
            margin-top: 10px;
            padding: 9px 11px;
            border-radius: 4px;
            background: #fff9e8;
            color: #725600;
            font-size: 12px;
        }

        .empty-notification {
            padding: 18px;
            border: 1px solid var(--border);
            border-radius: 6px;
            background: var(--white);
            color: var(--muted);
            text-align: center;
            font-size: 12px;
        }

        /* CARD */

        .main .card {
            margin-bottom: 20px;
            overflow: hidden;
            border: 1px solid var(--border);
            border-radius: 7px;
            background: var(--white);
        }

        .main .card-header {
            padding: 15px 18px;
            border-bottom: 1px solid var(--border);
        }

        .main .card-header h3,
        .main .card-header h4 {
            color: var(--navy-dark);
            font-size: 14px;
        }

        .main .card-body {
            padding: 18px;
        }

        /* TABLE */

        .table-responsive {
            width: 100%;
            overflow-x: auto;
        }

        .main table {
            width: 100%;
            min-width: 760px;
            border-collapse: collapse;
        }

        .main th,
        .main td {
            padding: 12px 13px;
            border-bottom: 1px solid var(--border);
            text-align: left;
            font-size: 12px;
        }

        .main th {
            background: #f7f8fa;
            color: #596574;
            font-weight: bold;
        }

        .main td {
            color: var(--text);
        }

        .main tbody tr:last-child td {
            border-bottom: none;
        }

        /* BADGE */

        .badge {
            display: inline-block;
            padding: 4px 9px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: bold;
        }

        .bg-success {
            background: #e5f4e9;
            color: #23753a;
        }

        .bg-danger {
            background: #fbe9e7;
            color: #b83227;
        }

        .bg-warning {
            background: #fff4d6;
            color: #8a6500;
        }

        /* FORM */

        .main .form-group {
            margin-bottom: 16px;
        }

        .main .form-group label {
            display: block;
            margin-bottom: 6px;
            color: var(--text);
            font-size: 12px;
            font-weight: bold;
        }

        .main .form-group input,
        .main .form-group select,
        .main .form-group textarea {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid var(--border);
            border-radius: 5px;
            background: var(--white);
            color: var(--text);
            outline: none;
            font-size: 12px;
        }

        .main .form-group input:focus,
        .main .form-group select:focus,
        .main .form-group textarea:focus {
            border-color: var(--navy);
        }

        .main .form-group textarea {
            min-height: 100px;
            resize: vertical;
        }

        .form-help {
            display: block;
            margin-top: 5px;
            color: var(--muted);
            font-size: 11px;
        }

        .main .form-group .text-danger,
        .main .text-danger {
            display: block;
            margin-top: 5px;
            color: var(--red);
            font-size: 11px;
        }

        /* BUTTON */

        .btn {
            display: inline-block;
            padding: 9px 15px;
            border: 1px solid transparent;
            border-radius: 5px;
            cursor: pointer;
            font-size: 12px;
            font-weight: bold;
        }

        .btn-primary {
            background: var(--navy);
            color: var(--white);
        }

        .btn-primary:hover {
            background: var(--navy-dark);
        }

        /* ALERT */

        .alert {
            margin-bottom: 15px;
            padding: 11px 14px;
            border: 1px solid transparent;
            border-radius: 5px;
            font-size: 12px;
        }

        .alert-success {
            border-color: #c7e5ce;
            background: #edf8f0;
            color: #23753a;
        }

        .alert-danger {
            border-color: #f0c9c5;
            background: #fff1ef;
            color: #b83227;
        }

        .alert-info {
            border-color: #c9d9ec;
            background: #eef5fc;
            color: var(--navy);
        }

        /* FOOTER */

        .footer {
            margin-top: 35px;
            padding: 18px 0;
            border-top: 1px solid var(--border);
            color: var(--muted);
            text-align: center;
            font-size: 11px;
        }

        /* OVERLAY */

        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.4);
            z-index: 900;
        }

        /* RESPONSIVE */

        @media (max-width: 1100px) {
            .main {
                padding-right: 22px;
                padding-left: 22px;
            }

            .topbar-right {
                gap: 12px;
            }

            .date-display {
                display: none;
            }
        }

        @media (max-width: 760px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .sidebar-overlay.show {
                display: block;
            }

            .main {
                margin-left: 0;
                padding: 0 18px 20px;
            }

            .menu-toggle {
                display: block;
            }

            .topbar {
                min-height: 70px;
            }

            .topbar-title {
                font-size: 16px;
            }

            .breadcrumb {
                display: none;
            }

            .profile-name,
            .profile-role {
                display: none;
            }

            .logout-button {
                padding: 7px 9px;
            }
        }

        @media (max-width: 450px) {
            .main {
                padding-right: 13px;
                padding-left: 13px;
            }

            .topbar-right {
                gap: 8px;
            }

            .profile-avatar {
                width: 32px;
                height: 32px;
            }

            .page-intro h2 {
                font-size: 18px;
            }

            .page-intro p {
                font-size: 12px;
            }

            .section-heading h3 {
                font-size: 14px;
            }

            .main .card-body {
                padding: 13px;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            html {
                scroll-behavior: auto;
            }

            *,
            *::before,
            *::after {
                transition-duration: 0.01ms !important;
            }
        }
    </style>
</head>

<body>

@php
    $guru = auth()->user();
    $namaGuru = $guru->fullname ?? $guru->username ?? 'Pengguna';
    $inisialGuru = strtoupper(substr($namaGuru, 0, 1));
@endphp

<div class="app">

    <!-- SIDEBAR -->
    <aside class="sidebar" id="sidebar">

        <div class="brand">
            <div class="brand-symbol">R</div>

            <div>
                <div class="brand-title">RAPI-Sekolah</div>
                <div class="brand-subtitle">ROOM MANAGEMENT</div>
            </div>
        </div>

        <div class="nav-caption">MENU UTAMA</div>

        <nav class="nav-group">

            <a href="#dashboard" class="nav-item active">
                <span class="nav-symbol">⌂</span>
                <span>Dashboard Guru</span>
            </a>

            <a href="{{ route('booking.index') }}" class="nav-item">
                <span class="nav-symbol">▦</span>
                <span>Peminjaman Ruangan</span>
            </a>

            <a href="#kerusakan" class="nav-item">
                <span class="nav-symbol">⚑</span>
                <span>Lapor Kerusakan</span>
            </a>

            <a href="#notifikasi" class="nav-item">
                <span class="nav-symbol">♢</span>
                <span>Notifikasi</span>
            </a>

        </nav>

        <div class="nav-separator"></div>

        <div class="sidebar-info">
            <strong>Panel Guru & Organisasi</strong>
            Kelola peminjaman ruangan dan laporan fasilitas sekolah.
        </div>

        <div class="sidebar-bottom">
            RAPI-Sekolah
            <div class="sidebar-version">Room Management System</div>
        </div>

    </aside>

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- MAIN CONTENT -->
    <main class="main" id="dashboard">

        <!-- TOPBAR -->
        <header class="topbar">

            <div class="topbar-left">

                <button class="menu-toggle" id="menuToggle" type="button">
                    ☰
                </button>

                <div>
                    <div class="breadcrumb">
                        RAPI-Sekolah <span>/</span> Dashboard Guru
                    </div>

                    <div class="topbar-title">
                        Dashboard Guru
                    </div>
                </div>

            </div>

            <div class="topbar-right">

                <div class="date-display" id="currentDate"></div>

                <div class="profile">

                    <div class="profile-avatar">
                        {{ $inisialGuru }}
                    </div>

                    <div>
                        <div class="profile-name">
                            {{ $namaGuru }}
                        </div>

                        <div class="profile-role">
                            Guru / Organisasi
                        </div>
                    </div>

                </div>

                <form
                    action="{{ route('logout') }}"
                    method="POST"
                    class="logout-form"
                    onsubmit="return confirm('Apakah Anda yakin ingin keluar?')"
                >
                    @csrf

                    <button type="submit" class="logout-button">
                        Keluar
                    </button>
                </form>

            </div>

        </header>

        <!-- INTRO -->
        <section class="page-intro">

            <h2>
                Selamat Datang, {{ $namaGuru }}
            </h2>

            <p>
                Kelola peminjaman ruangan, pantau status pengajuan,
                dan laporkan kerusakan fasilitas sekolah.
            </p>

        </section>

        <!-- ALERT -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->has('msg'))
            <div class="alert alert-danger">
                {{ $errors->first('msg') }}
            </div>
        @endif

        <!-- NOTIFIKASI -->
        <section class="section" id="notifikasi">

            <div class="section-heading">
                <div>
                    <h3>Notifikasi</h3>

                    <p class="section-description">
                        Informasi perubahan agenda peminjaman ruangan.
                    </p>
                </div>

                <div class="section-index">01</div>
            </div>

            @if(isset($movedEvents) && $movedEvents->count() > 0)

                @foreach($movedEvents as $event)

                    <div class="notification-card">

                        <h4>
                            Pemberitahuan Pemindahan Ruangan
                        </h4>

                        <p>
                            Agenda
                            <strong>{{ $event->event_name }}</strong>
                            pada tanggal
                            <strong>{{ $event->date }}</strong>
                            dipindahkan ke ruangan
                            <strong>
                                {{ $event->room->room_name ?? 'Ruangan' }}
                            </strong>.
                        </p>

                        <div class="notification-reason">
                            <strong>Alasan Waka:</strong>
                            {{ $event->move_reason ?? 'Tidak ada keterangan.' }}
                        </div>

                    </div>

                @endforeach

            @else

                <div class="empty-notification">
                    Tidak ada notifikasi pemindahan ruangan.
                </div>

            @endif

        </section>

        <!-- STATUS PEMINJAMAN -->
        <section class="section">

            <div class="section-heading">
                <div>
                    <h3>Status Peminjaman Ruangan</h3>

                    <p class="section-description">
                        Pantau status pengajuan peminjaman ruangan.
                    </p>
                </div>

                <div class="section-index">02</div>
            </div>

            @include('guru.status_ruang')

        </section>

        <!-- LAPOR KERUSAKAN -->
        <section class="section">

            <div class="section-heading">
                <div>
                    <h3>Laporan Kerusakan Fasilitas</h3>

                    <p class="section-description">
                        Laporkan kerusakan fasilitas yang ada di sekolah.
                    </p>
                </div>

                <div class="section-index">03</div>
            </div>

            @include('guru.kerusakan_fasilitas')

        </section>

        <!-- FOOTER -->
        <footer class="footer">
            RAPI-Sekolah &copy; {{ date('Y') }}
        </footer>

    </main>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const menuToggle = document.getElementById('menuToggle');

        // TANGGAL
        const currentDate = document.getElementById('currentDate');

        if (currentDate) {
            currentDate.textContent = new Intl.DateTimeFormat('id-ID', {
                weekday: 'long',
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            }).format(new Date());
        }

        // BUKA SIDEBAR
        function openSidebar() {
            sidebar.classList.add('show');
            overlay.classList.add('show');
        }

        // TUTUP SIDEBAR
        function closeSidebar() {
            sidebar.classList.remove('show');
            overlay.classList.remove('show');
        }

        if (menuToggle) {
            menuToggle.addEventListener('click', function () {
                if (sidebar.classList.contains('show')) {
                    closeSidebar();
                } else {
                    openSidebar();
                }
            });
        }

        // KLIK OVERLAY
        overlay.addEventListener('click', closeSidebar);

        // TOMBOL ESCAPE
        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                closeSidebar();
            }
        });

        // TUTUP SIDEBAR SETELAH MEMILIH MENU
        const navItems = document.querySelectorAll('.nav-item');

        navItems.forEach(function (item) {

            item.addEventListener('click', function () {

                navItems.forEach(function (nav) {
                    nav.classList.remove('active');
                });

                item.classList.add('active');

                if (window.innerWidth <= 760) {
                    closeSidebar();
                }

            });

        });

        // KETIKA LAYAR DIPERBESAR
        window.addEventListener('resize', function () {

            if (window.innerWidth > 760) {
                closeSidebar();
            }

        });

    });
</script>

</body>
</html>