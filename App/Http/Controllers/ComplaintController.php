<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComplaintController extends Controller
{
    /**
     * Menampilkan daftar pengaduan untuk Admin/Waka, Guru, dan PIC Ruang.
     */
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        // PIC Ruang
        if (
            $user->role_id == 2 ||
            $user->role === 'PIC Ruang'
        ) {
            $complaints = Complaint::whereHas('room', function ($query) use ($user) {
                $query->where('pic_id', $user->id);
            })
                ->with(['room', 'reporter', 'handler'])
                ->latest()
                ->get();
        }

        // Admin atau Waka
        elseif (
            $user->role_id == 1 ||
            in_array($user->role, ['Waka/Admin', 'Admin', 'Waka'])
        ) {
            $complaints = Complaint::with([
                'room.pic',
                'reporter',
                'handler'
            ])
                ->latest()
                ->get();
        }

        // Guru atau Organisasi
        else {
            $complaints = Complaint::where('reporter_id', $user->id)
                ->with(['room', 'handler'])
                ->latest()
                ->get();
        }

        $rooms = Room::all();

        return view('complaints.index', compact('complaints', 'rooms'));
    }

    /**
     * Guru/Organisasi mengirim laporan kerusakan.
     */
    public function store(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,room_id',
            'description' => 'required|string|min:5',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'room_id.required' => 'Pilih ruangan terlebih dahulu.',
            'room_id.exists' => 'Ruangan yang dipilih tidak ditemukan.',
            'description.required' => 'Deskripsi kerusakan wajib diisi.',
            'description.min' => 'Deskripsi kerusakan minimal 5 karakter.',
            'photo.image' => 'File yang diunggah harus berupa gambar.',
            'photo.max' => 'Ukuran foto maksimal 2 MB.',
        ]);

        $photoPath = null;

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');

            $filename = time() . '_' . uniqid() . '.' .
                $file->getClientOriginalExtension();

            $photoPath = $file->storeAs(
                'complaints',
                $filename,
                'public'
            );
        }

        Complaint::create([
            'room_id' => $request->room_id,
            'reporter_id' => Auth::id(),
            'description' => $request->description,
            'photo_path' => $photoPath,
            'status_repair' => 'Belum Diperbaiki',
            'reported_at' => now(),
        ]);

        return redirect()->back()->with(
            'success',
            'Laporan kerusakan fasilitas berhasil dikirim!'
        );
    }

    /**
     * PIC Ruang memperbarui status perbaikan.
     */
    public function updateStatus(Request $request, int $id)
    {
        $request->validate([
            'status_repair' => 'required|in:Belum Diperbaiki,Menunggu Spare Part,Sudah Diperbaiki',
        ]);

        $complaint = Complaint::with('room')->findOrFail($id);
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        // PIC hanya boleh memperbarui laporan di ruang yang menjadi tanggung jawabnya.
        if (
            ($user->role_id == 2 || $user->role === 'PIC Ruang') &&
            (!$complaint->room || $complaint->room->pic_id != $user->id)
        ) {
            return redirect()->back()->withErrors([
                'msg' => 'Anda tidak memiliki hak akses untuk mengubah status perbaikan di ruangan ini!',
            ]);
        }

        $complaint->update([
            'status_repair' => $request->status_repair,
            'handler_id' => $user->id,
        ]);

        return redirect()->back()->with(
            'success',
            'Status perbaikan fasilitas berhasil diperbarui!'
        );
    }

    /**
     * Admin/Waka membuka pesan peringatan melalui WhatsApp.
     */
    public function sendWaWarning(int $id)
    {
        $complaint = Complaint::with([
            'room.pic',
            'reporter'
        ])->findOrFail($id);

        $pic = $complaint->room->pic ?? null;

        if (!$pic || empty($pic->phone)) {
            return redirect()->back()->withErrors([
                'msg' => 'Nomor WhatsApp PIC ruangan tidak ditemukan atau belum diisi.',
            ]);
        }

        $phone = preg_replace(
            '/^0/',
            '62',
            preg_replace('/[^0-9]/', '', $pic->phone)
        );

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

        $waUrl = 'https://wa.me/' . $phone .
            '?text=' . urlencode($message);

        return redirect()->away($waUrl);
    }
}
