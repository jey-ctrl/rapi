
{{-- STATUS PEMINJAMAN RUANG --}}
<section id="status-ruang" class="card">

    {{-- HEADER --}}
    <div class="card-header">
        <h3>
            <i class="fas fa-calendar-check"></i>
            Status Peminjaman Ruangan
        </h3>
        <p>Pantau status pengajuan peminjaman ruangan.</p>
    </div>

    {{-- TABEL STATUS --}}
    <div class="card-body">
        <div class="table-responsive">

            <table>
                <thead>
                    <tr>
                        <th>Nama Kegiatan</th>
                        <th>Ruangan</th>
                        <th>Tanggal</th>
                        <th>Waktu</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($myEvents ?? [] as $event)

                        <tr>

                            {{-- NAMA KEGIATAN --}}
                            <td>
                                <strong>{{ $event->event_name }}</strong>
                            </td>

                            {{-- RUANGAN --}}
                            <td style="white-space: nowrap;">
                                {{ $event->room->room_name ?? 'Ruangan tidak ditemukan' }}
                            </td>

                            {{-- TANGGAL --}}
                            <td style="white-space: nowrap;">
                                {{ $event->date
                                    ? \Carbon\Carbon::parse($event->date)->format('d M Y')
                                    : '-' }}
                            </td>

                            {{-- WAKTU --}}
                            <td style="white-space: nowrap;">
                                {{ $event->start_time
                                    ? substr((string) $event->start_time, 0, 5)
                                    : '--:--' }}

                                -

                                {{ $event->end_time
                                    ? substr((string) $event->end_time, 0, 5)
                                    : '--:--' }}
                            </td>

                            {{-- STATUS --}}
                            <td style="white-space: nowrap;">

                                @if($event->status === 'approved')

                                    <span class="badge bg-success">
                                        <i class="fas fa-check-circle"></i>
                                        Disetujui
                                    </span>

                                @elseif($event->status === 'rejected')

                                    <span class="badge bg-danger">
                                        <i class="fas fa-times-circle"></i>
                                        Ditolak
                                    </span>

                                @else

                                    <span class="badge bg-warning">
                                        <i class="fas fa-clock"></i>
                                        Menunggu
                                    </span>

                                @endif

                            </td>

                        </tr>

                    @empty

                        {{-- DATA KOSONG --}}
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 35px;">

                                <i class="fas fa-calendar-xmark"
                                   style="font-size: 28px; color: var(--muted); margin-bottom: 12px;">
                                </i>

                                <strong style="display: block; margin-bottom: 7px;">
                                    Belum Ada Pengajuan
                                </strong>

                                <span style="color: var(--muted); font-size: 12px;">
                                    Belum ada pengajuan peminjaman ruangan.
                                </span>

                            </td>
                        </tr>

                    @endforelse

                </tbody>
            </table>

        </div>
    </div>

    {{-- KETERANGAN STATUS --}}
    <div style="
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        padding: 0 22px 20px;
        font-size: 11px;
        color: var(--muted);
    ">

        <span>
            <span class="badge bg-success">
                <i class="fas fa-check-circle"></i>
                Disetujui
            </span>
        </span>

        <span>
            <span class="badge bg-warning">
                <i class="fas fa-clock"></i>
                Menunggu
            </span>
        </span>

        <span>
            <span class="badge bg-danger">
                <i class="fas fa-times-circle"></i>
                Ditolak
            </span>
        </span>

    </div>

</section>
