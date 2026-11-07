
@extends('layouts.app')

@section('title', 'Dashboard PIC')
@section('page-title', 'Dashboard PIC Ruang')

@section('content')

<section class="page-intro">
    <h2>Selamat datang, {{ auth()->user()->fullname ?? 'PIC Ruang' }}</h2>
    <p>
        Pantau laporan kerusakan fasilitas di ruangan tanggung jawab Anda,
        perbarui status penanganan, dan lihat agenda kegiatan sekolah.
    </p>
</section>

<section class="section">
    <div class="section-heading">
        <div>
            <h2>Statistik Laporan Penanganan</h2>
            <p class="section-description">
                Ringkasan pengaduan fasilitas di ruangan tanggung jawab Anda.
            </p>
        </div>
    </div>

    <div class="stats-grid">

        <article class="stat-card">
            <span class="stat-label">Belum Diperbaiki</span>
            <strong class="stat-number">{{ $pendingCount ?? 0 }}</strong>
            <p class="stat-note">Laporan yang belum ditangani</p>
        </article>

        <article class="stat-card">
            <span class="stat-label">Menunggu Spare Part</span>
            <strong class="stat-number">{{ $inProgressCount ?? 0 }}</strong>
            <p class="stat-note">Laporan dalam proses penanganan</p>
        </article>

        <article class="stat-card">
            <span class="stat-label">Sudah Diperbaiki</span>
            <strong class="stat-number">{{ $completedCount ?? 0 }}</strong>
            <p class="stat-note">Laporan yang telah diselesaikan</p>
        </article>

    </div>
</section>

<section class="section" id="pengaduan">
    <div class="section-heading">
        <div>
            <h2>Pengaduan Kerusakan Fasilitas</h2>
            <p class="section-description">
                Periksa laporan dan perbarui status penanganan kerusakan.
            </p>
        </div>
    </div>

    @include('pic.pengaduan')
</section>

@endsection
