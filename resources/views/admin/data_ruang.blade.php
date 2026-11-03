{{-- resources/views/admin/data_ruang.blade.php --}}

<div class="rooms-page">

    {{-- HEADER --}}
    <div class="rooms-header">
        <div>
            <h2 class="rooms-title">Kelola Data Ruangan</h2>
            <p class="rooms-subtitle">
                Kelola fasilitas ruangan dan penanggung jawabnya.
            </p>
        </div>

        <button type="button"
                class="rooms-button rooms-button-primary"
                data-rooms-open="rooms-add-modal">
            + Tambah Ruang
        </button>
    </div>

    {{-- NOTIFIKASI --}}
    @if (session('success'))
        <div class="rooms-alert rooms-alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="rooms-alert rooms-alert-error">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="rooms-alert rooms-alert-error">
            <strong>Data gagal disimpan:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- RINGKASAN --}}
    <div class="rooms-summary">

        <div class="rooms-summary-card">
            <span class="rooms-summary-label">Total Ruangan</span>
            <strong class="rooms-summary-value">
                {{ $rooms->count() }}
            </strong>
        </div>

        <div class="rooms-summary-card">
            <span class="rooms-summary-label">Ruangan Aktif</span>
            <strong class="rooms-summary-value">
                {{ $rooms->where('is_active', 1)->count() }}
            </strong>
        </div>

        <div class="rooms-summary-card">
            <span class="rooms-summary-label">Ruangan Tidak Aktif</span>
            <strong class="rooms-summary-value">
                {{ $rooms->where('is_active', 0)->count() }}
            </strong>
        </div>

        <div class="rooms-summary-card">
            <span class="rooms-summary-label">Belum Memiliki PIC</span>
            <strong class="rooms-summary-value">
                {{ $rooms->filter(fn ($room) => !$room->pic_id)->count() }}
            </strong>
        </div>

    </div>

    {{-- TABEL RUANGAN --}}
    <div class="rooms-card">

        <div class="rooms-card-header">
            <div>
                <h3>Daftar Ruangan</h3>
                <p>Informasi ruangan yang terdaftar di sistem.</p>
            </div>

            <div class="rooms-search">
                <input type="text"
                       id="rooms-search-input"
                       placeholder="Cari nama, lokasi, atau PIC..."
                       autocomplete="off">
            </div>
        </div>

        <div class="rooms-table-wrapper">
            <table class="rooms-table">

                <thead>
                    <tr>
                        <th class="rooms-number-column">No.</th>
                        <th>Nama Ruangan</th>
                        <th>Lokasi</th>
                        <th>Kapasitas</th>
                        <th>PIC Ruangan</th>
                        <th>Status</th>
                        <th class="rooms-action-column">Aksi</th>
                    </tr>
                </thead>

                <tbody id="rooms-table-body">

                    @forelse ($rooms as $room)
                        <tr class="rooms-table-row">

                            <td>
                                {{ $loop->iteration }}
                            </td>

                            <td>
                                <div class="rooms-name">
                                    {{ $room->room_name }}
                                </div>

                                <small class="rooms-id">
                                    ID: #{{ $room->id }}
                                </small>
                            </td>

                            <td>
                                {{ $room->location ?: '-' }}
                            </td>

                            <td>
                                {{ $room->capacity }} orang
                            </td>

                            <td>
                                @if ($room->pic)
                                    <span class="rooms-pic">
                                        {{ $room->pic->fullname
                                            ?? $room->pic->username
                                            ?? 'Nama tidak tersedia' }}
                                    </span>
                                @else
                                    <span class="rooms-muted">
                                        Belum ada PIC
                                    </span>
                                @endif
                            </td>

                            <td>
                                @if ($room->is_active)
                                    <span class="rooms-status rooms-status-active">
                                        Aktif
                                    </span>
                                @else
                                    <span class="rooms-status rooms-status-inactive">
                                        Tidak Aktif
                                    </span>
                                @endif
                            </td>

                            <td>
                                <div class="rooms-actions">

                                    {{-- EDIT --}}
                                    <button type="button"
                                            class="rooms-button rooms-button-edit"
                                            data-rooms-open="rooms-edit-modal-{{ $room->id }}">
                                        Edit
                                    </button>

                                    {{-- HAPUS --}}
                                    <button type="button"
                                            class="rooms-button rooms-button-delete"
                                            data-rooms-open="rooms-delete-modal-{{ $room->id }}">
                                        Hapus
                                    </button>

                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="rooms-empty">
                                <strong>Belum ada data ruangan.</strong>
                                <p>
                                    Klik tombol Tambah Ruang untuk menambahkan
                                    ruangan baru.
                                </p>
                            </td>
                        </tr>
                    @endforelse

                    <tr id="rooms-no-search-result" style="display: none;">
                        <td colspan="7" class="rooms-empty">
                            Tidak ada ruangan yang cocok dengan pencarian.
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>

        <div class="rooms-card-footer">
            Menampilkan {{ $rooms->count() }} ruangan.
        </div>

    </div>
