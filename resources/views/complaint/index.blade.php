
@extends('layouts.app')

@section('title', 'Pengaduan Kerusakan')
@section('page-title', 'Pengaduan Kerusakan')

@php
    $currentUser = auth()->user();
    $roleId = (int) ($currentUser->role_id ?? 0);
    $canReport = in_array($roleId, [1, 3], true);
    $isAdmin = $roleId === 1;
    $isPic = $roleId === 2;
    $isBookingReport = isset($selectedEvent) && $selectedEvent;
@endphp

@push('styles')
<style>
    .complaint-heading {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        margin-bottom: 22px;
        flex-wrap: wrap;
    }

    .complaint-heading h2 {
        color: #17365d;
        font-size: 21px;
        font-weight: 700;
        margin: 0 0 5px;
    }

    .complaint-heading p {
        color: #707985;
        font-size: 12px;
        margin: 0;
    }

    .complaint-list {
        display: flex;
        flex-direction: column;
        gap: 14px;
    }

    .complaint-item {
        background: #fff;
        border: 1px solid #e1e5ea;
        border-radius: 8px;
        padding: 19px 21px;
    }

    .complaint-item-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 12px;
        flex-wrap: wrap;
        margin-bottom: 12px;
    }

    .complaint-room {
        color: #17365d;
        font-size: 15px;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .complaint-date {
        color: #84909d;
        font-size: 11px;
    }

    .complaint-description {
        color: #475467;
        font-size: 13px;
        line-height: 1.7;
        margin: 12px 0;
        white-space: pre-line;
    }

    .complaint-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        color: #667085;
        font-size: 11px;
        margin-top: 12px;
    }

    .complaint-meta strong {
        color: #344054;
    }

    .complaint-status {
        display: inline-block;
        padding: 6px 11px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 700;
        white-space: nowrap;
    }

    .status-pending {
        color: #b42318;
        background: #fef3f2;
    }

    .status-waiting {
        color: #854a0e;
        background: #fff7e6;
    }

    .status-completed {
        color: #027a48;
        background: #ecfdf3;
    }

    .complaint-photo {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-top: 14px;
    }

    .complaint-photo a {
        color: #24558a;
        font-size: 11px;
        font-weight: 600;
        text-decoration: none;
    }

    .complaint-photo a:hover {
        text-decoration: underline;
    }

    .empty-history {
        text-align: center;
        background: #fff;
        border: 1px dashed #cbd5e1;
        border-radius: 8px;
        padding: 45px 20px;
    }

    .empty-history i {
        color: #9aa8b8;
        font-size: 35px;
        margin-bottom: 12px;
    }

    .empty-history h3 {
        color: #344054;
        font-size: 15px;
        font-weight: 700;
    }

    .empty-history p {
        color: #84909d;
        font-size: 12px;
        margin: 0;
    }

    .report-form-section {
        display: none;
        margin-bottom: 22px;
    }

    .report-form-section.show {
        display: block;
    }

    .report-form-section .card {
        border: 1px solid #dce3eb;
    }

    .report-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 17px;
    }

    .report-field {
        margin-bottom: 16px;
    }

    .report-field label {
        display: block;
        margin-bottom: 7px;
        color: #344054;
        font-size: 12px;
        font-weight: 700;
    }

    .report-field label span {
        color: #c0392b;
    }

    .report-field small {
        display: block;
        margin-top: 6px;
        color: #84909d;
        font-size: 10px;
    }

    .report-field input[readonly] {
        background: #f5f6f8 !important;
    }

    .camera-box {
        padding: 17px;
        border: 1px dashed #b8c5d5;
        border-radius: 7px;
        background: #f8fafc;
    }

    #camera-video,
    #camera-preview {
        display: block;
        width: 100%;
        max-width: 600px;
        max-height: 350px;
        margin: 0 auto 14px;
        border-radius: 6px;
        background: #17212f;
        object-fit: contain;
    }

    #camera-video[hidden],
    #camera-preview[hidden],
    .camera-actions button[hidden] {
        display: none !important;
    }

    .camera-actions,
    .form-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 9px;
        justify-content: flex-end;
    }

    .camera-actions {
        justify-content: flex-start;
    }

    .camera-message {
        display: block;
        margin-top: 10px;
        color: #667085;
        font-size: 11px;
    }

    @media (max-width: 700px) {
        .report-grid {
            grid-template-columns: 1fr;
            gap: 0;
        }

        .complaint-item {
            padding: 15px;
        }

        .complaint-heading {
            align-items: flex-start;
        }

        .complaint-heading .btn {
            width: 100%;
        }

        .form-actions {
            flex-direction: column-reverse;
        }

        .form-actions .btn {
            width: 100%;
        }
    }
