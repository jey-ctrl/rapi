{{-- resources/views/admin/data_pengguna.blade.php --}}

<div class="users-page">

    {{-- HEADER --}}
    <div class="users-header">
        <div>
            <h2 class="users-title">Data Pengguna</h2>
            <p class="users-subtitle">
                Kelola akun dan hak akses pengguna RAPI-Sekolah.
            </p>
        </div>

        <button type="button"
                class="users-button users-button-primary"
                data-users-open="users-add-modal">
            + Tambah Pengguna
        </button>
    </div>

    {{-- NOTIFIKASI BERHASIL --}}
    @if (session('success'))
        <div class="users-alert users-alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- NOTIFIKASI ERROR --}}
    @if (session('error'))
        <div class="users-alert users-alert-error">
            {{ session('error') }}
        </div>
    @endif

    {{-- VALIDASI --}}
    @if ($errors->any())
        <div class="users-alert users-alert-error">
            <strong>Data belum berhasil disimpan.</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- RINGKASAN --}}
    <div class="users-summary">
        <div class="users-summary-card">
            <span class="users-summary-label">Total Pengguna</span>
            <strong class="users-summary-value">
                {{ isset($users) ? $users->count() : 0 }}
            </strong>
        </div>

        <div class="users-summary-card">
            <span class="users-summary-label">Admin / Waka</span>
            <strong class="users-summary-value">
                {{ isset($users) ? $users->where('role_id', 1)->count() : 0 }}
            </strong>
        </div>

        <div class="users-summary-card">
            <span class="users-summary-label">PIC Ruang</span>
            <strong class="users-summary-value">
                {{ isset($users) ? $users->where('role_id', 2)->count() : 0 }}
            </strong>
        </div>

        <div class="users-summary-card">
            <span class="users-summary-label">Guru / Pengguna</span>
            <strong class="users-summary-value">
                {{ isset($users) ? $users->where('role_id', 3)->count() : 0 }}
            </strong>
        </div>
    </div>

    {{-- TABEL PENGGUNA --}}
    <div class="users-card">

        <div class="users-card-header">
            <div>
                <h3>Daftar Pengguna</h3>
                <p>Informasi akun yang terdaftar dalam sistem.</p>
            </div>

            <div class="users-search">
                <input type="text"
                       id="users-search-input"
                       placeholder="Cari nama atau username..."
                       autocomplete="off">
            </div>
        </div>

        <div class="users-table-wrapper">
            <table class="users-table">
                <thead>
                    <tr>
                        <th class="users-number-column">No.</th>
                        <th>Nama Lengkap</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Nomor HP</th>
                        <th>Hak Akses</th>
                        <th class="users-action-column">Aksi</th>
                    </tr>
                </thead>

                <tbody id="users-table-body">
                    @forelse ($users as $user)
                        <tr class="users-table-row">
                            <td>
                                {{ $loop->iteration }}
                            </td>

                            <td>
                                <div class="users-name">
                                    {{ $user->fullname }}
                                </div>
                            </td>

                            <td>
                                <span class="users-username">
                                    {{ $user->username }}
                                </span>
                            </td>

                            <td>
                                {{ $user->email ?: '-' }}
                            </td>

                            <td>
                                @if (!empty($user->phone_number))
                                    <a class="users-phone-link"
                                       href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $user->phone_number) }}"
                                       target="_blank"
                                       rel="noopener noreferrer">
                                        {{ $user->phone_number }}
                                    </a>
                                @else
                                    <span class="users-muted">-</span>
                                @endif
                            </td>

                            <td>
                                @php
                                    $roleName = $user->roles?->roles_name;

                                    if (!$roleName) {
                                        $roleName = match ((int) $user->role_id) {
                                            1 => 'Admin / Waka',
                                            2 => 'PIC Ruang',
                                            3 => 'Guru / Pengguna',
                                            default => 'Tidak diketahui',
                                        };
                                    }
                                @endphp

                                <span class="users-role-badge">
                                    {{ $roleName }}
                                </span>
                            </td>

                            <td>
                                <div class="users-actions">

                                    {{-- EDIT --}}
                                    <button type="button"
                                            class="users-button users-button-edit"
                                            data-users-open="users-edit-modal-{{ $user->id }}">
                                        Edit
                                    </button>

                                    {{-- HAPUS --}}
                                    <button type="button"
                                            class="users-button users-button-delete"
                                            data-users-open="users-delete-modal-{{ $user->id }}">
                                        Hapus
                                    </button>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="users-empty">
                                <strong>Belum ada data pengguna.</strong>
                                <p>Tambahkan pengguna untuk mulai mengelola akun.</p>
                            </td>
                        </tr>
                    @endforelse

                    <tr id="users-no-search-result" style="display: none;">
                        <td colspan="7" class="users-empty">
                            Tidak ada pengguna yang cocok dengan pencarian.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="users-table-footer">
            Menampilkan {{ isset($users) ? $users->count() : 0 }} pengguna.
        </div>

    </div>
