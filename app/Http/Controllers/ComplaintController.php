<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\Event;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class ComplaintController extends Controller
{
    /**
     * Menampilkan daftar pengaduan sesuai hak akses pengguna.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        // PIC hanya melihat pengaduan dari ruangan tanggung jawabnya.
        if ($user->role_id == 2 || $user->role === 'PIC Ruang') {
            $complaints = Complaint::whereHas('room', function ($query) use ($user) {
                $query->where('pic_id', $user->id);
            })
                ->with(['room', 'reporter'])
                ->latest()
                ->get();
        }

        // Admin/Waka dapat melihat seluruh pengaduan.
        elseif (
            $user->role_id == 1 ||
            in_array($user->role, ['Waka/Admin', 'Admin', 'Waka'], true)
        ) {
            $complaints = Complaint::with(['room.pic', 'reporter'])
                ->latest()
                ->get();
        }

        // Guru/Organisasi hanya melihat pengaduan miliknya sendiri.
        else {
            $complaints = Complaint::where('reporter_id', $user->id)
                ->with(['room', 'reporter'])
                ->latest()
                ->get();
        }

        $rooms = Room::orderBy('room_name')->get();

        // Jika halaman dibuka dari riwayat booking,
        // pastikan booking milik pengguna yang sedang login.
        $selectedEvent = null;

        if ($request->filled('event_id')) {
            $selectedEvent = Event::with('room')
                ->where('events_id', $request->event_id)
                ->where('pic_id', $user->id)
                ->first();

            if (!$selectedEvent) {
                return redirect()
                    ->route('complaints.index')
                    ->with('error', 'Data booking tidak ditemukan atau bukan milik akun Anda.');
            }
        }

        return view('complaint.index', compact(
            'complaints',
            'rooms',
            'selectedEvent'
        ));
    }

    /**
     * Membuka halaman pengaduan dari riwayat booking.
     */
    public function createFromBooking($id)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        $event = Event::where('events_id', $id)
            ->where('pic_id', $user->id)
            ->first();

        if (!$event) {
            return redirect()
                ->route('complaints.index')
                ->with('error', 'Booking tidak ditemukan atau bukan milik akun Anda.');
        }

        return redirect()->route('complaints.index', [
            'event_id' => $event->events_id,
        ]);
    }

    /**
     * Menyimpan laporan kerusakan.
     * Laporan dapat berasal dari booking atau laporan mandiri.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Hanya Admin dan Guru yang boleh mengirim laporan kerusakan.
        if (!in_array((int) $user->role_id, [1, 3], true)) {
            abort(403, 'Hanya Guru dan Admin yang dapat mengirim laporan kerusakan.');
        }

        $validated = $request->validate([
            'event_id' => 'nullable|integer',
            'room_id' => 'nullable|integer|exists:rooms,id',
            'description' => 'required|string|min:5',
            'camera_photo' => 'required|string|max:3000000',
        ], [
            'room_id.exists' => 'Ruangan yang dipilih tidak ditemukan.',
            'description.required' => 'Deskripsi kerusakan wajib diisi.',
            'description.min' => 'Deskripsi kerusakan minimal 5 karakter.',
            'camera_photo.required' => 'Foto kerusakan wajib diambil melalui kamera.',
            'camera_photo.string' => 'Foto kamera tidak valid.',
            'camera_photo.max' => 'Ukuran foto terlalu besar. Silakan ambil ulang.',
        ]);

        $event = null;

        // Jalur pertama: laporan berasal dari booking milik pengguna.
        if (!empty($validated['event_id'])) {
            $event = Event::where('events_id', $validated['event_id'])
                ->where('pic_id', $user->id)
                ->first();

            if (!$event) {
                return back()
                    ->withInput()
                    ->with('error', 'Booking tidak ditemukan atau bukan milik akun Anda.');
            }

            // Ruangan diambil dari data booking.
            $roomId = $event->room_id;
        } else {
            // Jalur kedua: laporan mandiri tanpa booking.
            $request->validate([
                'room_id' => 'required|exists:rooms,id',
            ], [
                'room_id.required' => 'Silakan pilih ruangan yang mengalami kerusakan.',
            ]);

            $roomId = $validated['room_id'];
        }

        $room = Room::find($roomId);

        if (!$room) {
            return back()
                ->withInput()
                ->with('error', 'Ruangan tidak ditemukan.');
        }

        $photoPath = $this->storeCameraPhoto(
            $validated['camera_photo'],
            'complaints'
        );

        try {
            Complaint::create([
                'room_id' => $roomId,
                'reporter_id' => $user->id,
                'event_id' => $event ? $event->events_id : null,
                'description' => $validated['description'],
                'photo_path' => $photoPath,
                'status_repair' => 'Belum Diperbaiki',
                'reported_at' => now()->toDateTimeString(),
            ]);
        } catch (\Throwable $exception) {
            Storage::disk('public')->delete($photoPath);
            throw $exception;
        }

        // Setelah laporan berhasil disimpan, kembali ke dashboard Guru.
        return redirect()
            ->route('guru.dashboard')
            ->with('success', 'Laporan kerusakan fasilitas berhasil dikirim!');
    }

    /**
     * PIC memperbarui status perbaikan secara berurutan.
     *
     * Belum Diperbaiki -> Menunggu Spare Part
     * Menunggu Spare Part -> Sudah Diperbaiki
     *
     * Foto hasil perbaikan wajib pada tahap terakhir.
     */
    public function updateStatus(Request $request, int $id)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Hanya PIC yang boleh mengubah status.
        if ((int) $user->role_id !== 2){
            abort(403, 'Hanya PIC Ruangan yang dapat mengubah status perbaikan.');
        }

        $validated = $request->validate([
            'status_repair' => 'required|in:Belum Diperbaiki,Menunggu Spare Part,Sudah Diperbaiki',
            'camera_photo' => 'required_if:status_repair,Sudah Diperbaiki|nullable|string|max:3000000',
        ], [
            'status_repair.required' => 'Status perbaikan wajib dikirim.',
            'camera_photo.required_if' => 'Foto hasil perbaikan wajib diambil melalui kamera.',
            'camera_photo.max' => 'Ukuran foto terlalu besar. Silakan ambil ulang.',
        ]);

        $complaint = Complaint::with('room')->findOrFail($id);

        // PIC hanya boleh menangani laporan di ruangan tanggung jawabnya.
        if (!$complaint->room || $complaint->room->pic_id != $user->id) {
            abort(403, 'Anda tidak memiliki hak akses untuk mengubah status laporan ini.');
        }

        // Status selesai tidak dapat diubah kembali.
        if ($complaint->status_repair === 'Sudah Diperbaiki') {
            return back()->with(
                'error',
                'Laporan ini sudah selesai diperbaiki dan statusnya terkunci.'
            );
        }

        // Tentukan satu-satunya status berikutnya yang diperbolehkan.
        $nextStatus = [
            'Belum Diperbaiki' => 'Menunggu Spare Part',
            'Menunggu Spare Part' => 'Sudah Diperbaiki',
        ];

        $expectedStatus = $nextStatus[$complaint->status_repair] ?? null;

        // Mencegah status dilewati atau dikembalikan.
        if (!$expectedStatus || $validated['status_repair'] !== $expectedStatus) {
            return back()->with(
                'error',
                'Perubahan status harus dilakukan secara berurutan.'
            );
        }

        $completionPhotoPath = null;

        // Foto wajib disimpan sebelum status selesai diubah.
        if ($expectedStatus === 'Sudah Diperbaiki') {
            $completionPhotoPath = $this->storeCameraPhoto(
                $validated['camera_photo'],
                'complaints/completed'
            );

            $complaint->completion_photo_path = $completionPhotoPath;
        }

        $complaint->status_repair = $expectedStatus;

        try {
            $complaint->save();
        } catch (\Throwable $exception) {
            // Jika penyimpanan database gagal, hapus foto yang baru dibuat.
            if ($completionPhotoPath) {
                Storage::disk('public')->delete($completionPhotoPath);
            }

            throw $exception;
        }

        return back()->with(
            'success',
            $expectedStatus === 'Sudah Diperbaiki'
                ? 'Perbaikan berhasil diselesaikan dan foto bukti berhasil disimpan!'
                : 'Status berhasil diperbarui menjadi Menunggu Spare Part.'
        );
    }

    /**
     * Memvalidasi dan menyimpan gambar yang dikirim sebagai Data URL.
     */
    private function storeCameraPhoto(string $dataUrl, string $directory): string
    {
        $matched = preg_match(
            '~\Adata:image/(jpeg|png|webp);base64,([A-Za-z0-9+/=\r\n]+)\z~',
            $dataUrl,
            $matches
        );

        if (!$matched) {
            throw ValidationException::withMessages([
                'camera_photo' => 'Format foto tidak valid. Silakan ambil foto melalui kamera.',
            ]);
        }

        $imageData = base64_decode($matches[2], true);

        if ($imageData === false || strlen($imageData) > 2 * 1024 * 1024) {
            throw ValidationException::withMessages([
                'camera_photo' => 'Foto tidak valid atau melebihi batas 2 MB.',
            ]);
        }

        $imageInfo = @getimagesizefromstring($imageData);

        if (
            !$imageInfo ||
            !in_array($imageInfo['mime'], [
                'image/jpeg',
                'image/png',
                'image/webp',
            ], true)
        ) {
            throw ValidationException::withMessages([
                'camera_photo' => 'Format foto tidak didukung atau isi gambar tidak valid.',
            ]);
        }

        $extension = match ($imageInfo['mime']) {
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/webp' => 'webp',
            default => null,
        };

        if (!$extension) {
            throw ValidationException::withMessages([
                'camera_photo' => 'Format foto tidak valid.',
            ]);
        }

        $filename = uniqid('camera_', true) . '.' . $extension;
        $path = trim($directory, '/') . '/' . $filename;

        $stored = Storage::disk('public')->put($path, $imageData);

        if (!$stored) {
            throw ValidationException::withMessages([
                'camera_photo' => 'Foto gagal disimpan. Silakan ambil ulang.',
            ]);
        }

        return $path;
    }

    /**
     * Admin/Waka membuka pesan peringatan melalui WhatsApp.
     */
    public function sendWaWarning(int $id)
    {
        $complaint = Complaint::with([
            'room.pic',
            'reporter',
        ])->findOrFail($id);

        $pic = $complaint->room->pic ?? null;

        if (!$pic || empty($pic->phone_number)) {
            return redirect()->back()->withErrors([
                'msg' => 'Nomor WhatsApp PIC ruangan tidak ditemukan atau belum diisi.',
            ]);
        }

        $phone = preg_replace(
            '/^0/',
            '62',
            preg_replace('/[^0-9]/', '', $pic->phone_number)
        );

        if (!$phone || strlen($phone) < 10 || strlen($phone) > 15) {
    return redirect()->back()->withErrors([
        'msg' => 'Nomor WhatsApp PIC tidak valid.',
    ]);
}

        $picName = $pic->fullname ?? $pic->name ?? 'PIC Ruangan';
        $roomName = $complaint->room->room_name ?? '-';

        $reporterName = $complaint->reporter->fullname
            ?? $complaint->reporter->name
            ?? 'Anonim';

        $message =
            "PERINGATAN PENANGANAN KERUSAKAN FASILITAS\n\n" .
            "Kepada Yth. Bapak/Ibu {$picName} (PIC Ruangan {$roomName}),\n\n" .
            "Mohon segera menindaklanjuti laporan kerusakan berikut:\n" .
            "Ruangan: {$roomName}\n" .
            "Pelapor: {$reporterName}\n" .
            "Rincian Kerusakan: {$complaint->description}\n" .
            "Status Perbaikan: {$complaint->status_repair}\n\n" .
            "Mohon segera memperbarui status perbaikan pada sistem. Terima kasih.";

        $waUrl = 'https://wa.me/' . $phone . '?text=' . urlencode($message);

        return redirect()->away($waUrl);
    }
}