</style>
@endpush

@section('content')

@if(session('success'))
    <div class="alert alert-success">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger">
        {{ $errors->first() }}
    </div>
@endif

<div class="complaint-heading">
    <div>
        <h2>Riwayat Pengaduan Kerusakan</h2>
        <p>
            @if($isAdmin)
                Pantau seluruh laporan kerusakan fasilitas sekolah.
            @elseif($isPic)
                Daftar laporan kerusakan pada ruangan tanggung jawab Anda.
            @else
                Lihat seluruh riwayat laporan kerusakan yang pernah Anda kirim.
            @endif
        </p>
    </div>

    @if($canReport)
        <button type="button" class="btn btn-primary" id="show-report-form">
            <i class="fas fa-plus me-1"></i> Laporkan Kerusakan
        </button>
    @endif
</div>

@if($canReport)
<section class="report-form-section {{ $isBookingReport || $errors->any() ? 'show' : '' }}"
         id="report-form-section">

    <div class="card">
        <div class="card-header">
            <h3>
                <i class="fas fa-file-circle-plus me-2"></i>
                {{ $isBookingReport ? 'Laporan Kerusakan dari Peminjaman' : 'Formulir Laporan Kerusakan' }}
            </h3>
            <span class="text-danger" style="font-size:10px;">* Wajib diisi</span>
        </div>

        <div class="card-body">
            <form id="damage-report-form"
                  action="{{ route('complaints.store') }}"
                  method="POST">
                @csrf

                @if($isBookingReport)
                    <input type="hidden" name="event_id" value="{{ $selectedEvent->events_id }}">
                    <input type="hidden" name="room_id" value="{{ $selectedEvent->room_id }}">
                @endif

                <div class="report-grid">
                    <div class="report-field">
                        <label>Nama Pelapor</label>
                        <input type="text"
                               class="form-control"
                               value="{{ $currentUser->fullname ?? $currentUser->name ?? '-' }}"
                               readonly>
                        <small>Identitas mengikuti akun yang sedang login.</small>
                    </div>

                    <div class="report-field">
                        <label>Nama Ruangan <span>*</span></label>

                        @if($isBookingReport)
                            <input type="text"
                                   class="form-control"
                                   value="{{ $selectedEvent->room->room_name ?? 'Ruangan tidak ditemukan' }}"
                                   readonly>
                            <small>Ruangan diambil otomatis dari data peminjaman.</small>
                        @else
                            <select name="room_id" class="form-select" required>
                                <option value="">-- Pilih Ruangan --</option>
                                @foreach($rooms as $room)
                                    <option value="{{ $room->id }}"
                                        {{ old('room_id') == $room->id ? 'selected' : '' }}>
                                        {{ $room->room_name }}
                                    </option>
                                @endforeach
                            </select>
                            <small>Pilih ruangan yang mengalami kerusakan.</small>
                        @endif
                    </div>
                </div>

                @if($isBookingReport)
                    <div class="report-grid">
                        <div class="report-field">
                            <label>Nama Kegiatan</label>
                            <input type="text" class="form-control"
                                   value="{{ $selectedEvent->event_name }}" readonly>
                        </div>

                        <div class="report-field">
                            <label>Tanggal Peminjaman</label>
                            <input type="text" class="form-control"
                                   value="{{ $selectedEvent->date ? \Carbon\Carbon::parse($selectedEvent->date)->format('d M Y') : '-' }}"
                                   readonly>
                        </div>
                    </div>
                @endif

                <div class="report-field">
                    <label for="description">Deskripsi Kerusakan <span>*</span></label>
                    <textarea id="description"
                              name="description"
                              class="form-control"
                              rows="4"
                              minlength="5"
                              required
                              placeholder="Jelaskan bagian yang rusak dan kondisi kerusakannya...">{{ old('description') }}</textarea>
                </div>

                <div class="report-field">
                    <label>Foto Kerusakan <span>*</span></label>
                    <small class="mb-2">
                        Foto wajib diambil langsung melalui kamera perangkat.
                    </small>

                    <div class="camera-box">
                        <video id="camera-video" autoplay playsinline hidden></video>
                        <canvas id="camera-canvas" hidden></canvas>
                        <img id="camera-preview" alt="Pratinjau foto kerusakan" hidden>

                        <input type="hidden" name="camera_photo" id="camera-photo-input">

                        <div class="camera-actions">
                            <button type="button" id="camera-start" class="btn btn-secondary">
                                <i class="fas fa-camera"></i> Buka Kamera
                            </button>

                            <button type="button" id="camera-capture"
                                    class="btn btn-primary" hidden>
                                <i class="fas fa-camera"></i> Ambil Foto
                            </button>

                            <button type="button" id="camera-retake"
                                    class="btn btn-warning" hidden>
                                <i class="fas fa-redo"></i> Ambil Ulang
                            </button>
                        </div>

                        <small id="camera-message" class="camera-message">
                            Tekan Buka Kamera untuk mengaktifkan kamera perangkat.
                        </small>
                    </div>
                </div>

                <div class="form-actions mt-4">
                    <button type="button" class="btn btn-secondary" id="cancel-report">
                        Batal
                    </button>

                    <button type="submit" id="submit-report" class="btn btn-primary">
                        <i class="fas fa-paper-plane"></i> Kirim Laporan
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>
@endif

