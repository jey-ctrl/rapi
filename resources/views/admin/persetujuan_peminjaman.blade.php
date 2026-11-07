<div class="card border-0 shadow-sm rounded-3 mb-4">
    <div class="card-body">

        {{-- NOTIFIKASI BERHASIL --}}
        @if (session('approval_success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('approval_success') }}

            <button type="button" class="btn-close"
                data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
        @endif

        {{-- NOTIFIKASI GAGAL --}}
        @if (session('approval_error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            {{ session('approval_error') }}

            <button type="button" class="btn-close"
                data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
        @endif

        {{-- VALIDASI --}}
        @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            <strong>Terjadi kesalahan:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        {{-- DAFTAR PENGAJUAN --}}
        @if (isset($pendingApprovals) && $pendingApprovals->count() > 0)

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="text-center" style="width: 55px;">No.</th>
                        <th>ID Pengajuan</th>
                        <th>Nama Peminjam</th>
                        <th>Nama Agenda</th>
                        <th>Ruangan</th>
                        <th>Tanggal</th>
                        <th>Waktu</th>
                        <th>Status</th>
                        <th style="min-width: 145px;">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($pendingApprovals as $index => $event)
                    <tr>
                        {{-- NOMOR --}}
                        <td class="text-center">
                            {{ $index + 1 }}
                        </td>

                        {{-- ID PENGAJUAN --}}
                        <td>
                            <span class="fw-semibold">
                                {{ $event->events_id ?? '-' }}
                            </span>
                        </td>

                        {{-- NAMA PEMINJAM --}}
                        <td>
                            {{ $event->applicant->fullname ?? 'Pengguna tidak ditemukan' }}
                        </td>

                        {{-- NAMA AGENDA --}}
                        <td>
                            {{ $event->event_name ?? '-' }}
                        </td>

                        {{-- NAMA RUANGAN --}}
                        <td>
                            {{ $event->room->room_name ?? 'Ruangan tidak ditemukan' }}
                        </td>

                        {{-- TANGGAL --}}
                        <td>
                            @if ($event->date)
                            {{ \Carbon\Carbon::parse($event->date)->format('d-m-Y') }}
                            @else
                            -
                            @endif
                        </td>

                        {{-- WAKTU --}}
                        <td class="text-nowrap">
                            {{ $event->start_time
                                        ? \Carbon\Carbon::parse($event->start_time)->format('H:i')
                                        : '--:--' }}
                            -
                            {{ $event->end_time
                                        ? \Carbon\Carbon::parse($event->end_time)->format('H:i')
                                        : '--:--' }}
                        </td>

                        {{-- STATUS --}}
                        <td>
                            @if ($event->status === 'pending')
                            <span class="badge bg-warning text-dark">
                                Menunggu
                            </span>
                            @elseif ($event->status === 'approved')
                            <span class="badge bg-success">
                                Disetujui
                            </span>
                            @elseif ($event->status === 'rejected')
                            <span class="badge bg-danger">
                                Ditolak
                            </span>
                            @else
                            <span class="badge bg-secondary">
                                {{ $event->status ?? 'Tidak diketahui' }}
                            </span>
                            @endif
                        </td>

                        {{-- AKSI --}}
                        <td>
                            @if ($event->status === 'pending')
                            <div class="d-flex gap-2">

                                {{-- TOMBOL ACC --}}
                                <form
                                    action="{{ route('admin.events.approve', ['id' => $event->events_id]) }}"
                                    method="POST"
                                    onsubmit="return confirm('Yakin ingin menyetujui pengajuan ini?')">

                                    @csrf
                                    @method('PUT')

                                    <button type="submit"
                                        class="btn btn-success btn-sm">
                                        <i class="bi bi-check-lg me-1"></i>
                                        ACC
                                    </button>
                                </form>

                                {{-- TOMBOL TOLAK --}}
                                <button
                                    type="button"
                                    class="btn btn-outline-danger btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalTolak"
                                    data-id="{{ $event->events_id }}"
                                    data-peminjam="{{ $event->applicant->fullname ?? 'Pengguna tidak ditemukan' }}"
                                    data-agenda="{{ $event->event_name ?? '-' }}"
                                    data-ruangan="{{ $event->room->room_name ?? '-' }}"
                                    data-tanggal="{{ $event->date ? \Carbon\Carbon::parse($event->date)->format('d-m-Y') : '-' }}"
                                    data-waktu="{{ $event->start_time ? \Carbon\Carbon::parse($event->start_time)->format('H:i') : '--:--' }} - {{ $event->end_time ? \Carbon\Carbon::parse($event->end_time)->format('H:i') : '--:--' }}">

                                    <i class="bi bi-x-lg me-1"></i>
                                    Tolak
                                </button>

                            </div>
                            @else
                            <span class="text-muted small">
                                Sudah diproses
                            </span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @else

        {{-- JIKA BELUM ADA PENGAJUAN --}}
        <div class="text-center py-5">
            <i class="bi bi-inbox text-muted"
                style="font-size: 3rem;"></i>

            <h6 class="fw-semibold mt-3">
                Belum Ada Pengajuan
            </h6>

            <p class="text-muted mb-0">
                Belum ada pengajuan peminjaman yang menunggu persetujuan.
            </p>
        </div>

        @endif

    </div>
</div>


{{-- ====================================== --}}
{{-- MODAL PENOLAKAN PEMINJAMAN --}}
{{-- ====================================== --}}

<div class="modal fade" id="modalTolak" tabindex="-1"
    aria-labelledby="modalTolakLabel" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">

            <div class="modal-header bg-danger text-white">
                <div>
                    <h5 class="modal-title fw-bold" id="modalTolakLabel">
                        <i class="bi bi-x-circle me-2"></i>
                        Tolak Peminjaman
                    </h5>
                    <small>Periksa data sebelum menolak pengajuan.</small>
                </div>

                <button type="button"
                    class="btn-close btn-close-white"
                    data-bs-dismiss="modal"
                    aria-label="Tutup"></button>
            </div>

            <form id="formTolak" method="POST">
                @csrf
                @method('PUT')

                <div class="modal-body p-4">

                    <h6 class="fw-bold mb-3">Data Peminjaman</h6>

                    <div class="bg-light rounded-3 p-3 mb-4">

                        <div class="mb-2">
                            <small class="text-muted">ID Pengajuan</small>
                            <div class="fw-semibold" id="tolakId">-</div>
                        </div>

                        <div class="mb-2">
                            <small class="text-muted">Nama Peminjam</small>
                            <div class="fw-semibold" id="tolakPeminjam">-</div>
                        </div>

                        <div class="mb-2">
                            <small class="text-muted">Nama Kegiatan</small>
                            <div class="fw-semibold" id="tolakAgenda">-</div>
                        </div>

                        <div class="mb-2">
                            <small class="text-muted">Ruangan</small>
                            <div class="fw-semibold" id="tolakRuangan">-</div>
                        </div>

                        <div class="mb-2">
                            <small class="text-muted">Tanggal</small>
                            <div class="fw-semibold" id="tolakTanggal">-</div>
                        </div>

                        <div>
                            <small class="text-muted">Waktu</small>
                            <div class="fw-semibold" id="tolakWaktu">-</div>
                        </div>

                    </div>

                    <label for="rejection_reason" class="form-label fw-bold">
                        Alasan Penolakan
                        <span class="text-danger">*</span>
                    </label>

                    <textarea
                        name="rejection_reason"
                        id="rejection_reason"
                        class="form-control"
                        rows="4"
                        maxlength="1000"
                        placeholder="Tuliskan alasan penolakan peminjaman..."
                        required></textarea>

                    <small class="text-muted">
                        Alasan ini akan disimpan agar peminjam mengetahui
                        penyebab pengajuannya ditolak.
                    </small>

                </div>

                <div class="modal-footer border-0 px-4 pb-4">

                    <button type="button"
                        class="btn btn-light"
                        data-bs-dismiss="modal">
                        Batal
                    </button>

                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-x-circle me-1"></i>
                        Konfirmasi Penolakan
                    </button>

                </div>
            </form>

        </div>
    </div>
</div>


{{-- ====================================== --}}
{{-- JAVASCRIPT MODAL PENOLAKAN --}}
{{-- ====================================== --}}

<script>
    (function() {
        const modal = document.getElementById('modalTolak');

        if (!modal || modal.dataset.initialized === 'true') {
            return;
        }

        modal.dataset.initialized = 'true';

        document.addEventListener('click', function(event) {

            const button = event.target.closest(
                '[data-bs-target="#modalTolak"]'
            );

            if (!button) {
                return;
            }

            const id = button.getAttribute('data-id');

            document.getElementById('tolakId').textContent =
                id || '-';

            document.getElementById('tolakPeminjam').textContent =
                button.getAttribute('data-peminjam') || '-';

            document.getElementById('tolakAgenda').textContent =
                button.getAttribute('data-agenda') || '-';

            document.getElementById('tolakRuangan').textContent =
                button.getAttribute('data-ruangan') || '-';

            document.getElementById('tolakTanggal').textContent =
                button.getAttribute('data-tanggal') || '-';

            document.getElementById('tolakWaktu').textContent =
                button.getAttribute('data-waktu') || '-';

            document.getElementById('formTolak').action =
                "{{ url('/admin/events') }}/" +
                encodeURIComponent(id) + "/reject";

            document.getElementById('rejection_reason').value = '';

        });

    })();
</script>