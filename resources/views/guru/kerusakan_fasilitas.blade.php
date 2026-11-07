
{{-- FORM LAPORAN KERUSAKAN FASILITAS --}}
<div id="form-laporan-kerusakan" class="card guru-complaint-card">

    <div class="card-header guru-complaint-header">
        <div class="guru-header-icon">
            <i class="fas fa-tools"></i>
        </div>

        <div class="guru-header-content">
            <h3>Formulir Pelaporan Kerusakan</h3>
            <p>Laporkan fasilitas sekolah yang rusak agar dapat segera ditindaklanjuti.</p>
        </div>
    </div>

    <div class="card-body guru-complaint-body">

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
            <div class="alert alert-danger guru-validation-alert">
                <strong>Periksa kembali formulir:</strong>

                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form
            action="{{ route('complaints.store') }}"
            method="POST"
            enctype="multipart/form-data"
            class="guru-complaint-form"
        >
            @csrf

            {{-- PILIH RUANGAN --}}
            <div class="guru-form-group">
                <label for="room_id">
                    Ruangan <span class="required-mark">*</span>
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
                    <small class="guru-field-error">{{ $message }}</small>
                @enderror

                <small class="guru-form-help">
                    Pilih ruangan tempat fasilitas mengalami kerusakan.
                </small>
            </div>

            {{-- DESKRIPSI KERUSAKAN --}}
            <div class="guru-form-group">
                <label for="description">
                    Deskripsi Kerusakan <span class="required-mark">*</span>
                </label>

                <textarea
                    name="description"
                    id="description"
                    rows="5"
                    maxlength="2000"
                    required
                    placeholder="Jelaskan fasilitas yang rusak dan kondisi kerusakannya..."
                >{{ old('description') }}</textarea>

                @error('description')
                    <small class="guru-field-error">{{ $message }}</small>
                @enderror

                <small class="guru-form-help">
                    Jelaskan bagian yang rusak, kondisi kerusakan, dan informasi lain yang diperlukan.
                </small>
            </div>

            {{-- FOTO KERUSAKAN --}}
            <div class="guru-form-group">
                <label for="photo">Foto Kerusakan</label>

                <div class="guru-upload-area">
                    <div class="guru-upload-icon">
                        <i class="fas fa-cloud-upload-alt"></i>
                    </div>

                    <div class="guru-upload-content">
                        <strong>Unggah Foto Kerusakan</strong>
                        <span>Pilih foto dari perangkat kamu sebagai bukti kerusakan fasilitas.</span>
                    </div>

                    <input
                        type="file"
                        name="photo"
                        id="photo"
                        accept="image/*"
                    >
                </div>

                @error('photo')
                    <small class="guru-field-error">{{ $message }}</small>
                @enderror

                <small class="guru-form-help">
                    Gunakan foto yang jelas agar kerusakan mudah diperiksa.
                </small>
            </div>

            {{-- INFORMASI --}}
            <div class="guru-information">
                <i class="fas fa-info-circle"></i>

                <div>
                    <strong>Informasi</strong>
                    <p>
                        Pastikan ruangan dan deskripsi kerusakan sudah benar
                        sebelum mengirim laporan.
                    </p>
                </div>
            </div>

            {{-- TOMBOL KIRIM --}}
            <div class="guru-form-footer">
                <button type="submit" class="btn btn-primary guru-submit-button">
                    <i class="fas fa-paper-plane"></i>
                    Kirim Laporan
                </button>
            </div>

        </form>
    </div>
</div>

