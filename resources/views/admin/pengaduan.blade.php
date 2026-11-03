
{{-- resources/views/admin/pengaduan.blade.php --}}

<div class="card border-0 shadow-sm rounded-3 h-100">

    {{-- HEADER --}}
    <div class="card-header bg-white py-3 d-flex flex-wrap align-items-center justify-content-between gap-2">
        <div>
            <h6 class="mb-1 fw-bold text-dark">
                <i class="fas fa-tools me-2 text-danger"></i>
                Monitoring Pengaduan Kerusakan
            </h6>

            <small class="text-muted">
                Pantau laporan dan progres perbaikan fasilitas
            </small>
        </div>

        @if(Route::has('complaints.index'))
            <a href="{{ route('complaints.index') }}"
               class="btn btn-sm btn-outline-danger">
                <i class="fas fa-list me-1"></i>
                Lihat Semua
            </a>
        @endif
    </div>

    {{-- NOTIFIKASI --}}
    @if(session('success'))
        <div class="alert alert-success mx-3 mt-3 mb-0">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger mx-3 mt-3 mb-0">
            <i class="fas fa-exclamation-circle me-2"></i>
            {{ session('error') }}
        </div>
    @endif

    {{-- TABEL PENGADUAN --}}
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">

                <thead class="table-light">
                    <tr>
                        <th class="ps-3">Ruangan</th>
                        <th>Pelapor</th>
                        <th>Kerusakan</th>
                        <th>Foto</th>
                        <th>Status</th>
                        <th class="text-end pe-3">Teguran WA</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse(($complaints ?? $recentComplaints ?? collect()) as $complaint)
                        <tr>
                            {{-- RUANGAN --}}
                            <td class="ps-3">
                                <div class="fw-semibold text-dark">
                                    {{ $complaint->room->room_name ?? 'Ruangan tidak ditemukan' }}
                                </div>
                            </td>

                            {{-- PELAPOR --}}
                            <td>
                                <small class="text-dark">
                                    {{ $complaint->reporter->fullname
                                        ?? $complaint->reporter->name
                                        ?? 'Anonim' }}
                                </small>
                            </td>

                            {{-- DESKRIPSI --}}
                            <td>
                                <span
                                    class="d-inline-block text-muted"
                                    style="max-width: 180px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"
                                    title="{{ $complaint->description ?? '-' }}">

                                    {{ $complaint->description ?? 'Tidak ada deskripsi' }}
                                </span>
                            </td>

                            {{-- FOTO --}}
                            <td>
                                @if($complaint->photo_path)
                                    <a
                                        href="{{ asset('storage/' . $complaint->photo_path) }}"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="btn btn-sm btn-light border"
                                        title="Lihat foto kerusakan">

                                        <i class="fas fa-image text-primary"></i>
                                    </a>
                                @else
                                    <span class="text-muted small">
                                        Tidak ada foto
                                    </span>
                                @endif
                            </td>

                            {{-- STATUS --}}
                            <td>
                                @php
                                    $status = $complaint->status_repair ?? 'Pending';
                                @endphp

                                @if($status === 'Belum Diperbaiki')
                                    <span class="badge bg-danger">
                                        Belum Diperbaiki
                                    </span>
                                @elseif($status === 'Menunggu Spare Part')
                                    <span class="badge bg-warning text-dark">
                                        Menunggu Spare Part
                                    </span>
                                @elseif($status === 'Sudah Diperbaiki')
                                    <span class="badge bg-success">
                                        <i class="fas fa-check me-1"></i>
                                        Selesai
                                    </span>
                                @else
                                    <span class="badge bg-secondary">
                                        {{ $status }}
                                    </span>
                                @endif
                            </td>

                            {{-- TEGURAN WHATSAPP --}}
                            <td class="text-end pe-3">
                                @if($status !== 'Sudah Diperbaiki')
                                    @if(Route::has('admin.complaints.warn'))
                                        <a
                                            href="{{ route('admin.complaints.warn', $complaint->complaint_id ?? $complaint->id) }}"
                                            class="btn btn-sm btn-success fw-semibold"
                                            title="Tegur PIC melalui WhatsApp">

                                            <i class="fab fa-whatsapp me-1"></i>
                                            Tegur
                                        </a>
                                    @else
                                        <span class="text-muted small">
                                            Route belum tersedia
                                        </span>
                                    @endif
                                @else
                                    <span class="text-success small">
                                        <i class="fas fa-check-circle me-1"></i>
                                        Selesai
                                    </span>
                                @endif
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="fas fa-clipboard-check fa-2x text-muted mb-3"></i>

                                <p class="text-muted mb-1">
                                    Tidak ada laporan kerusakan aktif.
                                </p>

                                <small class="text-muted">
                                    Laporan baru akan muncul di bagian ini.
                                </small>
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>

    {{-- FOOTER --}}
    <div class="card-footer bg-white border-top py-3">
        <small class="text-muted">
            Total laporan yang ditampilkan:
            <strong>
                {{ isset($complaints)
                    ? $complaints->count()
                    : (isset($recentComplaints) ? $recentComplaints->count() : 0) }}
            </strong>
        </small>
    </div>

</div>
