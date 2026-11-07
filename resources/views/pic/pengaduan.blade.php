
{{-- PENGADUAN KERUSAKAN --}}
<div id="pengaduan-table" class="card">
    <div class="card-header">
        <div>
            <h3>Pengaduan Kerusakan Fasilitas Ruangan</h3>
            <p>Periksa laporan dan perbarui status penanganan kerusakan fasilitas sekolah.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success" style="margin: 20px;">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger" style="margin: 20px;">{{ session('error') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger" style="margin: 20px;">{{ $errors->first() }}</div>
    @endif

    <div class="card-body">
        <div class="table-responsive">
            <table class="pic-complaint-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tgl Lapor</th>
                        <th>Ruangan</th>
                        <th>Pelapor</th>
                        <th>Deskripsi</th>
                        <th>Foto Kerusakan</th>
                        <th>Status</th>
                        <th>Foto Perbaikan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($myComplaints as $index => $complaint)
                        @php
                            $isCompleted = $complaint->status_repair === 'Sudah Diperbaiki';

                            $nextStatus = match($complaint->status_repair) {
                                'Belum Diperbaiki' => 'Menunggu Spare Part',
                                'Menunggu Spare Part' => 'Sudah Diperbaiki',
                                default => null,
                            };
                        @endphp

                        <tr>
                            <td class="column-number">{{ $index + 1 }}</td>

                            <td class="column-date">
                                {{ $complaint->created_at?->format('d-m-Y H:i') ?? '-' }}
                            </td>

                            <td class="column-room">
                                <strong>{{ $complaint->room->room_name ?? '-' }}</strong>
                            </td>

                            <td class="column-reporter">
                                {{ $complaint->reporter->fullname ?? '-' }}
                            </td>

                            <td class="column-description">
                                {{ $complaint->description }}
                            </td>

                            <td class="column-photo">
                                @if($complaint->photo_path)
                                    <a href="{{ asset('storage/' . $complaint->photo_path) }}"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="btn btn-primary btn-sm">
                                        Lihat Foto
                                    </a>
                                @else
                                    <span class="badge bg-secondary">Tidak ada foto</span>
                                @endif
                            </td>

                            <td class="column-status">
                                @if($complaint->status_repair === 'Belum Diperbaiki')
                                    <span class="badge bg-danger">Belum Diperbaiki</span>
                                @elseif($complaint->status_repair === 'Menunggu Spare Part')
                                    <span class="badge bg-warning">Menunggu Spare Part</span>
                                @elseif($isCompleted)
                                    <span class="badge bg-success">Sudah Diperbaiki</span>
                                @else
                                    <span class="badge bg-secondary">{{ $complaint->status_repair }}</span>
                                @endif
                            </td>

                            <td class="column-completion-photo">
                                @if($complaint->completion_photo_path)
                                    <a href="{{ asset('storage/' . $complaint->completion_photo_path) }}"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="btn btn-success btn-sm">
                                        Lihat Foto
                                    </a>
                                @else
                                    <span class="badge bg-secondary">Belum ada</span>
                                @endif
                            </td>

                            <td class="column-action">
                                @if($isCompleted)
                                    <span class="badge bg-success">Penanganan Selesai</span>

                                    <p class="completed-note">
                                        Status sudah terkunci dan tidak dapat diubah kembali.
                                    </p>

                                @elseif($nextStatus)
                                    <form class="pic-status-form"
                                        action="{{ route('pic.complaints.update', $complaint->id) }}"
                                        method="POST">

                                        @csrf
                                        @method('PUT')

                                        <input type="hidden" name="status_repair" value="{{ $nextStatus }}">

                                        <div class="next-status">
                                            <strong>Status berikutnya:</strong>

                                            <div>
                                                <span class="badge {{ $nextStatus === 'Sudah Diperbaiki' ? 'bg-success' : 'bg-warning' }}">
                                                    {{ $nextStatus }}
                                                </span>
                                            </div>
                                        </div>

                                        @if($nextStatus === 'Sudah Diperbaiki')
                                            <div class="camera-area">
                                                <input type="hidden" name="camera_photo" class="camera-photo-input">

                                                <video class="camera-video"
                                                    autoplay
                                                    playsinline
                                                    style="display:none;"></video>

                                                <canvas style="display:none;"></canvas>

                                                <img class="camera-preview"
                                                    alt="Preview foto hasil perbaikan"
                                                    style="display:none;">

                                                <button type="button"
                                                    class="btn btn-secondary btn-sm camera-retry"
                                                    style="display:none;">
                                                    Buka Kamera
                                                </button>

                                                <button type="button"
                                                    class="btn btn-primary btn-sm camera-capture"
                                                    style="display:none;">
                                                    Ambil Foto
                                                </button>

                                                <button type="button"
                                                    class="btn btn-warning btn-sm camera-retake"
                                                    style="display:none;">
                                                    Ambil Ulang
                                                </button>

                                                <small class="camera-instruction">
                                                    Kamera akan terbuka setelah PIC mengonfirmasi penyelesaian perbaikan.
                                                    Foto hasil perbaikan wajib diambil langsung melalui kamera.
                                                </small>

                                                <small class="camera-error" style="display:none;"></small>
                                            </div>
                                        @endif

                                        <button type="submit"
                                            class="btn btn-primary btn-sm status-submit">
                                            {{ $nextStatus === 'Sudah Diperbaiki' ? 'Selesaikan Perbaikan' : 'Lanjutkan Penanganan' }}
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="9" class="empty-row">
                                Belum ada pengaduan kerusakan di ruangan tanggung jawab Anda.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    /* Container tabel */
    #pengaduan-table {
        width: 100%;
        overflow: hidden;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
    }

    #pengaduan-table .table-responsive {
        width: 100%;
        overflow-x: auto;
        padding: 0;
    }

    /* Struktur tabel */
    #pengaduan-table .pic-complaint-table {
        width: 100%;
        min-width: 1150px;
        table-layout: fixed;
        border-collapse: collapse;
        margin: 0;
    }

    #pengaduan-table .pic-complaint-table th,
    #pengaduan-table .pic-complaint-table td {
        padding: 15px 10px;
        vertical-align: middle;
        text-align: left;
        border-bottom: 1px solid #e8edf3;
        line-height: 1.6;
        overflow-wrap: break-word;
    }

    #pengaduan-table .pic-complaint-table th {
        background: #f3f5f8;
        color: #344054;
        font-size: 12px;
        font-weight: 700;
    }

    #pengaduan-table .pic-complaint-table td {
        color: #344054;
        font-size: 13px;
        background: #fff;
    }

    #pengaduan-table .pic-complaint-table tbody tr:hover td {
        background: #fafbfd;
    }

    /* Lebar masing-masing kolom */
    #pengaduan-table .column-number {
        width: 4%;
        text-align: center !important;
    }

    #pengaduan-table .column-date {
        width: 11%;
        font-size: 12px !important;
    }

    #pengaduan-table .column-room {
        width: 9%;
    }

    #pengaduan-table .column-reporter {
        width: 12%;
    }

    #pengaduan-table .column-description {
        width: 17%;
        min-width: 0;
    }

    #pengaduan-table .column-photo {
        width: 9%;
    }

    #pengaduan-table .column-status {
        width: 10%;
    }

    #pengaduan-table .column-completion-photo {
        width: 9%;
    }

    #pengaduan-table .column-action {
        width: 19%;
        min-width: 0;
    }

    /* Badge */
    #pengaduan-table .badge {
        display: inline-block;
        max-width: 100%;
        padding: 5px 8px;
        white-space: normal;
        text-align: center;
        line-height: 1.4;
        font-size: 11px;
    }

    /* Tombol */
    #pengaduan-table .btn {
        font-size: 11px;
        font-weight: 600;
        white-space: normal;
        line-height: 1.5;
        padding: 8px 10px;
    }

    /* Kolom aksi */
    #pengaduan-table .column-action .pic-status-form {
        width: 100%;
    }

    #pengaduan-table .next-status {
        margin-bottom: 12px;
    }

    #pengaduan-table .next-status strong {
        display: block;
        font-size: 12px;
        margin-bottom: 6px;
    }

    #pengaduan-table .status-submit {
        display: block;
        width: 100%;
        min-height: 40px;
        padding: 9px 8px;
    }

    #pengaduan-table .completed-note {
        margin-top: 8px;
        font-size: 11px;
        color: #707985;
    }

    /* Kamera */
    #pengaduan-table .camera-area {
        width: 100%;
        box-sizing: border-box;
        padding: 10px;
        margin: 10px 0;
        border: 1px solid #e1e5ea;
        border-radius: 7px;
        background: #f8f9fa;
    }

    #pengaduan-table .camera-area button {
        width: 100%;
        margin-bottom: 7px;
        cursor: pointer;
    }

    #pengaduan-table .camera-video,
    #pengaduan-table .camera-preview {
        width: 100%;
        max-height: 180px;
        object-fit: contain;
        border-radius: 5px;
        background: #222;
        margin-bottom: 8px;
    }

    #pengaduan-table .camera-instruction {
        display: block;
        color: #707985;
        font-size: 10px;
        line-height: 1.6;
    }

    #pengaduan-table .camera-error {
        display: block;
        color: #b42318;
        font-size: 11px;
        margin-top: 6px;
    }

    #pengaduan-table .empty-row {
        text-align: center !important;
        padding: 30px !important;
        color: #707985 !important;
    }

    /* Tampilan layar kecil */
    @media (max-width: 768px) {
        #pengaduan-table .pic-complaint-table {
            min-width: 1150px;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('#pengaduan-table .pic-status-form').forEach(function(form) {
            const statusInput = form.querySelector('input[name="status_repair"]');
            const submitButton = form.querySelector('.status-submit');
            const cameraArea = form.querySelector('.camera-area');

            // Tahap pertama: konfirmasi perubahan status.
            if (!cameraArea) {
                form.addEventListener('submit', function(event) {
                    const nextStatus = statusInput.value;

                    const approved = confirm(
                        'Lanjutkan penanganan dan ubah status menjadi "' + nextStatus + '"?'
                    );

                    if (!approved) event.preventDefault();
                });

                return;
            }

            // Tahap terakhir: kamera untuk foto bukti perbaikan.
            const video = cameraArea.querySelector('.camera-video');
            const canvas = cameraArea.querySelector('canvas');
            const preview = cameraArea.querySelector('.camera-preview');
            const photoInput = cameraArea.querySelector('.camera-photo-input');
            const captureButton = cameraArea.querySelector('.camera-capture');
            const retakeButton = cameraArea.querySelector('.camera-retake');
            const retryButton = cameraArea.querySelector('.camera-retry');
            const instruction = cameraArea.querySelector('.camera-instruction');
            const errorMessage = cameraArea.querySelector('.camera-error');

            let cameraStream = null;
            let confirmationAccepted = false;

            function stopCamera() {
                if (cameraStream) {
                    cameraStream.getTracks().forEach(function(track) {
                        track.stop();
                    });

                    cameraStream = null;
                }

                video.srcObject = null;
            }

            async function openCamera() {
                errorMessage.style.display = 'none';

                if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                    showCameraError(
                        'Kamera tidak tersedia. Gunakan localhost atau HTTPS dan browser yang mendukung kamera.'
                    );
                    return;
                }

                try {
                    stopCamera();

                    cameraStream = await navigator.mediaDevices.getUserMedia({
                        video: {
                            facingMode: {
                                ideal: 'environment'
                            },
                            width: {
                                ideal: 1280
                            },
                            height: {
                                ideal: 720
                            }
                        },
                        audio: false
                    });

                    video.srcObject = cameraStream;
                    await video.play();

                    video.style.display = 'block';
                    preview.style.display = 'none';
                    captureButton.style.display = 'block';
                    retryButton.style.display = 'none';
                    retakeButton.style.display = 'none';

                    instruction.textContent =
                        'Arahkan kamera ke hasil perbaikan, lalu tekan Ambil Foto.';

                } catch (error) {
                    console.error(error);

                    showCameraError(
                        'Kamera gagal dibuka. Izinkan akses kamera pada browser, lalu tekan Buka Kamera untuk mencoba lagi.'
                    );
                }
            }

            function showCameraError(message) {
                errorMessage.textContent = message;
                errorMessage.style.display = 'block';
                retryButton.style.display = 'block';
                captureButton.style.display = 'none';
                video.style.display = 'none';
            }

            form.addEventListener('submit', function(event) {
                // Konfirmasi pertama sebelum kamera dibuka.
                if (!confirmationAccepted) {
                    event.preventDefault();

                    const approved = confirm(
                        'Apakah perbaikan benar-benar sudah selesai? Setelah dikonfirmasi, kamera akan dibuka untuk mengambil foto bukti. Status baru berubah setelah foto berhasil dikirim.'
                    );

                    if (!approved) return;

                    confirmationAccepted = true;
                    submitButton.disabled = true;
                    submitButton.textContent = 'Menyiapkan Kamera...';

                    openCamera().finally(function() {
                        submitButton.disabled = false;
                        submitButton.textContent = 'Selesaikan Perbaikan';
                    });

                    return;
                }

                // Foto wajib tersedia sebelum form dikirim.
                if (!photoInput.value) {
                    event.preventDefault();
                    alert('Silakan ambil foto hasil perbaikan terlebih dahulu.');
                    return;
                }

                const approvedSend = confirm(
                    'Kirim foto bukti dan tetapkan status menjadi "Sudah Diperbaiki"? Status yang selesai tidak dapat diubah kembali.'
                );

                if (!approvedSend) {
                    event.preventDefault();
                    return;
                }

                submitButton.disabled = true;
                submitButton.textContent = 'Mengirim Foto...';

                stopCamera();
            });

            retryButton.addEventListener('click', openCamera);

            captureButton.addEventListener('click', function() {
                if (!video.videoWidth || !video.videoHeight) {
                    alert('Kamera belum siap. Silakan tunggu sebentar.');
                    return;
                }

                const maxWidth = 1280;
                const scale = Math.min(1, maxWidth / video.videoWidth);

                canvas.width = Math.round(video.videoWidth * scale);
                canvas.height = Math.round(video.videoHeight * scale);

                const context = canvas.getContext('2d');

                context.drawImage(
                    video,
                    0,
                    0,
                    canvas.width,
                    canvas.height
                );

                const imageData = canvas.toDataURL('image/jpeg', 0.75);

                photoInput.value = imageData;
                preview.src = imageData;

                video.style.display = 'none';
                preview.style.display = 'block';
                captureButton.style.display = 'none';
                retakeButton.style.display = 'block';

                instruction.textContent =
                    'Periksa foto. Jika sudah sesuai, tekan Selesaikan Perbaikan.';

                stopCamera();

                submitButton.textContent = 'Kirim Foto & Selesaikan';
            });

            retakeButton.addEventListener('click', function() {
                photoInput.value = '';
                preview.removeAttribute('src');
                preview.style.display = 'none';
                retakeButton.style.display = 'none';

                submitButton.textContent = 'Selesaikan Perbaikan';

                openCamera();
            });

            window.addEventListener('beforeunload', stopCamera);
        });
    });
</script>