</div>


{{-- ====================================================== --}}
{{-- MODAL TAMBAH RUANGAN --}}
{{-- ====================================================== --}}

<div class="rooms-modal"
     id="rooms-add-modal"
     aria-hidden="true">

    <div class="rooms-modal-dialog">

        <div class="rooms-modal-header">
            <div>
                <h3>Tambah Ruangan</h3>
                <p>Masukkan informasi ruangan baru.</p>
            </div>

            <button type="button"
                    class="rooms-modal-close"
                    data-rooms-close
                    aria-label="Tutup">
                &times;
            </button>
        </div>

        <form action="{{ route('rooms.store') }}" method="POST">
            @csrf

            <div class="rooms-modal-body">

                <div class="rooms-form-group">
                    <label for="add-room-name">
                        Nama Ruangan <span>*</span>
                    </label>

                    <input type="text"
                           id="add-room-name"
                           name="room_name"
                           maxlength="255"
                           value="{{ old('room_name') }}"
                           placeholder="Contoh: Laboratorium RPL"
                           required>
                </div>

                <div class="rooms-form-group">
                    <label for="add-room-location">
                        Lokasi / Keterangan <span>*</span>
                    </label>

                    <input type="text"
                           id="add-room-location"
                           name="location"
                           maxlength="255"
                           value="{{ old('location') }}"
                           placeholder="Contoh: Gedung A lantai 2"
                           required>
                </div>

                <div class="rooms-form-group">
                    <label for="add-room-capacity">
                        Kapasitas <span>*</span>
                    </label>

                    <input type="number"
                           id="add-room-capacity"
                           name="capacity"
                           min="1"
                           value="{{ old('capacity', 30) }}"
                           placeholder="Jumlah orang"
                           required>
                </div>

                <div class="rooms-form-group">
                    <label for="add-room-pic">
                        PIC Ruangan
                    </label>

                    <select name="pic_id" id="add-room-pic">
                        <option value="">Belum ditentukan</option>

                        @foreach ($picUsers as $pic)
                            <option value="{{ $pic->id }}"
                                @selected(old('pic_id') == $pic->id)>

                                {{ $pic->fullname
                                    ?? $pic->username
                                    ?? $pic->email }}

                            </option>
                        @endforeach
                    </select>
                </div>

                <input type="hidden" name="is_active" value="1">

                <p class="rooms-form-note">
                    Ruangan baru akan dibuat dengan status Aktif.
                    Kolom bertanda <span>*</span> wajib diisi.
                </p>

            </div>

            <div class="rooms-modal-footer">
                <button type="button"
                        class="rooms-button rooms-button-secondary"
                        data-rooms-close>
                    Batal
                </button>

                <button type="submit"
                        class="rooms-button rooms-button-primary">
                    Simpan Ruangan
                </button>
            </div>

        </form>

    </div>
