<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Pengajuan Peminjaman Ruang - RAPI-Sekolah</title>

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
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
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
        select {
            font: inherit;
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

        /* CARD */

        .card {
            overflow: hidden;
            border: 1px solid var(--border);
            border-radius: 7px;
            background: var(--white);
        }

        .card-header {
            padding: 16px 20px;
            border-bottom: 1px solid var(--border);
        }

        .card-header h3 {
            color: var(--navy-dark);
            font-size: 15px;
        }

        .card-body {
            padding: 22px;
        }

        /* USER INFO */

        .user-info {
            margin-bottom: 20px;
            padding: 13px 15px;
            border: 1px solid var(--border);
            border-radius: 6px;
            background: #f7f8fa;
            line-height: 1.9;
            font-size: 12px;
        }

        .user-info strong {
            color: var(--navy-dark);
        }

        /* FORM */

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            margin-bottom: 6px;
            color: var(--text);
            font-size: 12px;
            font-weight: bold;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 11px 12px;
            border: 1px solid var(--border);
            border-radius: 5px;
            background: var(--white);
            color: var(--text);
            outline: none;
            font-size: 12px;
        }

        .form-group input:focus,
        .form-group select:focus {
            border-color: var(--navy);
        }

        .form-group select option:disabled {
            color: #9aa3ae;
        }

        .required-note {
            margin-top: 5px;
            color: var(--muted);
            font-size: 11px;
        }

        /* BUTTON */

        .button {
            display: inline-block;
            padding: 10px 16px;
            border: 1px solid transparent;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            font-size: 12px;
            font-weight: bold;
        }

        .button-primary {
            width: 100%;
            background: var(--navy);
            color: var(--white);
        }

        .button-primary:hover {
            background: var(--navy-dark);
        }

        .button-primary:disabled {
            background: #9aa3ae;
            cursor: not-allowed;
        }

        .button-secondary {
            margin-top: 12px;
            border-color: var(--border);
            background: #f5f6f8;
            color: var(--text);
        }

        .button-secondary:hover {
            background: #e9edf2;
        }

        /* ALERT */

        .alert {
            margin-bottom: 15px;
            padding: 12px 15px;
            border: 1px solid transparent;
            border-radius: 5px;
            font-size: 12px;
        }

        .alert-success {
            border-color: #c7e5ce;
            background: #edf8f0;
            color: #23753a;
        }

        .alert-error {
            border-color: #f0c9c5;
            background: #fff1ef;
            color: #b83227;
        }

        .alert ul {
            margin: 6px 0 0 20px;
        }

        /* NOTE */

        .note {
            margin-top: 18px;
            padding: 13px 15px;
            border: 1px solid #c9d9ec;
            border-radius: 5px;
            background: #eef5fc;
            color: var(--navy);
            font-size: 12px;
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

            .card-body {
                padding: 15px;
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
    $user = auth()->user();
    $namaUser = $user->fullname ?? $user->username ?? $user->email ?? 'Pengguna';
    $inisialUser = strtoupper(substr($namaUser, 0, 1));
    $roleUser = $user->role?->roles_name ?? 'Pengguna';
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

            <a href="{{ route('guru.dashboard') }}" class="nav-item">
                <span class="nav-symbol">⌂</span>
                <span>Dashboard Guru</span>
            </a>

            <a href="{{ route('booking.index') }}" class="nav-item active">
                <span class="nav-symbol">▦</span>
                <span>Peminjaman Ruangan</span>
            </a>

            <a href="{{ route('guru.dashboard') }}#kerusakan" class="nav-item">
                <span class="nav-symbol">⚑</span>
                <span>Lapor Kerusakan</span>
            </a>

            <a href="{{ route('guru.dashboard') }}#notifikasi" class="nav-item">
                <span class="nav-symbol">♢</span>
                <span>Notifikasi</span>
            </a>

        </nav>

        <div class="nav-separator"></div>

        <div class="sidebar-info">
            <strong>Panel Guru & Organisasi</strong>
            Ajukan peminjaman ruangan untuk kegiatan sekolah.
        </div>

        <div class="sidebar-bottom">
            RAPI-Sekolah
            <div class="sidebar-version">Room Management System</div>
        </div>

    </aside>

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- MAIN -->
    <main class="main">

        <!-- TOPBAR -->
        <header class="topbar">

            <div class="topbar-left">

                <button class="menu-toggle" id="menuToggle" type="button">
                    ☰
                </button>

                <div>
                    <div class="breadcrumb">
                        RAPI-Sekolah <span>/</span> Peminjaman Ruangan
                    </div>

                    <div class="topbar-title">
                        Pengajuan Peminjaman Ruang
                    </div>
                </div>

            </div>

            <div class="topbar-right">

                <div class="date-display" id="currentDate"></div>

                <div class="profile">

                    <div class="profile-avatar">
                        {{ $inisialUser }}
                    </div>

                    <div>
                        <div class="profile-name">
                            {{ $namaUser }}
                        </div>

                        <div class="profile-role">
                            {{ $roleUser }}
                        </div>
                    </div>

                </div>

                <form
                    action="{{ route('logout') }}"
                    method="POST"
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

            <h2>Form Pengajuan Peminjaman Ruang</h2>

            <p>
                Ajukan peminjaman ruangan untuk kegiatan sekolah.
                Pengajuan akan menunggu persetujuan Admin/Waka.
            </p>

        </section>

        <!-- FORM SECTION -->
        <section class="section">

            <div class="section-heading">

                <div>
                    <h3>Data Pengajuan</h3>

                    <p class="section-description">
                        Lengkapi data kegiatan dan ruangan yang ingin digunakan.
                    </p>
                </div>

                <div class="section-index">01</div>

            </div>

            <div class="card">

                <div class="card-header">
                    <h3>Informasi Peminjaman</h3>
                </div>

                <div class="card-body">

                    <!-- INFORMASI PENGGUNA -->
                    <div class="user-info">

                        <strong>Pengguna login:</strong>
                        {{ $namaUser }}

                        <br>

                        <strong>Role:</strong>
                        {{ $roleUser }}

                    </div>

                    <!-- PESAN BERHASIL -->
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- PESAN GAGAL -->
                    @if (session('error'))
                        <div class="alert alert-error">
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- VALIDASI -->
                    @if ($errors->any())

                        <div class="alert alert-error">

                            <strong>Pengajuan belum berhasil:</strong>

                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>

                        </div>

                    @endif

                    <!-- FORM -->
                    <form action="{{ route('events.store') }}" method="POST">
                        @csrf

                        <!-- PILIH RUANGAN -->
                        <div class="form-group">

                            <label for="room_id">
                                Pilih Ruangan
                            </label>

                            <select name="room_id" id="room_id" required>

                                <option value="">
                                    -- Pilih Ruangan --
                                </option>

                                @forelse ($rooms as $room)

                                    <option
                                        value="{{ $room->id }}"
                                        {{ old('room_id') == $room->id ? 'selected' : '' }}
                                    >
                                        {{ $room->room_name }}
                                        (Kapasitas: {{ $room->capacity }})
                                    </option>

                                @empty

                                    <option value="" disabled>
                                        Belum ada ruangan aktif
                                    </option>

                                @endforelse

                            </select>

                        </div>

                        <!-- NAMA KEGIATAN -->
                        <div class="form-group">

                            <label for="event_name">
                                Nama Agenda / Kegiatan
                            </label>

                            <input
                                type="text"
                                id="event_name"
                                name="event_name"
                                value="{{ old('event_name') }}"
                                placeholder="Contoh: Rapat Koordinasi Guru"
                                maxlength="255"
                                required
                            >

                        </div>

                        <!-- TANGGAL -->
                        <div class="form-group">

                            <label for="date">
                                Tanggal Peminjaman
                            </label>

                            <input
                                type="date"
                                id="date"
                                name="date"
                                value="{{ old('date', now()->format('Y-m-d')) }}"
                                min="{{ now()->format('Y-m-d') }}"
                                required
                            >

                            <p class="required-note">
                                Tanggal otomatis terisi hari ini. Kamu bisa memilih
                                tanggal mendatang, tetapi tidak bisa memilih tanggal lampau.
                            </p>

                        </div>

                        <!-- PILIH SESI MULAI -->
                        <div class="form-group">

                            <label for="start_session">
                                Sesi Mulai
                            </label>

                            <select id="start_session" name="start_session" required>
                                <option value="">-- Pilih Sesi Mulai --</option>
                                @for ($session = 1; $session <= 10; $session++)
                                    @php
                                        $sessionStartMinutes = (7 * 60) + (($session - 1) * 90);
                                        $sessionEndMinutes = $sessionStartMinutes + 90;
                                        $sessionStartLabel = sprintf('%02d.%02d', intdiv($sessionStartMinutes, 60), $sessionStartMinutes % 60);
                                        $sessionEndLabel = sprintf('%02d.%02d', intdiv($sessionEndMinutes, 60), $sessionEndMinutes % 60);
                                    @endphp
                                    @php
                                        $bookingDate = old('date', now()->format('Y-m-d'));
                                        $sessionStartDateTime = \Carbon\Carbon::createFromFormat(
                                            'Y-m-d H:i',
                                            $bookingDate . ' ' . sprintf('%02d:%02d', intdiv($sessionStartMinutes, 60), $sessionStartMinutes % 60),
                                            config('app.timezone')
                                        );
                                        $sessionUnavailableToday = $bookingDate === now()->format('Y-m-d')
                                            && $sessionStartDateTime->lt(now()->copy()->addHours(3));
                                    @endphp
                                    <option
                                        value="{{ $session }}"
                                        {{ $sessionUnavailableToday ? 'disabled' : '' }}
                                        {{ (string) old('start_session') === (string) $session && !$sessionUnavailableToday ? 'selected' : '' }}
                                    >
                                        Sesi {{ $session }} ({{ $sessionStartLabel }}–{{ $sessionEndLabel }})
                                    </option>
                                @endfor
                            </select>

                            <p class="required-note">
                                Untuk peminjaman hari ini, sesi hanya dapat dipilih minimal 3 jam sebelum waktu mulai.
                            </p>

                        </div>

                        <!-- PILIH SESI SELESAI -->
                        <div class="form-group">

                            <label for="end_session">
                                Sesi Selesai
                            </label>

                            <select id="end_session" name="end_session" required>
                                <option value="">-- Pilih Sesi Selesai --</option>
                                @for ($session = 1; $session <= 10; $session++)
                                    @php
                                        $sessionStartMinutes = (7 * 60) + (($session - 1) * 90);
                                        $sessionEndMinutes = $sessionStartMinutes + 90;
                                        $sessionStartLabel = sprintf('%02d.%02d', intdiv($sessionStartMinutes, 60), $sessionStartMinutes % 60);
                                        $sessionEndLabel = sprintf('%02d.%02d', intdiv($sessionEndMinutes, 60), $sessionEndMinutes % 60);
                                    @endphp
                                    <option
                                        value="{{ $session }}"
                                        {{ (string) old('end_session') === (string) $session ? 'selected' : '' }}
                                    >
                                        Sesi {{ $session }} ({{ $sessionStartLabel }}–{{ $sessionEndLabel }})
                                    </option>
                                @endfor
                            </select>

                        </div>

                        <!-- PREVIEW WAKTU -->
                        <div class="form-group">
                            <label>Rentang Waktu Peminjaman</label>
                            <div class="user-info" id="session_preview" aria-live="polite">
                                Pilih sesi mulai dan sesi selesai untuk melihat rentang waktu.
                            </div>
                        </div>

                        <!-- TOMBOL KIRIM -->
                        <button
                            type="submit"
                            class="button button-primary"
                            {{ $rooms->isEmpty() ? 'disabled' : '' }}
                        >
                            Kirim Pengajuan Peminjaman
                        </button>

                    </form>

                    <!-- INFORMASI -->
                    <div class="note">
                        <strong>Informasi:</strong>
                        Pengajuan belum berarti peminjaman disetujui.
                        Tunggu keputusan Admin/Waka melalui sistem.
                    </div>

                    <!-- KEMBALI -->
                    <a
                        href="{{ route('guru.dashboard') }}"
                        class="button button-secondary"
                    >
                        Kembali ke Dashboard Guru
                    </a>

                </div>

            </div>

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

        // PILIHAN SESI DAN ATURAN MINIMAL 3 JAM
        const dateInput = document.getElementById('date');
        const startSession = document.getElementById('start_session');
        const endSession = document.getElementById('end_session');
        const sessionPreview = document.getElementById('session_preview');

        const sessionTimes = {
            1: { start: '07:00', end: '08:30' },
            2: { start: '08:30', end: '10:00' },
            3: { start: '10:00', end: '11:30' },
            4: { start: '11:30', end: '13:00' },
            5: { start: '13:00', end: '14:30' },
            6: { start: '14:30', end: '16:00' },
            7: { start: '16:00', end: '17:30' },
            8: { start: '17:30', end: '19:00' },
            9: { start: '19:00', end: '20:30' },
            10: { start: '20:30', end: '22:00' }
        };

        function formatTime(time) {
            return time.replace(':', '.');
        }

        // Waktu acuan berasal dari server Laravel agar mengikuti timezone aplikasi.
        const appToday = @json(now()->format('Y-m-d'));
        const serverNowTimestamp = {{ now()->timestamp * 1000 }};
        const browserTimestampAtLoad = Date.now();

        function getCurrentServerTime() {
            return new Date(
                serverNowTimestamp + (Date.now() - browserTimestampAtLoad)
            );
        }

        function getLocalDateString(date) {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            return year + '-' + month + '-' + day;
        }

        function updateSessionOptions() {
            if (!dateInput || !startSession || !endSession) return;

            const selectedDate = dateInput.value;
            const currentServerTime = getCurrentServerTime();
            const isToday = selectedDate === appToday;

            // Ambang batas: waktu mulai sesi harus >= sekarang + 3 jam.
            const minimumStartTimestamp = currentServerTime.getTime() + (3 * 60 * 60 * 1000);

            Array.from(startSession.options).forEach(function (option) {
                if (!option.value) return;

                const session = sessionTimes[option.value];
                let unavailable = false;

                if (isToday) {
                    const sessionStartParts = session.start.split(':');
                    const sessionStart = new Date(currentServerTime);
                    sessionStart.setHours(
                        parseInt(sessionStartParts[0], 10),
                        parseInt(sessionStartParts[1], 10),
                        0,
                        0
                    );

                    unavailable = sessionStart.getTime() < minimumStartTimestamp;
                }

                option.disabled = unavailable;
            });

            const selectedStartOption = startSession.options[startSession.selectedIndex];
            if (selectedStartOption && selectedStartOption.value && selectedStartOption.disabled) {
                startSession.value = '';
            }

            updateEndSessionOptions();
            updateSessionPreview();
        }

        function updateEndSessionOptions() {
            if (!startSession || !endSession) return;

            const selectedStart = parseInt(startSession.value, 10);

            Array.from(endSession.options).forEach(function (option) {
                if (!option.value) return;

                const sessionNumber = parseInt(option.value, 10);
                option.disabled = !selectedStart || sessionNumber < selectedStart;
            });

            const selectedEndOption = endSession.options[endSession.selectedIndex];
            if (selectedEndOption && selectedEndOption.value && selectedEndOption.disabled) {
                endSession.value = '';
            }
        }

        function updateSessionPreview() {
            if (!sessionPreview || !startSession || !endSession) return;

            const startNumber = parseInt(startSession.value, 10);
            const endNumber = parseInt(endSession.value, 10);

            if (!startNumber || !endNumber || endNumber < startNumber) {
                sessionPreview.textContent = 'Pilih sesi mulai dan sesi selesai untuk melihat rentang waktu.';
                return;
            }

            const startTime = sessionTimes[startNumber].start;
            const endTime = sessionTimes[endNumber].end;

            sessionPreview.textContent =
                'Peminjaman: ' + formatTime(startTime) + '–' + formatTime(endTime) +
                ' (Sesi ' + startNumber + ' sampai Sesi ' + endNumber + ').';
        }

        if (dateInput && startSession && endSession) {
            dateInput.addEventListener('change', function () {
                // Ganti tanggal: pilihan sesi yang tersedia dihitung ulang.
                updateSessionOptions();
            });

            startSession.addEventListener('change', function () {
                updateEndSessionOptions();
                updateSessionPreview();
            });

            endSession.addEventListener('change', updateSessionPreview);

            updateSessionOptions();

            // Perbarui pilihan setiap 30 detik jika halaman dibiarkan terbuka.
            setInterval(updateSessionOptions, 30000);
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