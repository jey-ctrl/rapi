<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class EventsController extends Controller
{
    /**
     * Menampilkan seluruh agenda.
     */
    public function index()
    {
        $events = Event::with(['room', 'applicant'])
            ->orderBy('date', 'asc')
            ->orderBy('start_time', 'asc')
            ->get();

        return view('events.index', compact('events'));
    }

    /**
     * Menampilkan halaman pengajuan peminjaman.
     */
    public function create()
    {
        $rooms = Room::where('is_active', 'Aktif')
            ->orderBy('room_name', 'asc')
            ->get();

        return view('booking.index', compact('rooms'));
    }

    /**
     * Menyimpan pengajuan agenda dari Guru/Organisasi.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'event_name' => 'required|string|max:255',
            'room_id' => 'required|exists:rooms,id',
            'date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ], [
            'event_name.required' => 'Nama kegiatan wajib diisi.',
            'room_id.required' => 'Silakan pilih ruangan.',
            'room_id.exists' => 'Ruangan yang dipilih tidak ditemukan.',
            'date.required' => 'Tanggal kegiatan wajib diisi.',
            'date.after_or_equal' => 'Tanggal kegiatan tidak boleh di masa lalu.',
            'start_time.required' => 'Waktu mulai wajib diisi.',
            'end_time.required' => 'Waktu selesai wajib diisi.',
            'end_time.after' => 'Waktu selesai harus setelah waktu mulai.',
        ]);

        $room = Room::where('id', $validated['room_id'])
            ->where('is_active', 'Aktif')
            ->first();

        if (!$room) {
            return back()
                ->withInput()
                ->with('error', 'Ruangan tidak tersedia atau sudah tidak aktif.');
        }

        Event::create([
            'event_name' => $validated['event_name'],
            'room_id' => $room->id,
            'date' => $validated['date'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'pic_id' => Auth::id(),
            'status' => 'pending',
        ]);

        return redirect()
            ->route('booking.index')
            ->with(
                'success',
                'Pengajuan peminjaman berhasil dikirim dan menunggu persetujuan Admin/Waka.'
            );
    }

    /**
     * Menampilkan daftar pengajuan yang menunggu persetujuan.
     */
    public function manage()
    {
        $pendingApprovals = Event::with(['room', 'applicant'])
            ->where('status', 'pending')
            ->orderBy('date', 'asc')
            ->orderBy('start_time', 'asc')
            ->get();

        return view(
            'admin.persetujuan_peminjaman',
            compact('pendingApprovals')
        );
    }

    /**
     * Menyetujui pengajuan peminjaman.
     */
    public function approve($id)
    {
        $event = Event::find($id);

        if (!$event) {
            return redirect()
                ->route('admin.dashboard')
                ->with('approval_error', 'Pengajuan tidak ditemukan.');
        }

        if ($event->status !== 'pending') {
            return redirect()
                ->route('admin.dashboard')
                ->with('approval_error', 'Pengajuan ini sudah diproses sebelumnya.');
        }

        $isConflict = Event::where('room_id', $event->room_id)
            ->where('date', $event->date)
            ->where('events_id', '!=', $event->events_id)
            ->where('status', 'approved')
            ->where('start_time', '<', $event->end_time)
            ->where('end_time', '>', $event->start_time)
            ->exists();

        if ($isConflict) {
            return redirect()
                ->route('admin.dashboard')
                ->with(
                    'approval_error',
                    'Pengajuan tidak dapat disetujui karena ruangan sudah digunakan pada waktu tersebut.'
                );
        }

        $event->update([
            'status' => 'approved',
            'approve_by' => Auth::id(),
        ]);

        return redirect()
            ->route('admin.dashboard')
            ->with('approval_success', 'Pengajuan peminjaman berhasil disetujui.');
    }

    /**
     * Menolak pengajuan peminjaman.
     */
    public function reject($id)
    {
        $event = Event::find($id);

        if (!$event) {
            return redirect()
                ->route('admin.dashboard')
                ->with('approval_error', 'Pengajuan tidak ditemukan.');
        }

        if ($event->status !== 'pending') {
            return redirect()
                ->route('admin.dashboard')
                ->with('approval_error', 'Pengajuan ini sudah diproses sebelumnya.');
        }

        $event->update([
            'status' => 'rejected',
            'approve_by' => Auth::id(),
        ]);

        return redirect()
            ->route('admin.dashboard')
            ->with('approval_success', 'Pengajuan peminjaman berhasil ditolak.');
    }

    /**
     * Menampilkan agenda yang sudah disetujui untuk pemindahan ruangan.
     */
    public function manageOverride()
    {
        $events = Event::with('room')
            ->where('status', 'approved')
            ->orderBy('date', 'asc')
            ->orderBy('start_time', 'asc')
            ->get();

        return view('admin.pemindahan_ruang', compact('events'));
    }

    /**
     * Menampilkan formulir pemindahan ruangan.
     */
    public function moveForm($id)
    {
        $event = Event::with('room')
            ->where('status', 'approved')
            ->findOrFail($id);

        $rooms = Room::where('is_active', 'Aktif')
            ->where('id', '!=', $event->room_id)
            ->orderBy('room_name', 'asc')
            ->get();

        return view(
            'admin.form_pemindahan_ruang',
            compact('event', 'rooms')
        );
    }

    /**
     * Memindahkan agenda ke ruangan lain.
     * Setelah berhasil, kembali ke Dashboard Admin.
     */
    public function overrideRoom(Request $request, $id)
    {
        $event = Event::find($id);

        if (!$event) {
            return redirect()
                ->route('admin.dashboard')
                ->with('error', 'Agenda tidak ditemukan.');
        }

        if ($event->status !== 'approved') {
            return redirect()
                ->route('admin.dashboard')
                ->with(
                    'error',
                    'Hanya agenda yang sudah disetujui yang dapat dipindahkan.'
                );
        }

        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'move_reason' => 'required|string|max:1000',
        ], [
            'room_id.required' => 'Silakan pilih ruangan baru.',
            'room_id.exists' => 'Ruangan yang dipilih tidak ditemukan.',
            'move_reason.required' => 'Alasan pemindahan wajib diisi.',
            'move_reason.max' => 'Alasan pemindahan maksimal 1000 karakter.',
        ]);

        $newRoom = Room::where('id', $validated['room_id'])
            ->where('is_active', 'Aktif')
            ->first();

        if (!$newRoom) {
            return back()
                ->withInput()
                ->with('error', 'Ruangan baru tidak ditemukan atau sedang tidak aktif.');
        }

        if ((int) $newRoom->id === (int) $event->room_id) {
            throw ValidationException::withMessages([
                'room_id' => 'Pilih ruangan yang berbeda dari ruangan saat ini.',
            ]);
        }

        // Periksa bentrok dengan agenda lain di ruangan tujuan.
        $isConflict = Event::where('room_id', $newRoom->id)
            ->where('date', $event->date)
            ->where('events_id', '!=', $event->events_id)
            ->where('status', 'approved')
            ->where('start_time', '<', $event->end_time)
            ->where('end_time', '>', $event->start_time)
            ->exists();

        if ($isConflict) {
            return back()
                ->withInput()
                ->withErrors([
                    'room_id' => 'Ruangan tersebut sudah digunakan pada waktu yang sama.',
                ]);
        }

        // Simpan perubahan ruangan dan alasan pemindahan.
        $event->update([
            'room_id' => $newRoom->id,
            'move_reason' => $validated['move_reason'],
        ]);

        // Kembali ke Dashboard Admin setelah berhasil.
        return redirect()
            ->route('admin.dashboard')
            ->with(
                'success',
                'Ruangan berhasil dipindahkan dan alasan pemindahan berhasil disimpan.'
            );
    }
}