@if(isset($complaints) && $complaints->isNotEmpty())
    <div class="complaint-list">
        @foreach($complaints as $complaint)
            <article class="complaint-item">
                <div class="complaint-item-top">
                    <div>
                        <div class="complaint-room">
                            <i class="fas fa-door-open me-1"></i>
                            {{ $complaint->room->room_name ?? 'Ruangan tidak ditemukan' }}
                        </div>

                        <div class="complaint-date">
                            <i class="far fa-calendar-alt me-1"></i>
                            {{ $complaint->created_at?->format('d M Y, H:i') ?? '-' }}
                        </div>
                    </div>

                    <div>
                        @if($complaint->status_repair === 'Sudah Diperbaiki')
                            <span class="complaint-status status-completed">
                                Sudah Diperbaiki
                            </span>
                        @elseif($complaint->status_repair === 'Menunggu Spare Part')
                            <span class="complaint-status status-waiting">
                                Menunggu Spare Part
                            </span>
                        @else
                            <span class="complaint-status status-pending">
                                Belum Diperbaiki
                            </span>
                        @endif
                    </div>
                </div>

                <div class="complaint-description">
                    {{ $complaint->description }}
                </div>

                <div class="complaint-meta">
                    @if($isAdmin || $isPic)
                        <span>
                            <strong>Pelapor:</strong>
                            {{ $complaint->reporter->fullname ?? $complaint->reporter->name ?? '-' }}
                        </span>
                    @endif

                    @if($isAdmin)
                        <span>
                            <strong>PIC:</strong>
                            {{ $complaint->room->pic->fullname ?? $complaint->room->pic->name ?? '-' }}
                        </span>
                    @endif
                </div>

                <div class="complaint-photo">
                    @if($complaint->photo_path)
                        <a href="{{ asset('storage/' . $complaint->photo_path) }}"
                           target="_blank" rel="noopener noreferrer">
                            <i class="fas fa-image me-1"></i> Foto Kerusakan
                        </a>
                    @endif

                    @if($complaint->completion_photo_path)
                        <a href="{{ asset('storage/' . $complaint->completion_photo_path) }}"
                           target="_blank" rel="noopener noreferrer">
                            <i class="fas fa-check-circle me-1"></i> Foto Hasil Perbaikan
                        </a>
                    @endif
                </div>
            </article>
        @endforeach
    </div>
@else
    <div class="empty-history">
        <i class="fas fa-clipboard-list"></i>
        <h3>Belum Ada Riwayat Pengaduan</h3>
        <p>
            @if($isPic)
                Belum ada laporan kerusakan pada ruangan yang menjadi tanggung jawab Anda.
            @else
                Riwayat laporan kerusakan akan muncul di sini setelah laporan dikirim.
            @endif
        </p>
    </div>