</div>


{{-- ====================================================== --}}
{{-- MODAL EDIT RUANGAN --}}
{{-- ====================================================== --}}

@foreach ($rooms as $room)

    <div class="rooms-modal"
         id="rooms-edit-modal-{{ $room->id }}"
         aria-hidden="true">

        <div class="rooms-modal-dialog">

            <div class="rooms-modal-header">
                <div>
                    <h3>Edit Ruangan</h3>
                    <p>Perbarui informasi ruangan.</p>
                </div>

                <button type="button"
                        class="rooms-modal-close"
                        data-rooms-close
                        aria-label="Tutup">
                    &times;
                </button>
            </div>

            <form action="{{ route('rooms.update', $room->id) }}"
                  method="POST">

                @csrf
                @method('PUT')

                <input type="hidden"
                       name="edit_room_id"
                       value="{{ $room->id }}">

                <div class="rooms-modal-body">

                    <div class="rooms-form-group">
                        <label for="edit-room-name-{{ $room->id }}">
                            Nama Ruangan <span>*</span>
                        </label>

                        <input type="text"
                               id="edit-room-name-{{ $room->id }}"
                               name="room_name"
                               maxlength="255"
                               value="{{ old('edit_room_id') == $room->id
                                    ? old('room_name')
                                    : $room->room_name }}"
                               required>
                    </div>

                    <div class="rooms-form-group">
                        <label for="edit-room-location-{{ $room->id }}">
                            Lokasi / Keterangan <span>*</span>
                        </label>

                        <input type="text"
                               id="edit-room-location-{{ $room->id }}"
                               name="location"
                               maxlength="255"
                               value="{{ old('edit_room_id') == $room->id
                                    ? old('location')
                                    : $room->location }}"
                               required>
                    </div>

                    <div class="rooms-form-group">
                        <label for="edit-room-capacity-{{ $room->id }}">
                            Kapasitas <span>*</span>
                        </label>

                        <input type="number"
                               id="edit-room-capacity-{{ $room->id }}"
                               name="capacity"
                               min="1"
                               value="{{ old('edit_room_id') == $room->id
                                    ? old('capacity')
                                    : $room->capacity }}"
                               required>
                    </div>

                    <div class="rooms-form-group">
                        <label for="edit-room-pic-{{ $room->id }}">
                            PIC Ruangan
                        </label>

                        <select name="pic_id"
                                id="edit-room-pic-{{ $room->id }}">

                            <option value="">Belum ditentukan</option>

                            @foreach ($picUsers as $pic)
                                <option value="{{ $pic->id }}"
                                    @selected(
                                        (string) (
                                            old('edit_room_id') == $room->id
                                                ? old('pic_id', $room->pic_id)
                                                : $room->pic_id
                                        ) === (string) $pic->id
                                    )>

                                    {{ $pic->fullname
                                        ?? $pic->username
                                        ?? $pic->email }}

                                </option>
                            @endforeach

                        </select>
                    </div>

                    <div class="rooms-form-group">
                        <label for="edit-room-status-{{ $room->id }}">
                            Status Ruangan <span>*</span>
                        </label>

                        <select name="is_active"
                                id="edit-room-status-{{ $room->id }}"
                                required>

                            <option value="1"
                                @selected(
                                    (string) (
                                        old('edit_room_id') == $room->id
                                            ? old('is_active', $room->is_active)
                                            : $room->is_active
                                    ) === '1'
                                )>
                                Aktif
                            </option>

                            <option value="0"
                                @selected(
                                    (string) (
                                        old('edit_room_id') == $room->id
                                            ? old('is_active', $room->is_active)
                                            : $room->is_active
                                    ) === '0'
                                )>
                                Tidak Aktif
                            </option>

                        </select>
                    </div>

                </div>

                <div class="rooms-modal-footer">
                    <button type="button"
                            class="rooms-button rooms-button-secondary"
                            data-rooms-close>
                        Batal
                    </button>

                    <button type="submit"
                            class="rooms-button rooms-button-primary">
                        Simpan Perubahan
                    </button>
                </div>

            </form>

        </div>
    </div>


    {{-- ================================================== --}}
    {{-- MODAL KONFIRMASI HAPUS --}}
    {{-- ================================================== --}}

    <div class="rooms-modal"
         id="rooms-delete-modal-{{ $room->id }}"
         aria-hidden="true">

        <div class="rooms-modal-dialog rooms-modal-dialog-small">

            <div class="rooms-modal-header">
                <div>
                    <h3>Hapus Ruangan</h3>
                    <p>Konfirmasi penghapusan data.</p>
                </div>

                <button type="button"
                        class="rooms-modal-close"
                        data-rooms-close
                        aria-label="Tutup">
                    &times;
                </button>
            </div>

            <div class="rooms-modal-body">
                <p class="rooms-delete-message">
                    Apakah kamu yakin ingin menghapus ruangan
                    <strong>{{ $room->room_name }}</strong>?
                </p>

                <p class="rooms-form-note">
                    Pastikan ruangan ini tidak sedang digunakan
                    oleh data peminjaman yang masih diperlukan.
                </p>
            </div>

            <div class="rooms-modal-footer">

                <button type="button"
                        class="rooms-button rooms-button-secondary"
                        data-rooms-close>
                    Batal
                </button>

                <form action="{{ route('rooms.destroy', $room->id) }}"
                      method="POST">

                    @csrf
                    @method('DELETE')

                    <button type="submit"
                            class="rooms-button rooms-button-danger">
                        Hapus Ruangan
                    </button>

                </form>

            </div>

        </div>
    </div>

