
@extends('layouts.app')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard Admin')

@section('content')

{{-- INTRO --}}
<section class="page-intro">
    <h2>Selamat Datang, {{ auth()->user()->fullname ?? 'Admin' }}</h2>
    <p>
        Pantau aktivitas peminjaman ruangan, pengaduan kerusakan,
        dan pengelolaan fasilitas sekolah melalui dashboard ini.
    </p>
</section>

{{-- NOTIFIKASI --}}
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

{{-- STATISTIK --}}
<section class="section">
    <div class="section-heading">
        <div>
            <h2>Ringkasan Sistem</h2>
            <p class="section-description">
                Gambaran umum pengelolaan ruangan dan aktivitas sekolah.
            </p>
        </div>
    </div>

    <div class="stats-grid">

        <article class="stat-card">
            <span class="stat-label">Total Ruangan</span>
            <strong class="stat-number">{{ $totalRooms ?? 0 }}</strong>
            <p class="stat-note">Ruangan terdaftar</p>
        </article>

        <article class="stat-card">
            <span class="stat-label">Total Peminjaman</span>
            <strong class="stat-number">{{ $totalEvents ?? 0 }}</strong>
            <p class="stat-note">Seluruh agenda peminjaman</p>
        </article>

        <article class="stat-card">
            <span class="stat-label">Total Pengguna</span>
            <strong class="stat-number">{{ $totalUsers ?? 0 }}</strong>
            <p class="stat-note">Pengguna terdaftar</p>
        </article>

        <article class="stat-card">
            <span class="stat-label">Pengaduan Belum Selesai</span>
            <strong class="stat-number">{{ $pendingComplaints ?? 0 }}</strong>
            <p class="stat-note">Perlu tindak lanjut</p>
        </article>

    </div>
</section>

{{-- AGENDA HARI INI --}}
<section class="section">
    <div class="section-heading">
        <div>
            <h2>Agenda Ruangan Hari Ini</h2>
            <p class="section-description">
                Daftar kegiatan yang sudah disetujui untuk hari ini.
            </p>
        </div>
        <span class="section-index">{{ now()->format('d/m/Y') }}</span>
    </div>

    <div class="card">
        <div class="card-body">
            @if(isset($activeRoomUses) && $activeRoomUses->count() > 0)
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>Waktu</th>
                                <th>Nama Kegiatan</th>
                                <th>Ruangan</th>
                                <th>Peminjam</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($activeRoomUses as $event)
                                <tr>
                                    <td>
                                        {{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }}
                                        -
                                        {{ \Carbon\Carbon::parse($event->end_time)->format('H:i') }}
                                    </td>
                                    <td>{{ $event->event_name }}</td>
                                    <td>{{ $event->room->room_name ?? '-' }}</td>
                                    <td>{{ $event->applicant->fullname ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted mb-0">Belum ada agenda ruangan hari ini.</p>
            @endif
        </div>
    </div>
</section>

{{-- PERSETUJUAN PEMINJAMAN --}}
<section class="section">
    <div class="section-heading">
        <div>
            <h2>Menunggu Persetujuan</h2>
            <p class="section-description">
                Pengajuan peminjaman yang membutuhkan keputusan Admin.
            </p>
        </div>
        <span class="section-index">
            {{ isset($pendingApprovals) ? $pendingApprovals->count() : 0 }} pengajuan
        </span>
    </div>

    <div class="card">
        <div class="card-body">
            @if(isset($pendingApprovals) && $pendingApprovals->count() > 0)
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>Kegiatan</th>
                                <th>Peminjam</th>
                                <th>Ruangan</th>
                                <th>Tanggal</th>
                                <th>Waktu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendingApprovals as $event)
                                <tr>
                                    <td>{{ $event->event_name }}</td>
                                    <td>{{ $event->applicant->fullname ?? '-' }}</td>
                                    <td>{{ $event->room->room_name ?? '-' }}</td>
                                    <td>{{ $event->date }}</td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }}
                                        -
                                        {{ \Carbon\Carbon::parse($event->end_time)->format('H:i') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted mb-0">Tidak ada pengajuan yang menunggu persetujuan.</p>
            @endif
        </div>
    </div>
</section>

{{-- PENGADUAN BELUM SELESAI --}}
<section class="section">
    <div class="section-heading">
        <div>
            <h2>Pengaduan Belum Selesai</h2>
            <p class="section-description">
                Laporan kerusakan yang masih membutuhkan penanganan.
            </p>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            @php
                $unresolvedReports = isset($pendingReports)
                    ? $pendingReports->where('status_repair', '!=', 'Sudah Diperbaiki')
                    : collect();
            @endphp

            @if($unresolvedReports->count() > 0)
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>Ruangan</th>
                                <th>Pelapor</th>
                                <th>Kerusakan</th>
                                <th>Status</th>
                                <th>Tanggal Laporan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($unresolvedReports as $report)
                                <tr>
                                    <td>{{ $report->room->room_name ?? '-' }}</td>
                                    <td>{{ $report->reporter->fullname ?? '-' }}</td>
                                    <td>{{ $report->description }}</td>
                                    <td>{{ $report->status_repair }}</td>
                                    <td>{{ $report->reported_at ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted mb-0">Semua pengaduan sudah diselesaikan.</p>
            @endif
        </div>
    </div>
</section>

{{-- AKTIVITAS TERBARU --}}
<section class="section">
    <div class="section-heading">
        <div>
            <h2>Aktivitas Peminjaman Terbaru</h2>
            <p class="section-description">
                Riwayat pengajuan peminjaman yang terakhir dibuat.
            </p>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            @if(isset($recentEvents) && $recentEvents->count() > 0)
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>Kegiatan</th>
                                <th>Peminjam</th>
                                <th>Ruangan</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentEvents as $event)
                                <tr>
                                    <td>{{ $event->event_name }}</td>
                                    <td>{{ $event->applicant->fullname ?? '-' }}</td>
                                    <td>{{ $event->room->room_name ?? '-' }}</td>
                                    <td>{{ $event->date }}</td>
                                    <td>{{ ucfirst($event->status) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted mb-0">Belum ada aktivitas peminjaman.</p>
            @endif
        </div>
    </div>
</section>

@endsection
