
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - RAPI-Sekolah</title>

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
            --green: #198754;
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

        a { color: inherit; text-decoration: none; }

        button, input { font: inherit; }

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
            padding: 0 30px 30px;
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
            overflow: hidden;
        }

        .profile-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
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
            cursor: pointer;
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
            cursor: pointer;
        }

        .sidebar-overlay {
            display: none;
        }

        .page-intro {
            margin-bottom: 25px;
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

        .section { margin-bottom: 25px; }

        .section-heading { margin-bottom: 15px; }

        .section-heading h2 {
            margin: 0;
            font-size: 18px;
        }

        .section-description {
            margin: 4px 0 0;
            color: var(--muted);
            font-size: 11px;
        }

        .card {
            width: 100%;
            overflow: hidden;
            border: 1px solid var(--border);
            border-radius: 5px;
            background: white;
        }

        .card-header {
            padding: 17px 20px;
            border-bottom: 1px solid var(--border);
            font-size: 14px;
            font-weight: bold;
        }

        .card-body { padding: 22px; }

        .user-heading {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 22px;
        }

        .large-avatar {
            display: grid;
            place-items: center;
            width: 82px;
            height: 82px;
            flex-shrink: 0;
            border-radius: 50%;
            background: #e8edf3;
            color: var(--navy);
            font-size: 30px;
            font-weight: bold;
            overflow: hidden;
        }

        .large-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .user-heading h3 {
            margin: 0 0 4px;
            color: var(--navy);
            font-size: 18px;
        }

        .user-heading p {
            margin: 0;
            color: var(--muted);
            font-size: 12px;
        }

        .role-badge {
            display: inline-block;
            margin-top: 7px;
            padding: 4px 10px;
            border-radius: 4px;
            background: #e8edf3;
            color: var(--navy);
            font-size: 10px;
            font-weight: bold;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 17px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 7px;
            min-width: 0;
        }

        .form-group.full { grid-column: 1 / -1; }

        .form-label {
            font-size: 12px;
            font-weight: bold;
        }

        .form-control {
            width: 100%;
            min-height: 42px;
            padding: 10px 12px;
            border: 1px solid #d6dce3;
            border-radius: 4px;
            outline: none;
            background: white;
            color: var(--text);
            font-size: 12px;
        }

        .form-control:focus {
            border-color: var(--navy);
            box-shadow: 0 0 0 2px rgb(23 54 93 / 10%);
        }

        .form-control[readonly] {
            background: #f1f3f5;
            color: #68717c;
        }

        .form-help {
            color: var(--muted);
            font-size: 10px;
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 22px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 39px;
            padding: 9px 16px;
            border: 1px solid var(--navy);
            border-radius: 4px;
            background: var(--navy);
            color: white;
            font-size: 11px;
            font-weight: bold;
            cursor: pointer;
        }

        .btn:hover {
            background: var(--navy-dark);
        }

        .btn-outline {
            background: white;
            color: var(--navy);
        }

        .btn-outline:hover {
            background: #edf1f6;
            color: var(--navy);
        }

        .alert {
            margin-bottom: 18px;
            padding: 13px 16px;
            border: 1px solid;
            border-radius: 4px;
            font-size: 12px;
        }

        .alert-success {
            border-color: #b7dfc8;
            background: #edf8f1;
            color: #176b3a;
        }

        .alert-danger {
            border-color: #e8c4c0;
            background: #fff1ef;
            color: #a12b20;
        }

        .alert ul {
            margin: 7px 0 0;
            padding-left: 20px;
        }

        .password-note {
            margin: 0 0 18px;
            color: var(--muted);
            font-size: 11px;
        }

        @media (max-width: 1050px) {
            .main { padding-right: 20px; padding-left: 20px; }
            .date-display { display: none; }
        }

        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }

            .main {
                margin-left: 0;
                padding: 0 14px 25px;
            }

            .menu-toggle { display: block; }

            .sidebar-overlay.show {
                display: block;
                position: fixed;
                inset: 0;
                z-index: 900;
                background: rgb(0 0 0 / 35%);
            }

            .topbar { min-height: 70px; }
            .topbar-title { font-size: 15px; }
            .profile-text { display: none; }
            .logout-button { padding: 7px 8px; }
            .page-intro { padding: 18px; }
            .page-intro h2 { font-size: 19px; }
            .card-body { padding: 16px; }
            .form-grid { grid-template-columns: 1fr; }
            .form-group.full { grid-column: auto; }
        }

        @media (max-width: 420px) {
            .user-heading { align-items: flex-start; }
            .large-avatar { width: 65px; height: 65px; font-size: 24px; }
            .form-actions { flex-direction: column; }
            .btn { width: 100%; }
        }
    </style>