@endif

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const formSection = document.getElementById('report-form-section');
    const showFormButton = document.getElementById('show-report-form');
    const cancelButton = document.getElementById('cancel-report');

    const form = document.getElementById('damage-report-form');
    const video = document.getElementById('camera-video');
    const canvas = document.getElementById('camera-canvas');
    const preview = document.getElementById('camera-preview');
    const photoInput = document.getElementById('camera-photo-input');

    const startButton = document.getElementById('camera-start');
    const captureButton = document.getElementById('camera-capture');
    const retakeButton = document.getElementById('camera-retake');
    const message = document.getElementById('camera-message');
    const submitButton = document.getElementById('submit-report');

    let cameraStream = null;

    function stopCamera() {
        if (cameraStream) {
            cameraStream.getTracks().forEach(track => track.stop());
            cameraStream = null;
        }

        if (video) {
            video.srcObject = null;
        }
    }

    if (showFormButton && formSection) {
        showFormButton.addEventListener('click', function () {
            formSection.classList.add('show');
            showFormButton.hidden = true;
            formSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
    }

    if (cancelButton && formSection) {
        cancelButton.addEventListener('click', function () {
            stopCamera();
            formSection.classList.remove('show');

            if (showFormButton) {
                showFormButton.hidden = false;
            }
        });
    }

    if (!form || !video || !canvas || !preview || !photoInput) {
        return;
    }

    async function openCamera() {
        message.textContent = '';

        if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
            message.textContent = 'Kamera tidak tersedia. Gunakan HTTPS atau localhost.';
            return;
        }

        try {
            stopCamera();

            cameraStream = await navigator.mediaDevices.getUserMedia({
                video: {
                    facingMode: { ideal: 'environment' },
                    width: { ideal: 1280 },
                    height: { ideal: 720 }
                },
                audio: false
            });

            video.srcObject = cameraStream;
            await video.play();

            video.hidden = false;
            preview.hidden = true;
            startButton.hidden = true;
            captureButton.hidden = false;
            retakeButton.hidden = true;

            message.textContent = 'Arahkan kamera ke bagian yang rusak, lalu tekan Ambil Foto.';
        } catch (error) {
            console.error(error);
            message.textContent = 'Kamera gagal dibuka. Periksa izin kamera browser atau perangkat.';
            startButton.hidden = false;
            captureButton.hidden = true;
        }
    }

    startButton.addEventListener('click', openCamera);

    captureButton.addEventListener('click', function () {
        if (!video.videoWidth || !video.videoHeight) {
            message.textContent = 'Kamera belum siap. Tunggu sebentar lalu coba kembali.';
            return;
        }

        const maxWidth = 1280;
        const scale = Math.min(1, maxWidth / video.videoWidth);

        canvas.width = Math.round(video.videoWidth * scale);
        canvas.height = Math.round(video.videoHeight * scale);

        const context = canvas.getContext('2d');
        context.drawImage(video, 0, 0, canvas.width, canvas.height);

        const imageData = canvas.toDataURL('image/jpeg', 0.75);

        photoInput.value = imageData;
        preview.src = imageData;

        video.hidden = true;
        preview.hidden = false;
        captureButton.hidden = true;
        retakeButton.hidden = false;

        message.textContent = 'Periksa foto. Jika belum sesuai, tekan Ambil Ulang.';
        stopCamera();
    });

    retakeButton.addEventListener('click', function () {
        photoInput.value = '';
        preview.removeAttribute('src');
        preview.hidden = true;
        retakeButton.hidden = true;
        openCamera();
    });

    form.addEventListener('submit', function (event) {
        if (!photoInput.value) {
            event.preventDefault();
            alert('Silakan ambil foto kerusakan melalui kamera terlebih dahulu.');
            return;
        }

        if (!confirm('Apakah Anda yakin ingin mengirim laporan kerusakan ini?')) {
            event.preventDefault();
            return;
        }

        submitButton.disabled = true;
        submitButton.innerHTML = 'Mengirim Laporan...';
        stopCamera();
    });

    window.addEventListener('beforeunload', stopCamera);
});
</script>
@endpush
