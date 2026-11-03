
{{-- LAPORAN KERUSAKAN FASILITAS --}}
<section id="kerusakan" class="card">

    {{-- HEADER --}}
    <div class="card-header">
        <h3>
            <i class="fas fa-tools"></i>
            Laporan Kerusakan Fasilitas
        </h3>
        <p>
            Laporkan fasilitas sekolah yang rusak agar dapat segera ditindaklanjuti.
        </p>
    </div>

    <div class="card-body">

        {{-- PESAN ERROR --}}
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        {{-- PESAN SUKSES --}}
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        {{-- PESAN VALIDASI --}}
        @if($errors->any())
            <div class="alert alert-danger">
                <strong>Periksa kembali formulir:</strong>

                <ul style="padding-left: 20px; margin-top: 8px;">
                    @foreach($errors->all() as $error)
                        <li style="margin-bottom: 4px;">
                            {{ $error }}
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- FORM LAPORAN --}}
        <form
            action="{{ route('complaints.store') }}"
            method="POST"
            enctype="multipart/form-data"
        >
            @csrf

            {{-- PILIH RUANGAN --}}
            <div class="form-group">
                <label for="room_id">
                    Ruangan <span style="color: #c0392b;">*</span>
                </label>

                <select name="room_id" id="room_id" required>
                    <option value="">-- Pilih Ruangan --</option>

                    @forelse($rooms ?? [] as $room)
                        <option
                            value="{{ $room->id }}"
                            {{ old('room_id') == $room->id ? 'selected' : '' }}
                        >
                            {{ $room->room_name }}
                        </option>
                    @empty
                        <option value="" disabled>
                            Belum ada data ruangan
                        </option>
                    @endforelse
                </select>

                @error('room_id')
                    <small style="color: #c0392b;">{{ $message }}</small>
                @enderror

                <small class="form-help">
                    Pilih ruangan tempat fasilitas mengalami kerusakan.
                </small>
            </div>

            {{-- DESKRIPSI KERUSAKAN --}}
            <div class="form-group">
                <label for="description">
                    Deskripsi Kerusakan
                    <span style="color: #c0392b;">*</span>
                </label>

                <textarea
                    name="description"
                    id="description"
                    rows="4"
                    maxlength="2000"
                    required
                    placeholder="Jelaskan fasilitas yang rusak dan kondisi kerusakannya..."
                >{{ old('description') }}</textarea>

                @error('description')
                    <small style="color: #c0392b;">{{ $message }}</small>
                @enderror

                <small class="form-help">
                    Jelaskan bagian yang rusak dan kondisi yang ditemukan.
                </small>
            </div>

            {{-- FOTO KERUSAKAN --}}
            <div class="form-group">
                <label for="photo">
                    Foto Kerusakan
                </label>

                <input
                    type="file"
                    name="photo"
                    id="photo"
                    accept="image/*"
                >

                @error('photo')
                    <small style="color: #c0392b;">{{ $message }}</small>
                @enderror

                <small class="form-help">
                    Unggah foto sebagai bukti kerusakan fasilitas.
                </small>
            </div>

            {{-- INFORMASI --}}
            <div class="alert" style="
                background: #edf3fa;
                border: 1px solid #d5e2f1;
                color: #17365d;
            ">
                <strong>
                    <i class="fas fa-info-circle"></i>
                    Informasi:
                </strong>
                Pastikan ruangan dan deskripsi kerusakan sudah benar
                sebelum mengirim laporan.
            </div>

            {{-- TOMBOL KIRIM --}}
            <div style="
                display: flex;
                justify-content: flex-end;
                border-top: 1px solid var(--border);
                padding-top: 18px;
            ">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-paper-plane"></i>
                    Kirim Laporan
                </button>
            </div>

        </form>

    </div>
</section>