</div>


{{-- ====================================================== --}}
{{-- MODAL TAMBAH PENGGUNA --}}
{{-- ====================================================== --}}

<div class="users-modal"
     id="users-add-modal"
     aria-hidden="true">

    <div class="users-modal-dialog">

        <div class="users-modal-header">
            <div>
                <h3>Tambah Pengguna</h3>
                <p>Masukkan informasi akun pengguna baru.</p>
            </div>

            <button type="button"
                    class="users-modal-close"
                    data-users-close
                    aria-label="Tutup">
                &times;
            </button>
        </div>

        <form action="{{ route('users.store') }}"
              method="POST">

            @csrf

            <div class="users-modal-body">

                <div class="users-form-group">
                    <label for="add-fullname">
                        Nama Lengkap <span>*</span>
                    </label>

                    <input type="text"
                           id="add-fullname"
                           name="fullname"
                           value="{{ old('fullname') }}"
                           placeholder="Masukkan nama lengkap"
                           required>
                </div>

                <div class="users-form-group">
                    <label for="add-username">
                        Username <span>*</span>
                    </label>

                    <input type="text"
                           id="add-username"
                           name="username"
                           value="{{ old('username') }}"
                           placeholder="Masukkan username"
                           required>
                </div>

                <div class="users-form-group">
                    <label for="add-email">
                        Email
                    </label>

                    <input type="email"
                           id="add-email"
                           name="email"
                           value="{{ old('email') }}"
                           placeholder="contoh@email.com">
                </div>

                <div class="users-form-group">
                    <label for="add-phone">
                        Nomor HP
                    </label>

                    <input type="text"
                           id="add-phone"
                           name="phone_number"
                           value="{{ old('phone_number') }}"
                           placeholder="Contoh: 081234567890">
                </div>

                <div class="users-form-group">
                    <label for="add-role">
                        Hak Akses <span>*</span>
                    </label>

                    <select id="add-role"
                            name="role_id"
                            required>
                        <option value="">-- Pilih Hak Akses --</option>

                        <option value="1"
                            {{ old('role_id') == '1' ? 'selected' : '' }}>
                            Admin / Waka
                        </option>

                        <option value="2"
                            {{ old('role_id') == '2' ? 'selected' : '' }}>
                            PIC Ruang
                        </option>

                        <option value="3"
                            {{ old('role_id') == '3' ? 'selected' : '' }}>
                            Guru / Pengguna
                        </option>
                    </select>
                </div>

                <div class="users-form-group">
                    <label for="add-password">
                        Password <span>*</span>
                    </label>

                    <input type="password"
                           id="add-password"
                           name="password"
                           placeholder="Masukkan password"
                           required>
                </div>

                <p class="users-form-note">
                    Kolom bertanda <span>*</span> wajib diisi.
                </p>

            </div>

            <div class="users-modal-footer">
                <button type="button"
                        class="users-button users-button-secondary"
                        data-users-close>
                    Batal
                </button>

                <button type="submit"
                        class="users-button users-button-primary">
                    Simpan Pengguna
                </button>
            </div>

        </form>

    </div>
</div>


{{-- ====================================================== --}}
{{-- MODAL EDIT DAN HAPUS PER PENGGUNA --}}
{{-- ====================================================== --}}

