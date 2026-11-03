<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemindahan Ruangan - RAPI-Sekolah</title>

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
            color: inherit;
            text-decoration: none;
        }

        button, input, select, textarea {
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

        /* INFO AGENDA */

        .info-box {
            margin-bottom: 25px;
            padding: 18px;
            border: 1px solid var(--border);
            border-radius: 6px;
            background: #f7f8fa;
        }

        .info-label {
            margin-bottom: 4px;
            color: var(--muted);
            font-size: 11px;
        }

        .info-value {
            color: var(--text);
            font-size: 13px;
            font-weight: bold;
        }

        .info-main {
            margin-bottom: 18px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
        }

        .status-approved {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 4px;
            background: #e5f4e9;
            color: #23753a;
            font-size: 11px;
            font-weight: bold;
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

        .required {
            color: var(--red);
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
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
        .form-group select:focus,
        .form-group textarea:focus {
            border-color: var(--navy);
        }

        .form-group textarea {
            min-height: 110px;
            resize: vertical;
        }

        .form-help {
            margin-top: 5px;
            color: var(--muted);
            font-size: 11px;
        }

        .invalid-feedback {
            display: block;
            margin-top: 5px;
            color: var(--red);
            font-size: 11px;
        }

        .is-invalid {
            border-color: var(--red) !important;
        }

        /* BUTTONS */

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
            background: var(--navy);
            color: var(--white);
        }

        .button-primary:hover {
            background: var(--navy-dark);
        }

        .button-secondary {
            border-color: var(--border);
            background: var(--white);
            color: var(--text);
        }

        .button-secondary:hover {
            background: #f5f6f8;
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            padding-top: 18px;
            border-top: 1px solid var(--border);
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

        .alert-danger {
            border-color: #f0c9c5;
            background: #fff1ef;
            color: #b83227;
        }

        .alert ul {
            margin: 6px 0 0 20px;
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

        @media (max-width: 500px) {
            .main {
                padding-right: 13px;
                padding-left: 13px;
            }

            .info-grid {
                grid-template-columns: 1fr;
                gap: 13px;
            }

            .card-body {
                padding: 15px;
            }

            .form-actions {
                flex-direction: column-reverse;
            }

            .form-actions .button {
                width: 100%;
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
    $namaUser = $user->fullname ?? $user->username ?? $user->email ?? 'Admin';
    $inisialUser = strtoupper(substr($namaUser, 0, 1));
    $roleUser = $user->role?->roles_name ?? 'Admin/Waka';
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

            <a href="{{ route('admin.dashboard') }}" class="nav-item">
                <span class="nav-symbol">⌂</span>
                <span>Dashboard Admin</span>
            </a>

            <a href="{{ route('admin.dashboard') }}#persetujuan" class="nav-item">
                <span class="nav-symbol">▦</span>
                <span>Persetujuan Peminjaman</span>
            </a>

            <a href="{{ route('admin.dashboard') }}#ruangan" class="nav-item">
                <span class="nav-symbol">▣</span>
                <span>Data Ruangan</span>
            </a>

            <a href="{{ route('admin.dashboard') }}#pengguna" class="nav-item">
                <span class="nav-symbol">♙</span>
                <span>Data Pengguna</span>
            </a>

        </nav>

        <div class="nav-separator"></div>

        <div class="sidebar-info">
            <strong>Panel Admin / Waka</strong>
            Kelola agenda dan perubahan ruangan sekolah.
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
                        RAPI-Sekolah <span>/</span> Pemindahan Ruangan
                    </div>

                    <div class="topbar-title">
                        Pemindahan Ruangan
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

            <h2>Pemindahan Ruangan</h2>

            <p>
                Atur perubahan ruangan untuk agenda yang telah disetujui.
            </p>

        </section>

        <!-- FORM SECTION -->
        <section class="section">

            <div class="section-heading">
                <div>
                    <h3>Data Pemindahan</h3>

                    <p class="section-description">
                        Periksa informasi agenda dan tentukan ruangan tujuan.
                    </p>
                </div>

                <div class="section-index">01</div>
            </div>

            <div class="card">

                <div class="card-header">
                    <h3>Informasi Agenda dan Pemindahan</h3>
                </div>

                <div class="card-body">

                    {{-- Pesan error --}}
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    {{-- Pesan sukses --}}
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- Pesan validasi --}}
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <strong>Periksa kembali formulir:</strong>

                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- INFORMASI AGENDA -->
                    <div class="section-heading">
                        <div>
                            <h3>Informasi Agenda</h3>
                            <p class="section-description">
                                Informasi agenda yang akan dipindahkan.
                            </p>
                        </div>
                    </div>

                    <div class="info-box">

                        <div class="info-main">
                            <div class="info-label">Nama Agenda</div>

                            <div class="info-value">
                                {{ $event->event_name }}
                            </div>
                        </div>

                        <div class="info-grid">

                            <div>
                                <div class="info-label">Ruangan Saat Ini</div>

                                <div class="info-value">
                                    {{ $event->room->room_name ?? 'Tanpa Ruangan' }}
                                </div>
                            </div>

                            <div>
                                <div class="info-label">Tanggal Kegiatan</div>

                                <div class="info-value">
                                    {{ $event->date
                                        ? \Carbon\Carbon::parse($event->date)->format('d M Y')
                                        : '-' }}
                                </div>
                            </div>

                            <div>
                                <div class="info-label">Waktu Kegiatan</div>

                                <div class="info-value">
                                    {{ $event->start_time
                                        ? substr((string) $event->start_time, 0, 5)
                                        : '--:--' }}
                                    -
                                    {{ $event->end_time
                                        ? substr((string) $event->end_time, 0, 5)
                                        : '--:--' }}
                                </div>
                            </div>

                            <div>
                                <div class="info-label">Status Agenda</div>

                                <span class="status-approved">
                                    Disetujui
                                </span>
                            </div>

                        </div>

                    </div>

                    <!-- FORM PEMINDAHAN -->
                    <div class="section-heading">
                        <div>
                            <h3>Form Pemindahan Ruangan</h3>

                            <p class="section-description">
                                Pilih ruangan baru dan berikan alasan pemindahan.
                            </p>
                        </div>
                    </div>

                    <form
                        action="{{ route('admin.events.override', $event->events_id) }}"
                        method="POST"
                    >
                        @csrf
                        @method('PUT')

                        <!-- RUANGAN TUJUAN -->
                        <div class="form-group">

                            <label for="room_id">
                                Ruangan Tujuan <span class="required">*</span>
                            </label>

                            <select
                                name="room_id"
                                id="room_id"
                                class="@error('room_id') is-invalid @enderror"
                                required
                            >
                                <option value="">
                                    -- Pilih Ruangan Tujuan --
                                </option>

                                @foreach($rooms as $room)

                                    @if((int) $room->id !== (int) $event->room_id)

                                        <option
                                            value="{{ $room->id }}"
                                            @selected((string) old('room_id') === (string) $room->id)
                                        >
                                            {{ $room->room_name }}
                                        </option>

                                    @endif

                                @endforeach

                            </select>

                            @error('room_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                            <div class="form-help">
                                Pilih ruangan aktif selain ruangan yang sedang digunakan.
                            </div>

                        </div>

                        <!-- ALASAN PEMINDAHAN -->
                        <div class="form-group">

                            <label for="move_reason">
                                Alasan Pemindahan <span class="required">*</span>
                            </label>

                            <textarea
                                name="move_reason"
                                id="move_reason"
                                class="@error('move_reason') is-invalid @enderror"
                                rows="4"
                                maxlength="1000"
                                placeholder="Tuliskan alasan pemindahan ruangan..."
                                required
                            >{{ old('move_reason') }}</textarea>

                            @error('move_reason')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                            <div class="form-help">
                                Maksimal 1.000 karakter. Alasan pemindahan dapat
                                ditampilkan kepada Guru melalui notifikasi.
                            </div>

                        </div>

                        <!-- TOMBOL -->
                        <div class="form-actions">

                            <a
                                href="{{ route('admin.dashboard') }}"
                                class="button button-secondary"
                            >
                                Batal
                            </a>

                            <button
                                type="submit"
                                class="button button-primary"
                                onclick="return confirm('Apakah Anda yakin ingin memindahkan agenda ini ke ruangan yang dipilih?')"
                            >
                                Simpan Pemindahan
                            </button>

                        </div>

                    </form>

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

        overlay.addEventListener('click', closeSidebar);

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                closeSidebar();
            }
        });

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

        window.addEventListener('resize', function () {
            if (window.innerWidth > 760) {
                closeSidebar();
            }
        });

    });
</script>

</body>
</html>