<style>
    /* CARD UTAMA */
    #form-laporan-kerusakan {
        width: 100%;
        overflow: hidden;
        border: 1px solid #e2e8f0;
        border-radius: 9px;
        background: #fff;
    }

    /* HEADER */
    #form-laporan-kerusakan .guru-complaint-header {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 22px 24px;
        border-bottom: 1px solid #e8edf3;
    }

    #form-laporan-kerusakan .guru-header-icon {
        width: 44px;
        height: 44px;
        min-width: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 9px;
        background: #edf3fa;
        color: #17365d;
        font-size: 19px;
    }

    #form-laporan-kerusakan .guru-header-content h3 {
        margin: 0 0 5px;
        color: #17365d;
        font-size: 16px;
        font-weight: 700;
    }

    #form-laporan-kerusakan .guru-header-content p {
        margin: 0;
        color: #718096;
        font-size: 12px;
        line-height: 1.6;
    }

    /* BODY */
    #form-laporan-kerusakan .guru-complaint-body {
        padding: 26px 24px;
    }

    #form-laporan-kerusakan .guru-complaint-form {
        width: 100%;
    }

    /* FORM GROUP */
    #form-laporan-kerusakan .guru-form-group {
        margin-bottom: 23px;
    }

    #form-laporan-kerusakan .guru-form-group label {
        display: block;
        margin-bottom: 9px;
        color: #26374a;
        font-size: 13px;
        font-weight: 650;
    }

    #form-laporan-kerusakan .required-mark {
        color: #dc3545;
    }

    /* INPUT DAN SELECT */
    #form-laporan-kerusakan select,
    #form-laporan-kerusakan textarea {
        display: block;
        width: 100%;
        box-sizing: border-box;
        border: 1px solid #d7dee8;
        border-radius: 7px;
        background: #fff;
        color: #26374a;
        font-family: inherit;
        font-size: 13px;
        transition: border-color .2s, box-shadow .2s;
    }

    #form-laporan-kerusakan select {
        height: 46px;
        padding: 0 13px;
        cursor: pointer;
    }

    #form-laporan-kerusakan textarea {
        min-height: 125px;
        padding: 13px 14px;
        line-height: 1.7;
        resize: vertical;
    }

    #form-laporan-kerusakan select:focus,
    #form-laporan-kerusakan textarea:focus {
        outline: none;
        border-color: #294e78;
        box-shadow: 0 0 0 3px rgba(41, 78, 120, .10);
    }

    #form-laporan-kerusakan select:hover,
    #form-laporan-kerusakan textarea:hover {
        border-color: #aebdce;
    }

    #form-laporan-kerusakan textarea::placeholder {
        color: #9aa5b3;
    }

    /* KETERANGAN INPUT */
    #form-laporan-kerusakan .guru-form-help {
        display: block;
        margin-top: 7px;
        color: #8491a2;
        font-size: 11px;
        line-height: 1.6;
    }

    #form-laporan-kerusakan .guru-field-error {
        display: block;
        margin-top: 6px;
        color: #c0392b;
        font-size: 12px;
    }

    /* UPLOAD FOTO */
    #form-laporan-kerusakan .guru-upload-area {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 17px;
        border: 1px dashed #b9c7d8;
        border-radius: 8px;
        background: #f8fafc;
        flex-wrap: wrap;
    }

    #form-laporan-kerusakan .guru-upload-icon {
        width: 42px;
        height: 42px;
        min-width: 42px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        background: #eaf0f7;
        color: #24476e;
        font-size: 18px;
    }

    #form-laporan-kerusakan .guru-upload-content {
        flex: 1;
        min-width: 180px;
    }

    #form-laporan-kerusakan .guru-upload-content strong {
        display: block;
        color: #344054;
        font-size: 12px;
        margin-bottom: 4px;
    }

    #form-laporan-kerusakan .guru-upload-content span {
        display: block;
        color: #8491a2;
        font-size: 11px;
        line-height: 1.5;
    }

    #form-laporan-kerusakan input[type="file"] {
        width: 100%;
        max-width: 100%;
        box-sizing: border-box;
        padding: 9px;
        border: 1px solid #d7dee8;
        border-radius: 6px;
        background: #fff;
        color: #667085;
        font-size: 12px;
    }

    /* INFORMASI */
    #form-laporan-kerusakan .guru-information {
        display: flex;
        align-items: flex-start;
        gap: 11px;
        padding: 15px 17px;
        margin: 8px 0 23px;
        border: 1px solid #d7e4f3;
        border-radius: 7px;
        background: #edf3fa;
        color: #24476e;
    }

    #form-laporan-kerusakan .guru-information > i {
        margin-top: 2px;
        font-size: 15px;
    }

    #form-laporan-kerusakan .guru-information strong {
        display: block;
        margin-bottom: 4px;
        font-size: 12px;
    }

    #form-laporan-kerusakan .guru-information p {
        margin: 0;
        font-size: 11px;
        line-height: 1.6;
    }

    /* VALIDASI */
    #form-laporan-kerusakan .guru-validation-alert ul {
        padding-left: 20px;
        margin: 8px 0 0;
    }

    #form-laporan-kerusakan .guru-validation-alert li {
        margin-bottom: 4px;
        font-size: 12px;
    }

    /* FOOTER DAN TOMBOL */
    #form-laporan-kerusakan .guru-form-footer {
        display: flex;
        justify-content: flex-end;
        padding-top: 19px;
        border-top: 1px solid #e8edf3;
    }

    #form-laporan-kerusakan .guru-submit-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 9px;
        min-width: 165px;
        min-height: 43px;
        padding: 10px 18px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 650;
        cursor: pointer;
    }

    #form-laporan-kerusakan .guru-submit-button:hover {
        filter: brightness(.95);
    }

    /* RESPONSIVE */
    @media (max-width: 768px) {
        #form-laporan-kerusakan .guru-complaint-header {
            padding: 17px;
        }

        #form-laporan-kerusakan .guru-complaint-body {
            padding: 19px 16px;
        }

        #form-laporan-kerusakan .guru-upload-area {
            align-items: flex-start;
        }

        #form-laporan-kerusakan .guru-submit-button {
            width: 100%;
        }

        #form-laporan-kerusakan .guru-form-footer {
            justify-content: stretch;
        }
    }
</style>
