{{-- PENGADUAN KERUSAKAN --}}
<div id="pengaduan" class="card">

    {{-- HEADER --}}
    <div class="card-header">
        <div>
            <h3>Pengaduan Kerusakan Fasilitas Ruangan</h3>
            <p>Perbarui status penanganan kerusakan fasilitas sekolah.</p>
        </div>
    </div>

    {{-- ALERT SUCCESS --}}
    @if(session('success'))
        <div class="alert alert-success" style="margin: 20px;">
            {{ session('success') }}
        </div>
    @endif

    {{-- ALERT ERROR --}}
    @if($errors->any())
        <div class="alert alert-danger" style="margin: 20px;">
            {{ $errors->first() }}
        </div>
    @endif

    {{-- TABLE --}}
    <div class="card-body">
        <div class="table-responsive">

            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tgl Lapor</th>
                        <th>Ruangan</th>
                        <th>Pelapor</th>
                        <th>Deskripsi</th>
                        <th>Foto</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($myComplaints as $index => $complaint)

                        <tr>
                            {{-- NOMOR --}}
                            <td>
                                {{ $index + 1 }}
                            </td>

                            {{-- TANGGAL --}}
                            <td style="white-space: nowrap;">
                                {{ $complaint->created_at->format('d-m-Y H:i') }}
                            </td>

                            {{-- RUANGAN --}}
                            <td>
                                <strong>
                                    {{ $complaint->room->room_name ?? '-' }}
                                </strong>
                            </td>

                            {{-- PELAPOR --}}
                            <td>
                                {{ $complaint->reporter->fullname ?? '-' }}
                            </td>

                            {{-- DESKRIPSI --}}
                            <td style="min-width: 200px;">
                                {{ $complaint->description }}
                            </td>

                            {{-- FOTO --}}
                            <td>
                                @if($complaint->photo_path)

                                    <a
                                        href="{{ asset('storage/' . $complaint->photo_path) }}"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="btn btn-primary btn-sm"
                                    >
                                        Lihat Foto
                                    </a>

                                @else

                                    <span style="color: #707985;">
                                        Tanpa Foto
                                    </span>

                                @endif
                            </td>

                            {{-- STATUS --}}
                            <td style="white-space: nowrap;">

                                @if($complaint->status_repair == 'Belum Diperbaiki')

                                    <span class="badge bg-danger">
                                        Belum Diperbaiki
                                    </span>

                                @elseif($complaint->status_repair == 'Menunggu Spare Part')

                                    <span class="badge bg-warning">
                                        Menunggu Spare Part
                                    </span>

                                @elseif($complaint->status_repair == 'Sudah Diperbaiki')

                                    <span class="badge bg-success">
                                        Sudah Diperbaiki
                                    </span>

                                @else

                                    <span class="badge bg-secondary">
                                        {{ $complaint->status_repair }}
                                    </span>

                                @endif

                            </td>

                            {{-- UPDATE STATUS --}}
                            <td style="min-width: 180px;">

                                <form
                                    action="{{ route('pic.complaints.update', $complaint->id) }}"
                                    method="POST"
                                >
                                    @csrf
                                    @method('PUT')

                                    <select
                                        name="status_repair"
                                        required
                                        style="width: 100%; margin-bottom: 8px;"
                                    >
                                        <option
                                            value="Belum Diperbaiki"
                                            {{ $complaint->status_repair == 'Belum Diperbaiki' ? 'selected' : '' }}
                                        >
                                            Belum Diperbaiki
                                        </option>

                                        <option
                                            value="Menunggu Spare Part"
                                            {{ $complaint->status_repair == 'Menunggu Spare Part' ? 'selected' : '' }}
                                        >
                                            Menunggu Spare Part
                                        </option>

                                        <option
                                            value="Sudah Diperbaiki"
                                            {{ $complaint->status_repair == 'Sudah Diperbaiki' ? 'selected' : '' }}
                                        >
                                            Sudah Diperbaiki
                                        </option>
                                    </select>

                                    <button
                                        type="submit"
                                        class="btn btn-primary btn-sm"
                                        style="width: 100%;"
                                    >
                                        Simpan Status
                                    </button>

                                </form>

                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="8" style="text-align: center; padding: 30px;">
                                Belum ada pengaduan kerusakan di ruangan tanggung jawab Anda.
                            </td>
                        </tr>

                    @endforelse
                </tbody>

            </table>

        </div>
    </div>

</div>