@foreach ($users as $user)

    {{-- MODAL EDIT --}}
    <div class="users-modal"
         id="users-edit-modal-{{ $user->id }}"
         aria-hidden="true">

        <div class="users-modal-dialog">

            <div class="users-modal-header">
                <div>
                    <h3>Edit Pengguna</h3>
                    <p>Perbarui informasi akun pengguna.</p>
                </div>

                <button type="button"
                        class="users-modal-close"
                        data-users-close
                        aria-label="Tutup">
                    &times;
                </button>
            </div>

            <form action="{{ route('users.update', $user->id) }}"
                  method="POST">

                @csrf
                @method('PUT')

                <input type="hidden"
                       name="edit_user_id"
                       value="{{ $user->id }}">

                <div class="users-modal-body">

                    <div class="users-form-group">
                        <label for="edit-fullname-{{ $user->id }}">
                            Nama Lengkap <span>*</span>
                        </label>

                        <input type="text"
                               id="edit-fullname-{{ $user->id }}"
                               name="fullname"
                               value="{{ old('edit_user_id') == $user->id ? old('fullname') : $user->fullname }}"
                               required>
                    </div>

                    <div class="users-form-group">
                        <label for="edit-username-{{ $user->id }}">
                            Username <span>*</span>
                        </label>

                        <input type="text"
                               id="edit-username-{{ $user->id }}"
                               name="username"
                               value="{{ old('edit_user_id') == $user->id ? old('username') : $user->username }}"
                               required>
                    </div>

                    <div class="users-form-group">
                        <label for="edit-email-{{ $user->id }}">
                            Email
                        </label>

                        <input type="email"
                               id="edit-email-{{ $user->id }}"
                               name="email"
                               value="{{ old('edit_user_id') == $user->id ? old('email') : $user->email }}">
                    </div>

                    <div class="users-form-group">
                        <label for="edit-phone-{{ $user->id }}">
                            Nomor HP
                        </label>

                        <input type="text"
                               id="edit-phone-{{ $user->id }}"
                               name="phone_number"
                               value="{{ old('edit_user_id') == $user->id ? old('phone_number') : $user->phone_number }}">
                    </div>

                    <div class="users-form-group">
                        <label for="edit-role-{{ $user->id }}">
                            Hak Akses <span>*</span>
                        </label>

                        <select id="edit-role-{{ $user->id }}"
                                name="role_id"
                                required>

                            <option value="1"
                                {{ (old('edit_user_id') == $user->id ? old('role_id', $user->role_id) : $user->role_id) == '1' ? 'selected' : '' }}>
                                Admin / Waka
                            </option>

                            <option value="2"
                                {{ (old('edit_user_id') == $user->id ? old('role_id', $user->role_id) : $user->role_id) == '2' ? 'selected' : '' }}>
                                PIC Ruang
                            </option>

                            <option value="3"
                                {{ (old('edit_user_id') == $user->id ? old('role_id', $user->role_id) : $user->role_id) == '3' ? 'selected' : '' }}>
                                Guru / Pengguna
                            </option>

                        </select>
                    </div>

                    <div class="users-form-group">
                        <label for="edit-password-{{ $user->id }}">
                            Password Baru
                        </label>

                        <input type="password"
                               id="edit-password-{{ $user->id }}"
                               name="password"
                               placeholder="Kosongkan jika tidak diubah"
                               autocomplete="new-password">
                    </div>

                    <p class="users-form-note">
                        Password tidak perlu diisi jika tidak ingin mengubahnya.
                    </p>

                </div>

                <div class="users-modal-footer">
                    <button type="button"
                            class="users-button users-button-secondary"
                            data-users-close>
                        Batal
                    </button>

                    <button type="submit"
                            class="users-button users-button-primary">
                        Simpan Perubahan
                    </button>
                </div>

            </form>

        </div>
    </div>


    {{-- MODAL KONFIRMASI HAPUS --}}
    <div class="users-modal"
         id="users-delete-modal-{{ $user->id }}"
         aria-hidden="true">

        <div class="users-modal-dialog users-modal-dialog-small">

            <div class="users-modal-header">
                <div>
                    <h3>Hapus Pengguna</h3>
                    <p>Konfirmasi penghapusan akun.</p>
                </div>

                <button type="button"
                        class="users-modal-close"
                        data-users-close
                        aria-label="Tutup">
                    &times;
                </button>
            </div>

            <div class="users-modal-body">
                <p class="users-delete-message">
                    Apakah kamu yakin ingin menghapus pengguna
                    <strong>{{ $user->fullname }}</strong>?
                </p>

                <p class="users-form-note">
                    Tindakan ini tidak dapat dibatalkan.
                </p>
            </div>

            <div class="users-modal-footer">

                <button type="button"
                        class="users-button users-button-secondary"
                        data-users-close>
                    Batal
                </button>

                <form action="{{ route('users.destroy', $user->id) }}"
                      method="POST">

                    @csrf
                    @method('DELETE')

                    <button type="submit"
                            class="users-button users-button-danger">
                        Hapus Pengguna
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
    .users-page {
        width: 100%;
        color: #263449;
        font-family: inherit;
    }

    .users-page *,
    .users-modal * {
        box-sizing: border-box;
    }

    .users-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 22px;
    }

    .users-title {
        margin: 0 0 6px;
        color: #172b4d;
        font-size: 24px;
        font-weight: 700;
    }

    .users-subtitle {
        margin: 0;
        color: #738096;
        font-size: 14px;
        line-height: 1.6;
    }

    .users-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        border: 1px solid transparent;
        border-radius: 6px;
        padding: 9px 13px;
        font-family: inherit;
        font-size: 13px;
        font-weight: 600;
        line-height: 1.4;
        text-decoration: none;
        cursor: pointer;
        transition: background-color .15s ease, border-color .15s ease;
    }

    .users-button:focus-visible,
    .users-search input:focus-visible,
    .users-form-group input:focus-visible,
    .users-form-group select:focus-visible {
        outline: 2px solid #7d9ac4;
        outline-offset: 2px;
    }

    .users-button-primary {
        background: #172b4d;
        border-color: #172b4d;
        color: #fff;
    }

    .users-button-primary:hover {
        background: #243f68;
        border-color: #243f68;
    }

    .users-button-edit {
        background: #edf1f6;
        border-color: #dce3ec;
        color: #263c5a;
    }

    .users-button-edit:hover {
        background: #dfe6ef;
    }

    .users-button-delete,
    .users-button-danger {
        background: #fff;
        border-color: #e3caca;
        color: #a13c3c;
    }

    .users-button-delete:hover,
    .users-button-danger:hover {
        background: #fbefef;
    }

    .users-button-secondary {
        background: #fff;
        border-color: #d7dee8;
        color: #46556b;
    }

    .users-button-secondary:hover {
        background: #f4f6f9;
    }

    .users-alert {
        margin-bottom: 18px;
        padding: 12px 15px;
        border: 1px solid;
        border-radius: 6px;
        font-size: 13px;
        line-height: 1.6;
    }

    .users-alert ul {
        margin: 8px 0 0;
        padding-left: 20px;
    }

    .users-alert-success {
        background: #f0f5f2;
        border-color: #d4e4d9;
        color: #315b40;
    }

    .users-alert-error {
        background: #fbf2f2;
        border-color: #ead5d5;
        color: #913d3d;
    }

    .users-summary {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 14px;
        margin-bottom: 22px;
    }

    .users-summary-card {
        padding: 17px 18px;
        background: #fff;
        border: 1px solid #e4e9f0;
        border-radius: 8px;
    }

    .users-summary-label {
        display: block;
        margin-bottom: 10px;
        color: #778398;
        font-size: 12px;
    }

    .users-summary-value {
        display: block;
        color: #172b4d;
        font-size: 25px;
        font-weight: 700;
    }

    .users-card {
        overflow: hidden;
        background: #fff;
        border: 1px solid #e4e9f0;
        border-radius: 8px;
    }

    .users-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        padding: 19px 20px;
        border-bottom: 1px solid #e9edf3;
    }

    .users-card-header h3 {
        margin: 0 0 5px;
        color: #203653;
        font-size: 16px;
        font-weight: 700;
    }

    .users-card-header p {
        margin: 0;
        color: #7b8798;
        font-size: 12px;
        line-height: 1.5;
    }

    .users-search {
        width: min(100%, 290px);
    }

    .users-search input {
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

    .users-search input::placeholder {
        color: #9aa4b3;
    }

    .users-table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    .users-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
        font-size: 13px;
    }

    .users-table thead {
        background: #f7f8fa;
    }

    .users-table th {
        padding: 13px 15px;
        color: #657287;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .25px;
        white-space: nowrap;
        border-bottom: 1px solid #e5eaf1;
    }

    .users-table td {
        padding: 14px 15px;
        color: #526075;
        vertical-align: middle;
        border-bottom: 1px solid #edf0f4;
    }

    .users-table tbody tr:last-child td {
        border-bottom: none;
    }

    .users-table-row:hover {
        background: #fafbfd;
    }

    .users-number-column {
        width: 50px;
    }

    .users-action-column {
        min-width: 140px;
    }

    .users-name {
        color: #263b59;
        font-weight: 600;
        white-space: nowrap;
    }

    .users-username {
        color: #59677c;
        font-family: Consolas, monospace;
        font-size: 12px;
    }

    .users-muted {
        color: #9aa4b3;
    }

    .users-phone-link {
        color: #465f82;
        text-decoration: none;
        white-space: nowrap;
    }

    .users-phone-link:hover {
        text-decoration: underline;
    }

    .users-role-badge {
        display: inline-block;
        max-width: 180px;
        padding: 5px 9px;
        border: 1px solid #dfe5ed;
        border-radius: 5px;
        background: #f3f5f8;
        color: #45566f;
        font-size: 11px;
        font-weight: 600;
        line-height: 1.4;
    }

    .users-actions {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .users-actions .users-button {
        padding: 7px 10px;
        font-size: 12px;
    }

    .users-empty {
        padding: 35px 20px !important;
        text-align: center;
        color: #788599 !important;
    }

    .users-empty strong {
        display: block;
        margin-bottom: 6px;
        color: #43536b;
    }

    .users-empty p {
        margin: 0;
        font-size: 12px;
    }

    .users-table-footer {
        padding: 13px 20px;
        background: #fafbfd;
        border-top: 1px solid #e9edf3;
        color: #788599;
        font-size: 12px;
    }

    /* MODAL */

    .users-modal {
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

    .users-modal.is-open {
        display: flex;
    }

    .users-modal-dialog {
        width: 100%;
        max-width: 540px;
        max-height: calc(100vh - 40px);
        overflow-y: auto;
        background: #fff;
        border: 1px solid #e0e5ed;
        border-radius: 9px;
        box-shadow: 0 12px 35px rgba(20, 36, 58, .18);
        animation: users-modal-appear .15s ease-out;
    }

    .users-modal-dialog-small {
        max-width: 440px;
    }

    .users-modal-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 14px;
        padding: 20px 22px;
        border-bottom: 1px solid #e9edf3;
    }

    .users-modal-header h3 {
        margin: 0 0 5px;
        color: #203653;
        font-size: 17px;
        font-weight: 700;
    }

    .users-modal-header p {
        margin: 0;
        color: #7b8798;
        font-size: 12px;
        line-height: 1.5;
    }

    .users-modal-close {
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

    .users-modal-close:hover {
        background: #f4f6f9;
        color: #203653;
    }

    .users-modal-body {
        padding: 20px 22px;
    }

    .users-form-group {
        margin-bottom: 16px;
    }

    .users-form-group label {
        display: block;
        margin-bottom: 7px;
        color: #40516a;
        font-size: 12px;
        font-weight: 600;
    }

    .users-form-group label span,
    .users-form-note span {
        color: #a13c3c;
    }

    .users-form-group input,
    .users-form-group select {
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

    .users-form-group input::placeholder {
        color: #a1aab7;
    }

    .users-form-group input:focus,
    .users-form-group select:focus {
        border-color: #8298b8;
        outline: none;
    }

    .users-form-note {
        margin: 6px 0 0;
        color: #7b8798;
        font-size: 12px;
        line-height: 1.6;
    }

    .users-delete-message {
        margin: 0;
        color: #526075;
        font-size: 14px;
        line-height: 1.7;
    }

    .users-delete-message strong {
        color: #263b59;
    }

    .users-modal-footer {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 9px;
        padding: 15px 22px;
        border-top: 1px solid #e9edf3;
        background: #fafbfd;
    }

    .users-modal-footer form {
        margin: 0;
    }

    @keyframes users-modal-appear {
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
        .users-summary {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .users-card-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .users-search {
            width: 100%;
        }
    }

    @media (max-width: 600px) {
        .users-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .users-title {
            font-size: 21px;
        }

        .users-summary {
            gap: 10px;
        }

        .users-summary-card {
            padding: 14px;
        }

        .users-summary-value {
            font-size: 22px;
        }

        .users-modal {
            padding: 10px;
        }

        .users-modal-dialog {
            max-height: calc(100vh - 20px);
        }

        .users-modal-header,
        .users-modal-body {
            padding: 17px;
        }

        .users-modal-footer {
            padding: 13px 17px;
            flex-wrap: wrap;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .users-modal-dialog {
            animation: none;
        }

        .users-button {
            transition: none;
        }
    }
</style>


{{-- ====================================================== --}}
{{-- JAVASCRIPT --}}
{{-- ====================================================== --}}

<script>
(function () {
    // Mencegah event listener terpasang berulang kali.
    if (window.usersManagementInitialized) {
        return;
    }

    window.usersManagementInitialized = true;

    function openUsersModal(modalId) {
        const modal = document.getElementById(modalId);

        if (!modal) {
            return;
        }

        // Tutup modal lain sebelum membuka modal yang dipilih.
        document.querySelectorAll('.users-modal.is-open').forEach(function (item) {
            item.classList.remove('is-open');
            item.setAttribute('aria-hidden', 'true');
        });

        modal.classList.add('is-open');
        modal.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';

        const firstInput = modal.querySelector(
            'input:not([type="hidden"]):not([type="password"]), select'
        );

        if (firstInput) {
            window.setTimeout(function () {
                firstInput.focus();
            }, 100);
        }
    }

    function closeUsersModal(modal) {
        if (!modal) {
            return;
        }

        modal.classList.remove('is-open');
        modal.setAttribute('aria-hidden', 'true');

        if (!document.querySelector('.users-modal.is-open')) {
            document.body.style.overflow = '';
        }
    }

    // Buka modal melalui tombol.
    document.addEventListener('click', function (event) {
        const openButton = event.target.closest('[data-users-open]');

        if (openButton) {
            event.preventDefault();
            openUsersModal(openButton.getAttribute('data-users-open'));
            return;
        }

        // Tutup modal melalui tombol batal atau tombol X.
        const closeButton = event.target.closest('[data-users-close]');

        if (closeButton) {
            event.preventDefault();
            closeUsersModal(closeButton.closest('.users-modal'));
            return;
        }

        // Tutup modal jika pengguna mengeklik bagian gelap di luar dialog.
        if (event.target.classList.contains('users-modal')) {
            closeUsersModal(event.target);
        }
    });

    // Tutup modal dengan tombol Escape.
    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            const openedModal = document.querySelector('.users-modal.is-open');

            if (openedModal) {
                closeUsersModal(openedModal);
            }
        }
    });

    // Pencarian pengguna berdasarkan nama, username, email, dan nomor HP.
    const searchInput = document.getElementById('users-search-input');

    if (searchInput) {
        searchInput.addEventListener('input', function () {
            const keyword = this.value.toLowerCase().trim();
            const rows = document.querySelectorAll(
                '#users-table-body .users-table-row'
            );

            let visibleCount = 0;

            rows.forEach(function (row) {
                const text = row.textContent.toLowerCase();
                const matched = text.includes(keyword);

                row.style.display = matched ? '' : 'none';

                if (matched) {
                    visibleCount++;
                }
            });

            const noResult = document.getElementById('users-no-search-result');

            if (noResult) {
                noResult.style.display =
                    rows.length > 0 && visibleCount === 0 ? '' : 'none';
            }
        });
    }

    // Jika validasi Laravel gagal, buka kembali modal yang sesuai.
    @if ($errors->any())
        @if (old('edit_user_id'))
            openUsersModal('users-edit-modal-{{ old('edit_user_id') }}');
        @else
            openUsersModal('users-add-modal');
        @endif
    @endif
})();
</script>