@endforeach


{{-- ====================================================== --}}
{{-- CSS --}}
{{-- ====================================================== --}}

<style>
    .rooms-page {
        width: 100%;
        color: #263449;
        font-family: inherit;
    }

    .rooms-page *,
    .rooms-modal * {
        box-sizing: border-box;
    }

    .rooms-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 22px;
    }

    .rooms-title {
        margin: 0 0 6px;
        color: #172b4d;
        font-size: 24px;
        font-weight: 700;
    }

    .rooms-subtitle {
        margin: 0;
        color: #738096;
        font-size: 14px;
        line-height: 1.6;
    }

    .rooms-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 9px 13px;
        border: 1px solid transparent;
        border-radius: 6px;
        font-family: inherit;
        font-size: 13px;
        font-weight: 600;
        line-height: 1.4;
        text-decoration: none;
        white-space: nowrap;
        cursor: pointer;
        transition: background-color .15s ease, border-color .15s ease;
    }

    .rooms-button:focus-visible,
    .rooms-search input:focus-visible,
    .rooms-form-group input:focus-visible,
    .rooms-form-group select:focus-visible {
        outline: 2px solid #8298b8;
        outline-offset: 2px;
    }

    .rooms-button-primary {
        background: #172b4d;
        border-color: #172b4d;
        color: #fff;
    }

    .rooms-button-primary:hover {
        background: #243f68;
        border-color: #243f68;
    }

    .rooms-button-edit {
        background: #edf1f6;
        border-color: #dce3ec;
        color: #263c5a;
    }

    .rooms-button-edit:hover {
        background: #dfe6ef;
    }

    .rooms-button-delete,
    .rooms-button-danger {
        background: #fff;
        border-color: #e3caca;
        color: #a13c3c;
    }

    .rooms-button-delete:hover,
    .rooms-button-danger:hover {
        background: #fbefef;
    }

    .rooms-button-secondary {
        background: #fff;
        border-color: #d7dee8;
        color: #46556b;
    }

    .rooms-button-secondary:hover {
        background: #f4f6f9;
    }

    .rooms-alert {
        margin-bottom: 18px;
        padding: 12px 15px;
        border: 1px solid;
        border-radius: 6px;
        font-size: 13px;
        line-height: 1.6;
    }

    .rooms-alert ul {
        margin: 8px 0 0;
        padding-left: 20px;
    }

    .rooms-alert-success {
        background: #f0f5f2;
        border-color: #d4e4d9;
        color: #315b40;
    }

    .rooms-alert-error {
        background: #fbf2f2;
        border-color: #ead5d5;
        color: #913d3d;
    }

    .rooms-summary {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 14px;
        margin-bottom: 22px;
    }

    .rooms-summary-card {
        padding: 17px 18px;
        background: #fff;
        border: 1px solid #e4e9f0;
        border-radius: 8px;
    }

    .rooms-summary-label {
        display: block;
        margin-bottom: 10px;
        color: #778398;
        font-size: 12px;
    }

    .rooms-summary-value {
        display: block;
        color: #172b4d;
        font-size: 25px;
        font-weight: 700;
    }

    .rooms-card {
        overflow: hidden;
        background: #fff;
        border: 1px solid #e4e9f0;
        border-radius: 8px;
    }

    .rooms-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        padding: 19px 20px;
        border-bottom: 1px solid #e9edf3;
    }

    .rooms-card-header h3 {
        margin: 0 0 5px;
        color: #203653;
        font-size: 16px;
        font-weight: 700;
    }

    .rooms-card-header p {
        margin: 0;
        color: #7b8798;
        font-size: 12px;
        line-height: 1.5;
    }

    .rooms-search {
        width: min(100%, 300px);
    }

    .rooms-search input {
        width: 100%;
        min-height: 38px;
        padding: 9px 12px;
        border: 1px solid #dce3ec;
        border-radius: 6px;
        background: #fff;
        color: #263449;
        font-family: inherit;
        font-size: 13px;
    }

    .rooms-search input::placeholder {
        color: #9aa4b3;
    }

    .rooms-table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    .rooms-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
        font-size: 13px;
    }

    .rooms-table thead {
        background: #f7f8fa;
    }

    .rooms-table th {
        padding: 13px 15px;
        color: #657287;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .25px;
        white-space: nowrap;
        border-bottom: 1px solid #e5eaf1;
    }

    .rooms-table td {
        padding: 14px 15px;
        color: #526075;
        vertical-align: middle;
        border-bottom: 1px solid #edf0f4;
    }

    .rooms-table tbody tr:last-child td {
        border-bottom: none;
    }

    .rooms-table-row:hover {
        background: #fafbfd;
    }

    .rooms-number-column {
        width: 55px;
    }

    .rooms-action-column {
        min-width: 145px;
    }

    .rooms-name {
        color: #263b59;
        font-weight: 600;
        white-space: nowrap;
    }

    .rooms-id {
        display: block;
        margin-top: 5px;
        color: #8b96a7;
        font-size: 11px;
    }

    .rooms-pic {
        color: #46566d;
        font-size: 12px;
    }

    .rooms-muted {
        color: #929cac;
        font-size: 12px;
    }

    .rooms-status {
        display: inline-block;
        padding: 5px 9px;
        border: 1px solid;
        border-radius: 5px;
        font-size: 11px;
        font-weight: 600;
        white-space: nowrap;
    }

    .rooms-status-active {
        background: #f0f5f2;
        border-color: #d4e4d9;
        color: #315b40;
    }

    .rooms-status-inactive {
        background: #f2f4f7;
        border-color: #e0e5eb;
        color: #647084;
    }

    .rooms-actions {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .rooms-actions .rooms-button {
        padding: 7px 10px;
        font-size: 12px;
    }

    .rooms-empty {
        padding: 35px 20px !important;
        text-align: center;
        color: #788599 !important;
    }

    .rooms-empty strong {
        display: block;
        margin-bottom: 6px;
        color: #43536b;
    }

    .rooms-empty p {
        margin: 0;
        font-size: 12px;
    }

    .rooms-card-footer {
        padding: 13px 20px;
        background: #fafbfd;
        border-top: 1px solid #e9edf3;
        color: #788599;
        font-size: 12px;
    }

    /* MODAL */

    .rooms-modal {
        position: fixed;
        inset: 0;
        z-index: 10000;
        display: none;
        align-items: center;
        justify-content: center;
        overflow-y: auto;
        padding: 20px;
        background: rgba(19, 32, 51, .48);
    }

    .rooms-modal.is-open {
        display: flex;
    }

    .rooms-modal-dialog {
        width: 100%;
        max-width: 540px;
        max-height: calc(100vh - 40px);
        overflow-y: auto;
        background: #fff;
        border: 1px solid #e0e5ed;
        border-radius: 9px;
        box-shadow: 0 12px 35px rgba(20, 36, 58, .18);
        animation: rooms-modal-appear .15s ease-out;
    }

    .rooms-modal-dialog-small {
        max-width: 440px;
    }

    .rooms-modal-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 14px;
        padding: 20px 22px;
        border-bottom: 1px solid #e9edf3;
    }

    .rooms-modal-header h3 {
        margin: 0 0 5px;
        color: #203653;
        font-size: 17px;
        font-weight: 700;
    }

    .rooms-modal-header p {
        margin: 0;
        color: #7b8798;
        font-size: 12px;
        line-height: 1.5;
    }

    .rooms-modal-close {
        flex-shrink: 0;
        width: 30px;
        height: 30px;
        padding: 0;
        border: 1px solid #e0e5ed;
        border-radius: 5px;
        background: #fff;
        color: #657287;
        font-size: 23px;
        line-height: 1;
        cursor: pointer;
    }

    .rooms-modal-close:hover {
        background: #f4f6f9;
        color: #203653;
    }

    .rooms-modal-body {
        padding: 20px 22px;
    }

    .rooms-form-group {
        margin-bottom: 16px;
    }

    .rooms-form-group label {
        display: block;
        margin-bottom: 7px;
        color: #40516a;
        font-size: 12px;
        font-weight: 600;
    }

    .rooms-form-group label span,
    .rooms-form-note span {
        color: #a13c3c;
    }

    .rooms-form-group input,
    .rooms-form-group select {
        display: block;
        width: 100%;
        min-height: 40px;
        padding: 10px 11px;
        border: 1px solid #dce3ec;
        border-radius: 6px;
        background: #fff;
        color: #263449;
        font-family: inherit;
        font-size: 13px;
    }

    .rooms-form-group input::placeholder {
        color: #a1aab7;
    }

    .rooms-form-group input:focus,
    .rooms-form-group select:focus {
        border-color: #8298b8;
        outline: none;
    }

    .rooms-form-note {
        margin: 6px 0 0;
        color: #7b8798;
        font-size: 12px;
        line-height: 1.6;
    }

    .rooms-delete-message {
        margin: 0;
        color: #526075;
        font-size: 14px;
        line-height: 1.7;
    }

    .rooms-delete-message strong {
        color: #263b59;
    }

    .rooms-modal-footer {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 9px;
        padding: 15px 22px;
        border-top: 1px solid #e9edf3;
        background: #fafbfd;
    }

    .rooms-modal-footer form {
        margin: 0;
    }

    @keyframes rooms-modal-appear {
        from {
            opacity: 0;
            transform: translateY(5px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @media (max-width: 900px) {
        .rooms-summary {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .rooms-card-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .rooms-search {
            width: 100%;
        }
    }

    @media (max-width: 600px) {
        .rooms-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .rooms-title {
            font-size: 21px;
        }

        .rooms-summary {
            gap: 10px;
        }

        .rooms-summary-card {
            padding: 14px;
        }

        .rooms-summary-value {
            font-size: 22px;
        }

        .rooms-modal {
            padding: 10px;
        }

        .rooms-modal-dialog {
            max-height: calc(100vh - 20px);
        }

        .rooms-modal-header,
        .rooms-modal-body {
            padding: 17px;
        }

        .rooms-modal-footer {
            padding: 13px 17px;
            flex-wrap: wrap;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .rooms-modal-dialog {
            animation: none;
        }

        .rooms-button {
            transition: none;
        }
    }
</style>


{{-- ====================================================== --}}
{{-- JAVASCRIPT --}}
{{-- ====================================================== --}}

<script>
(function () {
    /*
     * Data ruangan dan data pengguna sama-sama berada
     * di dashboard admin. Gunakan satu pengelola modal
     * global agar event listener tidak bertumpuk.
     */

    if (!window.rapiModalManagerInitialized) {
        window.rapiModalManagerInitialized = true;

        window.rapiOpenModal = function (modalId) {
            const modal = document.getElementById(modalId);

            if (!modal) {
                return;
            }

            document.querySelectorAll(
                '.rooms-modal.is-open, .users-modal.is-open'
            ).forEach(function (item) {
                item.classList.remove('is-open');
                item.setAttribute('aria-hidden', 'true');
            });

            modal.classList.add('is-open');
            modal.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';

            const firstInput = modal.querySelector(
                'input:not([type="hidden"]), select'
            );

            if (firstInput) {
                window.setTimeout(function () {
                    firstInput.focus();
                }, 100);
            }
        };

        window.rapiCloseModal = function (modal) {
            if (!modal) {
                return;
            }

            modal.classList.remove('is-open');
            modal.setAttribute('aria-hidden', 'true');

            if (!document.querySelector(
                '.rooms-modal.is-open, .users-modal.is-open'
            )) {
                document.body.style.overflow = '';
            }
        };

        document.addEventListener('click', function (event) {
            const openButton = event.target.closest(
                '[data-rooms-open], [data-users-open]'
            );

            if (openButton) {
                event.preventDefault();

                const modalId =
                    openButton.getAttribute('data-rooms-open') ||
                    openButton.getAttribute('data-users-open');

                window.rapiOpenModal(modalId);
                return;
            }

            const closeButton = event.target.closest(
                '[data-rooms-close], [data-users-close]'
            );

            if (closeButton) {
                event.preventDefault();

                window.rapiCloseModal(
                    closeButton.closest('.rooms-modal, .users-modal')
                );
                return;
            }

            if (
                event.target.classList.contains('rooms-modal') ||
                event.target.classList.contains('users-modal')
            ) {
                window.rapiCloseModal(event.target);
            }
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                const openedModal = document.querySelector(
                    '.rooms-modal.is-open, .users-modal.is-open'
                );

                if (openedModal) {
                    window.rapiCloseModal(openedModal);
                }
            }
        });
    }

    /*
     * Pencarian ruangan.
     */
    const searchInput = document.getElementById('rooms-search-input');

    if (searchInput && !searchInput.dataset.initialized) {
        searchInput.dataset.initialized = 'true';

        searchInput.addEventListener('input', function () {
            const keyword = this.value.toLowerCase().trim();

            const rows = document.querySelectorAll(
                '#rooms-table-body .rooms-table-row'
            );

            let visibleCount = 0;

            rows.forEach(function (row) {
                const matched = row.textContent
                    .toLowerCase()
                    .includes(keyword);

                row.style.display = matched ? '' : 'none';

                if (matched) {
                    visibleCount++;
                }
            });

            const noResult = document.getElementById(
                'rooms-no-search-result'
            );

            if (noResult) {
                noResult.style.display =
                    rows.length > 0 && visibleCount === 0 ? '' : 'none';
            }
        });
    }

    /*
     * Buka kembali modal setelah validasi gagal.
     */
    @if ($errors->any())
        @if (old('edit_room_id'))
            window.rapiOpenModal(
                'rooms-edit-modal-{{ old('edit_room_id') }}'
            );
        @else
            window.rapiOpenModal('rooms-add-modal');
        @endif
    @endif
})();
</script>