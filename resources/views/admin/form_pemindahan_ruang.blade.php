
@extends('layouts.app')

@section('title', 'Pemindahan Ruangan')
@section('page-title', 'Pemindahan Ruangan')

@push('styles')
<style>
    .move-intro {
        margin-bottom: 22px;
    }

    .move-intro h2 {
        color: #17365d;
        font-size: 21px;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .move-intro p {
        color: #707985;
        font-size: 12px;
        margin: 0;
    }

    .move-info {
        padding: 20px;
        margin-bottom: 25px;
        background: #f7f9fc;
        border: 1px solid #e1e5ea;
        border-radius: 7px;
    }

    .move-info-title {
        color: #17365d;
        font-size: 14px;
        font-weight: 700;
        margin-bottom: 18px;
    }

    .move-info-main {
        margin-bottom: 18px;
    }

    .move-info-label {
        color: #707985;
        font-size: 11px;
        margin-bottom: 4px;
    }

    .move-info-value {
        color: #252b33;
        font-size: 13px;
        font-weight: 700;
    }

    .move-info-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 18px;
    }

    .move-status {
        display: inline-block;
        padding: 5px 11px;
        border-radius: 20px;
        background: #dcfce7;
        color: #166534;
        font-size: 10px;
        font-weight: 700;
    }

    .move-field {
        margin-bottom: 18px;
    }

    .move-field label {
        display: block;
        margin-bottom: 7px;
        color: #344054;
        font-size: 12px;
        font-weight: 700;
    }

    .move-field label span {
        color: #c0392b;
    }

    .move-field small {
        display: block;
        margin-top: 6px;
        color: #707985;
        font-size: 10px;
    }

    .move-field textarea {
        min-height: 110px;
        resize: vertical;
    }

    .move-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        padding-top: 18px;
        border-top: 1px solid #e1e5ea;
    }

    @media (max-width: 600px) {
        .move-info-grid {
            grid-template-columns: 1fr;
            gap: 13px;
        }

        .move-actions {
            flex-direction: column-reverse;
        }

        .move-actions .btn {
            width: 100%;
        }
    }
</style>
@endpush

@section('content')

<div class="move-intro">
    <h2>Form Pemindahan Ruangan</h2>
    <p>
        Atur perubahan ruangan untuk agenda yang telah disetujui.
    </p>
</div>

@if(session('error'))
    <div class="alert alert-danger">
        <i class="fas fa-exclamation-circle me-2"></i>
        {{ session('error') }}
    </div>
@endif

@if(session('success'))
    <div class="alert alert-success">
        <i class="fas fa-check-circle me-2"></i>
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger">
        <strong>Periksa kembali formulir:</strong>
        <ul class="mb-0 mt-2">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<section class="section">
    <div class="card">

        <div class="card-header">
            <h3>
                <i class="fas fa-calendar-alt me-2"></i>
                Informasi Agenda
            </h3>
        </div>

        <div class="card-body">

            <div class="move-info">
                <div class="move-info-main">
                    <div class="move-info-label">Nama Agenda</div>
                    <div class="move-info-value">
                        {{ $event->event_name }}
                    </div>
                </div>

                <div class="move-info-grid">

                    <div>
                        <div class="move-info-label">Ruangan Saat Ini</div>
                        <div class="move-info-value">
                            <i class="fas fa-door-open me-1"></i>
                            {{ $event->room->room_name ?? 'Tanpa Ruangan' }}
                        </div>
                    </div>

                    <div>
                        <div class="move-info-label">Tanggal Kegiatan</div>
                        <div class="move-info-value">
                            {{ $event->date
                                ? \Carbon\Carbon::parse($event->date)->format('d M Y')
                                : '-' }}
                        </div>
                    </div>

                    <div>
                        <div class="move-info-label">Waktu Kegiatan</div>
                        <div class="move-info-value">
                            {{ $event->start_time
                                ? substr((string) $event->start_time, 0, 5)
                                : '--:--' }}
                            -
                            {{ $event->end_time
                                ? substr((string) $event->end_time, 0, 5)
                                : '--:--' }}
                        </div>
                    </div>

                    <div>
                        <div class="move-info-label">Status Agenda</div>
                        <span class="move-status">
                            <i class="fas fa-check-circle me-1"></i>
                            Disetujui
                        </span>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>

<section class="section">
    <div class="card">

        <div class="card-header">
            <h3>
                <i class="fas fa-exchange-alt me-2"></i>
                Tentukan Ruangan Baru
            </h3>
        </div>

        <div class="card-body">

            <form
                action="{{ route('admin.events.override', $event->events_id) }}"
                method="POST"
            >
                @csrf
                @method('PUT')

                <div class="move-field">
                    <label for="room_id">
                        Ruangan Tujuan <span>*</span>
                    </label>

                    <select
                        name="room_id"
                        id="room_id"
                        class="form-select @error('room_id') is-invalid @enderror"
                        required
                    >
                        <option value="">-- Pilih Ruangan Tujuan --</option>

                        @foreach($rooms as $room)
                            @if((int) $room->id !== (int) $event->room_id)
                                <option
                                    value="{{ $room->id }}"
                                    @selected((string) old('room_id') === (string) $room->id)
                                >
                                    {{ $room->room_name }}
                                </option>
                            @endif
                        @endforeach
                    </select>

                    @error('room_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <small>
                        Pilih ruangan aktif selain ruangan yang sedang digunakan.
                    </small>
                </div>

                <div class="move-field">
                    <label for="move_reason">
                        Alasan Pemindahan <span>*</span>
                    </label>

                    <textarea
                        name="move_reason"
                        id="move_reason"
                        class="form-control @error('move_reason') is-invalid @enderror"
                        rows="4"
                        maxlength="1000"
                        placeholder="Tuliskan alasan pemindahan ruangan..."
                        required
                    >{{ old('move_reason') }}</textarea>

                    @error('move_reason')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <small>
                        Maksimal 1.000 karakter. Alasan pemindahan dapat
                        ditampilkan kepada Guru melalui notifikasi.
                    </small>
                </div>

                <div class="move-actions">
                    <a
                        href="{{ route('admin.events.manage') }}"
                        class="btn btn-secondary"
                    >
                        <i class="fas fa-arrow-left me-1"></i>
                        Batal
                    </a>

                    <button
                        type="submit"
                        class="btn btn-primary"
                        onclick="return confirm('Apakah Anda yakin ingin memindahkan agenda ini ke ruangan yang dipilih?')"
                    >
                        <i class="fas fa-save me-1"></i>
                        Simpan Pemindahan
                    </button>
                </div>

            </form>

        </div>
    </div>
</section>

@endsection
