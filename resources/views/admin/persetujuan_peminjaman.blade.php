
<div class="card border-0 shadow-sm rounded-3 mb-4">
    <div class="card-body">

        {{-- NOTIFIKASI BERHASIL --}}
        @if (session('approval_success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('approval_success') }}

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Tutup">
                </button>
            </div>
        @endif

        {{-- NOTIFIKASI GAGAL --}}
        @if (session('approval_error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                {{ session('approval_error') }}

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Tutup">
                </button>
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

                                                <button
                                                    type="submit"
                                                    class="btn btn-success btn-sm">
                                                    <i class="bi bi-check-lg me-1"></i>
                                                    ACC
                                                </button>
                                            </form>

                                            {{-- TOMBOL TOLAK --}}
                                            <form
                                                action="{{ route('admin.events.reject', ['id' => $event->events_id]) }}"
                                                method="POST"
                                                onsubmit="return confirm('Yakin ingin menolak pengajuan ini?')">

                                                @csrf
                                                @method('PUT')

                                                <button
                                                    type="submit"
                                                    class="btn btn-outline-danger btn-sm">
                                                    <i class="bi bi-x-lg me-1"></i>
                                                    Tolak
                                                </button>
                                            </form>

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
                <i
                    class="bi bi-inbox text-muted"
                    style="font-size: 3rem;">
                </i>

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