</head>

<body>
@php
    $currentUser = auth()->user();
    $roleName = match ((int) $currentUser->role_id) {
        1 => 'Admin / Waka',
        2 => 'PIC Ruangan',
        3 => 'Guru / Organisasi',
        default => 'Pengguna',
    };
    $dashboardRoute = match ((int) $currentUser->role_id) {
        1 => route('admin.dashboard'),
        2 => route('pic.dashboard'),
        3 => route('guru.dashboard'),
        default => route('calendar'),
    };
@endphp

<div class="app">

    <aside class="sidebar" id="sidebar">
        <a href="{{ $dashboardRoute }}" class="brand">
            <div class="brand-symbol">R</div>
            <div>
                <h2 class="brand-title">RAPI-Sekolah</h2>
                <span class="brand-subtitle">ROOM MANAGEMENT</span>
            </div>
        </a>

        <p class="nav-caption">Menu Utama</p>

        <nav class="nav-group">
            <a href="{{ $dashboardRoute }}" class="nav-item">
                <span class="nav-symbol">⌂</span>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('profile.index') }}" class="nav-item active">
                <span class="nav-symbol">♙</span>
                <span>Profil Saya</span>
            </a>
        </nav>

        <div class="nav-separator"></div>

        <p class="nav-caption">Navigasi</p>
        <nav class="nav-group">
            <a href="{{ route('calendar') }}" class="nav-item">
                <span class="nav-symbol">▦</span>
                <span>Kalender Kegiatan</span>
            </a>
        </nav>

        <div class="sidebar-bottom">
            <div class="sidebar-info">
                <h3 class="sidebar-info-title">{{ $roleName }}</h3>
                <p>Kelola informasi akun dan keamanan profil RAPI-Sekolah.</p>
            </div>
            <div class="sidebar-version">RAPI-Sekolah &middot; {{ $roleName }}</div>
        </div>
    </aside>

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <main class="main">
        <header class="topbar">
            <div class="topbar-left">
                <button type="button" class="menu-toggle" id="menuToggle"
                    aria-label="Buka navigasi" aria-expanded="false">☰</button>
                <div>
                    <p class="breadcrumb">RAPI-Sekolah / <span>Profil</span></p>
                    <h1 class="topbar-title">Profil Saya</h1>
                </div>
            </div>

            <div class="topbar-right">
                <div class="date-display" id="todayLabel"></div>

                <div class="profile">
                    <div class="profile-avatar">
                        @if($user->profile_photo)
                            <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="Foto profil">
                        @else
                            {{ strtoupper(substr($user->fullname ?? 'P', 0, 1)) }}
                        @endif
                    </div>

                    <div class="profile-text">
                        <p class="profile-name">{{ $user->fullname }}</p>
                        <span class="profile-role">{{ $roleName }}</span>
                    </div>

                    <form action="{{ route('logout') }}" method="POST" class="logout-form"
                        onsubmit="return confirm('Yakin ingin logout?')">
                        @csrf
                        <button type="submit" class="logout-button">Logout</button>
                    </form>
                </div>
            </div>
        </header>

        <section class="page-intro">
            <h2>Pengaturan Profil</h2>
            <p>
                Perbarui informasi pribadi dan keamanan akun Anda.
                Hak akses pengguna tetap dikelola oleh Administrator.
            </p>
        </section>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <strong>Periksa kembali data yang dimasukkan:</strong>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <section class="section">
            <div class="section-heading">
                <h2>Informasi Akun</h2>
                <p class="section-description">Kelola identitas dan informasi kontak akun Anda.</p>
            </div>

            <div class="card">
                <div class="card-header">Informasi Profil</div>
                <div class="card-body">

                    <div class="user-heading">
                        <div class="large-avatar">
                            @if($user->profile_photo)
                                <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="Foto profil">
                            @else
                                {{ strtoupper(substr($user->fullname ?? 'P', 0, 1)) }}
                            @endif
                        </div>
                        <div>
                            <h3>{{ $user->fullname }}</h3>
                            <p>{{ '@' . $user->username }}</p>
                            <span class="role-badge">{{ $roleName }}</span>
                        </div>
                    </div>

                    <form action="{{ route('profile.update') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label" for="fullname">Nama Lengkap</label>
                                <input class="form-control" id="fullname" type="text"
                                    name="fullname" value="{{ old('fullname', $user->fullname) }}" required>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="username">Username</label>
                                <input class="form-control" id="username" type="text"
                                    name="username" value="{{ old('username', $user->username) }}" required>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="email">Email</label>
                                <input class="form-control" id="email" type="email"
                                    name="email" value="{{ old('email', $user->email) }}" required>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="phone_number">Nomor HP</label>
                                <input class="form-control" id="phone_number" type="text"
                                    name="phone_number" value="{{ old('phone_number', $user->phone_number) }}" required>
                            </div>

                            <div class="form-group full">
                                <label class="form-label" for="profile_photo">Foto Profil</label>
                                <input class="form-control" id="profile_photo" type="file"
                                    name="profile_photo" accept=".jpg,.jpeg,.png,.webp">
                                <span class="form-help">Format JPG, JPEG, PNG, atau WEBP. Maksimal 2 MB.</span>
                            </div>

                            <div class="form-group full">
                                <label class="form-label" for="role">Role / Hak Akses</label>
                                <input class="form-control" id="role" type="text"
                                    value="{{ $roleName }}" readonly>
                                <span class="form-help">Hak akses tidak dapat diubah melalui halaman profil.</span>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>

        <section class="section">
            <div class="section-heading">
                <h2>Keamanan Akun</h2>
                <p class="section-description">Ubah password akun secara terpisah dari informasi profil.</p>
            </div>

            <div class="card">
                <div class="card-header">Ubah Password</div>
                <div class="card-body">
                    <p class="password-note">
                        Masukkan password saat ini, kemudian tentukan password baru minimal 8 karakter.
                    </p>

                    <form action="{{ route('profile.password') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-grid">
                            <div class="form-group full">
                                <label class="form-label" for="current_password">Password Saat Ini</label>
                                <input class="form-control" id="current_password" type="password"
                                    name="current_password" autocomplete="current-password" required>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="password">Password Baru</label>
                                <input class="form-control" id="password" type="password"
                                    name="password" minlength="8" autocomplete="new-password" required>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="password_confirmation">Konfirmasi Password Baru</label>
                                <input class="form-control" id="password_confirmation" type="password"
                                    name="password_confirmation" minlength="8" autocomplete="new-password" required>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-outline">Ubah Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>
</div>

<script>
    const sidebar = document.getElementById('sidebar');
    const menuToggle = document.getElementById('menuToggle');
    const overlay = document.getElementById('sidebarOverlay');

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

    document.getElementById('todayLabel').textContent =
        new Date().toLocaleDateString('id-ID', {
            weekday: 'long',
            day: 'numeric',
            month: 'long',
            year: 'numeric'
        });
</script>
</body>
</html>
