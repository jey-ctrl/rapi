
{{-- resources/views/admin/pemindahan_ruang.blade.php --}}

<div class="card border-0 shadow-sm rounded-4 overflow-hidden">

    {{-- Header --}}
    <div class="card-header bg-white p-4 border-bottom">
        <div class="d-flex align-items-center gap-3">

            <div
                class="rounded-3 d-flex align-items-center justify-content-center text-success"
                style="width:48px;height:48px;background:#f0fdf4;"
            >
                <i class="fas fa-exchange-alt fs-5"></i>
            </div>

            <div>
                <h5 class="fw-bold mb-1">Agenda</h5>
                <p class="text-muted small mb-0">
                    Pilih agenda yang sudah disetujui untuk memindahkan ruangan.
                </p>
            </div>

        </div>
    </div>

    {{-- Notifikasi --}}
    <div class="p-4 pb-0">

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Tutup"
                ></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                {{ session('error') }}

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Tutup"
                ></button>
            </div>
        @endif

    </div>

    {{-- Tabel agenda --}}
    <div class="card-body p-0">
        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead style="background:#f8fafc;">
                    <tr>
                        <th class="ps-4 py-3">Nama Agenda</th>
                        <th class="py-3">Ruangan Saat Ini</th>
                        <th class="py-3">Tanggal &amp; Waktu</th>
                        <th class="py-3">Status</th>
                        <th class="pe-4 py-3 text-end">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($events as $event)

                        <tr>

                            {{-- Nama agenda --}}
                            <td class="ps-4" style="min-width:180px;">
                                <div class="fw-bold text-dark">
                                    {{ $event->event_name }}
                                </div>

                                <small class="text-muted">
                                    ID: #{{ $event->events_id }}
                                </small>
                            </td>

                            {{-- Ruangan saat ini --}}
                            <td style="min-width:150px;">
                                <span
                                    class="badge rounded-pill px-3 py-2"
                                    style="background:#eff6ff;color:#1d4ed8;"
                                >
                                    <i class="fas fa-door-open me-1"></i>
                                    {{ $event->room->room_name ?? 'Tanpa Ruangan' }}
                                </span>
                            </td>

                            {{-- Tanggal dan waktu --}}
                            <td style="min-width:160px;">
                                <div class="fw-medium">
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

                            {{-- Status agenda --}}
                            <td>
                                @if($event->status === 'approved')

                                    <span
                                        class="badge rounded-pill px-3 py-2"
                                        style="background:#dcfce7;color:#166534;"
                                    >
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

                                    <span class="badge bg-danger rounded-pill px-3 py-2">
                                        <i class="fas fa-times-circle me-1"></i>
                                        Ditolak
                                    </span>

                                @elseif($event->status === 'pending')

                                    <span class="badge bg-warning text-dark rounded-pill px-3 py-2">
                                        <i class="fas fa-clock me-1"></i>
                                        Menunggu
                                    </span>

                                @else

                                    <span class="badge bg-secondary rounded-pill px-3 py-2">
                                        {{ $event->status ?? 'Tidak diketahui' }}
                                    </span>

                                @endif
                            </td>

                            {{-- Tombol aksi --}}
                            <td class="pe-4 text-end">

                                @if($event->status === 'approved')

                                    <a
                                        href="{{ route('admin.events.move.form', $event->events_id) }}"
                                        class="btn btn-success rounded-3 px-3 py-2 text-nowrap"
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
                            <td colspan="5" class="text-center py-5">

                                <i
                                    class="fas fa-calendar-check text-muted mb-3"
                                    style="font-size:40px;"
                                ></i>

                                <h6 class="fw-bold">
                                    Belum Ada Agenda yang Disetujui
                                </h6>

                                <p class="text-muted small mb-0">
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

    {{-- Footer --}}
    <div class="card-footer bg-white px-4 py-3">
        <small class="text-muted">
            Total agenda:
            <strong>{{ $events->count() }}</strong>
        </small>
    </div>

</div>
