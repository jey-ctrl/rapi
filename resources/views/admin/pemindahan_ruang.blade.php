
@extends('layouts.app')

@section('title', 'Pemindahan Ruangan')
@section('page-title', 'Pemindahan Ruangan')

@push('styles')
<style>
    .move-page-intro {
        margin-bottom: 22px;
    }

    .move-page-intro h2 {
        color: #17365d;
        font-size: 21px;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .move-page-intro p {
        color: #707985;
        font-size: 12px;
        margin: 0;
    }

    .move-icon {
        width: 44px;
        height: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        background: #f0fdf4;
        color: #16a34a;
        font-size: 18px;
    }

    .move-table th {
        background: #f8fafc;
        color: #475467;
        font-size: 11px;
        font-weight: 700;
        white-space: nowrap;
        padding: 14px 12px;
    }

    .move-table td {
        padding: 14px 12px;
        font-size: 12px;
        vertical-align: middle;
    }

    .move-table .event-name {
        color: #263445;
        font-weight: 700;
        margin-bottom: 4px;
    }

    .move-table .event-id {
        color: #98a2b3;
        font-size: 10px;
    }

    .room-badge {
        display: inline-block;
        padding: 7px 12px;
        border-radius: 20px;
        background: #eff6ff;
        color: #1d4ed8;
        font-size: 11px;
        font-weight: 600;
        white-space: nowrap;
    }

    .status-badge {
        display: inline-block;
        padding: 6px 11px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 700;
        white-space: nowrap;
    }

    .status-approved {
        background: #dcfce7;
        color: #166534;
    }

    .status-rejected {
        background: #fee2e2;
        color: #991b1b;
    }

    .status-pending {
        background: #fef3c7;
        color: #92400e;
    }

    .move-action-btn {
        display: inline-block;
        padding: 8px 13px;
        border-radius: 7px;
        background: #198754;
        color: white;
        font-size: 11px;
        font-weight: 600;
        text-decoration: none;
        white-space: nowrap;
    }

    .move-action-btn:hover {
        background: #157347;
        color: white;
    }

    .move-empty {
        padding: 45px 20px !important;
        text-align: center;
    }

    .move-empty i {
        font-size: 38px;
        color: #cbd5e1;
        margin-bottom: 15px;
    }

    .move-empty h6 {
        color: #344054;
        font-weight: 700;
    }

    .move-empty p {
        color: #98a2b3;
        font-size: 11px;
    }

    .move-card-footer {
        padding: 14px 20px;
        border-top: 1px solid #eaecf0;
        color: #667085;
        font-size: 11px;
    }
</style>
@endpush

@section('content')

<div class="move-page-intro">
    <h2>Pemindahan Ruangan</h2>
    <p>
        Pilih agenda yang sudah disetujui untuk memindahkan ruangan.
    </p>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<section class="section">
    <div class="card">

        <div class="card-header">
            <div class="d-flex align-items-center gap-3">
                <div class="move-icon">
                    <i class="fas fa-exchange-alt"></i>
                </div>

                <div>
                    <h3 class="mb-1">Daftar Agenda</h3>
                    <p class="text-muted small mb-0">
                        Agenda yang tersedia untuk pemindahan ruangan.
                    </p>
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0 move-table">
                    <thead>
                        <tr>
                            <th class="ps-4">Nama Agenda</th>
                            <th>Ruangan Saat Ini</th>
                            <th>Tanggal &amp; Waktu</th>
                            <th>Status</th>
                            <th class="text-end pe-4">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($events as $event)
                            <tr>
                                <td class="ps-4" style="min-width:180px;">
                                    <div class="event-name">
                                        {{ $event->event_name }}
                                    </div>

                                    <div class="event-id">
                                        ID: #{{ $event->events_id }}
                                    </div>
                                </td>

                                <td style="min-width:150px;">
                                    <span class="room-badge">
                                        <i class="fas fa-door-open me-1"></i>
                                        {{ $event->room->room_name ?? 'Tanpa Ruangan' }}
                                    </span>
                                </td>

                                <td style="min-width:155px;">
                                    <div class="fw-semibold">
                                        {{ $event->date
                                            ? \Carbon\Carbon::parse($event->date)->format('d M Y')
                                            : 'Belum ditentukan' }}
                                    </div>

                                    <small class="text-muted">
                                        {{ $event->start_time
                                            ? substr((string) $event->start_time, 0, 5)
                                            : '--:--' }}
                                        -
                                        {{ $event->end_time
                                            ? substr((string) $event->end_time, 0, 5)
                                            : '--:--' }}
                                    </small>
                                </td>

                                <td>
                                    @if($event->status === 'approved')
                                        <span class="status-badge status-approved">
                                            <i class="fas fa-check-circle me-1"></i>
                                            Disetujui
                                        </span>

                                        @if($event->move_reason)
                                            <div class="small text-muted mt-2">
                                                <i class="fas fa-info-circle me-1"></i>
                                                Pernah dipindahkan
                                            </div>
                                        @endif

                                    @elseif($event->status === 'rejected')
                                        <span class="status-badge status-rejected">
                                            <i class="fas fa-times-circle me-1"></i>
                                            Ditolak
                                        </span>

                                    @elseif($event->status === 'pending')
                                        <span class="status-badge status-pending">
                                            <i class="fas fa-clock me-1"></i>
                                            Menunggu
                                        </span>

                                    @else
                                        <span class="status-badge">
                                            {{ $event->status ?? 'Tidak diketahui' }}
                                        </span>
                                    @endif
                                </td>

                                <td class="text-end pe-4">
                                    @if($event->status === 'approved')
                                        <a
                                            href="{{ route('admin.events.move.form', $event->events_id) }}"
                                            class="move-action-btn"
                                        >
                                            <i class="fas fa-exchange-alt me-1"></i>
                                            Pindah Ruang
                                        </a>

                                    @elseif($event->status === 'rejected')
                                        <span class="text-muted small">
                                            Agenda ditolak
                                        </span>

                                    @elseif($event->status === 'pending')
                                        <span class="text-muted small">
                                            Menunggu persetujuan
                                        </span>

                                    @else
                                        <span class="text-muted small">
                                            Tidak tersedia
                                        </span>
                                    @endif
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="5" class="move-empty">
                                    <i class="fas fa-calendar-check d-block"></i>

                                    <h6>
                                        Belum Ada Agenda yang Disetujui
                                    </h6>

                                    <p class="mb-0">
                                        Agenda yang sudah disetujui Admin/Waka
                                        akan muncul di sini.
                                    </p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>

        <div class="move-card-footer">
            Total agenda:
            <strong>{{ $events->count() }}</strong>
        </div>

    </div>
</section>

@endsection
