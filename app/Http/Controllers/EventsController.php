<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
     * Menyimpan pengajuan agenda.
     * Admin otomatis disetujui, Guru/Organisasi menunggu persetujuan.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'event_name' => 'required|string|max:255',
            'room_id' => 'required|exists:rooms,id',
            'category' => 'required|string|max:100',
            'description' => 'nullable|string|max:5000',
            'date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ], [
            'event_name.required' => 'Nama kegiatan wajib diisi.',
            'room_id.required' => 'Silakan pilih ruangan.',
            'room_id.exists' => 'Ruangan yang dipilih tidak ditemukan.',
            'category.required' => 'Kategori kegiatan wajib dipilih.',
            'date.required' => 'Tanggal kegiatan wajib diisi.',
            'date.after_or_equal' => 'Tanggal kegiatan tidak boleh di masa lalu.',
            'start_time.required' => 'Waktu mulai wajib diisi.',
            'end_time.required' => 'Waktu selesai wajib diisi.',
            'end_time.after' => 'Waktu selesai harus setelah waktu mulai.',
        ]);

        $isAdmin = (int) Auth::user()->role_id === 1;

        try {
            DB::transaction(function () use ($validated, $isAdmin) {
                $room = Room::where('id', $validated['room_id'])
                    ->where('is_active', 'Aktif')
                    ->lockForUpdate()
                    ->first();

                if (!$room) {
                    throw ValidationException::withMessages([
                        'room_id' => 'Ruangan tidak tersedia atau sudah tidak aktif.',
                    ]);
                }

                $isConflict = Event::where('room_id', $room->id)
                    ->where('date', $validated['date'])
                    ->whereIn('status', ['pending', 'approved'])
                    ->where('start_time', '<', $validated['end_time'])
                    ->where('end_time', '>', $validated['start_time'])
                    ->exists();

                if ($isConflict) {
                    throw ValidationException::withMessages([
                        'room_id' => 'Ruangan sudah memiliki agenda pada waktu tersebut. Silakan pilih ruangan atau waktu lain.',
                    ]);
                }

                Event::create([
                    'event_name' => $validated['event_name'],
                    'room_id' => $room->id,
                    'category' => $validated['category'],
                    'description' => $validated['description'] ?? null,
                    'date' => $validated['date'],
                    'start_time' => $validated['start_time'],
                    'end_time' => $validated['end_time'],
                    'pic_id' => Auth::id(),
                    'status' => $isAdmin ? 'approved' : 'pending',
                    'approve_by' => $isAdmin ? Auth::id() : null,
                ]);
            });
        } catch (ValidationException $e) {
            throw $e;
        }

        $message = $isAdmin
            ? 'Agenda berhasil ditambahkan dan otomatis disetujui.'
            : 'Pengajuan peminjaman berhasil dikirim dan menunggu persetujuan Admin/Waka.';

        return redirect()
            ->route('booking.index')
            ->with('success', $message);
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
        $result = DB::transaction(function () use ($id) {
            $event = Event::where('events_id', $id)
                ->lockForUpdate()
                ->first();

            if (!$event) {
                return 'not_found';
            }

            if ($event->status !== 'pending') {
                return 'processed';
            }

            $room = Room::where('id', $event->room_id)
                ->where('is_active', 'Aktif')
                ->lockForUpdate()
                ->first();

            if (!$room) {
                return 'room_inactive';
            }

            $isConflict = Event::where('room_id', $event->room_id)
                ->where('date', $event->date)
                ->where('events_id', '!=', $event->events_id)
                ->whereIn('status', ['pending', 'approved'])
                ->where('start_time', '<', $event->end_time)
                ->where('end_time', '>', $event->start_time)
                ->exists();

            if ($isConflict) {
                return 'conflict';
            }

            $event->update([
                'status' => 'approved',
                'approve_by' => Auth::id(),
            ]);

            return 'success';
        });

        if ($result !== 'success') {
            $messages = [
                'not_found' => 'Pengajuan tidak ditemukan.',
                'processed' => 'Pengajuan ini sudah diproses sebelumnya.',
                'room_inactive' => 'Ruangan sudah tidak aktif.',
                'conflict' => 'Pengajuan tidak dapat disetujui karena ruangan sudah digunakan pada waktu tersebut.',
            ];

            return redirect()
                ->route('admin.dashboard')
                ->with('approval_error', $messages[$result]);
        }

        return redirect()
            ->route('admin.dashboard')
            ->with('approval_success', 'Pengajuan peminjaman berhasil disetujui.');
    }

    /**
     * Menolak pengajuan peminjaman.
     */
    public function reject(Request $request, $id)
{
    $validated = $request->validate([
        'rejection_reason' => 'required|string|max:1000',
    ], [
        'rejection_reason.required' => 'Alasan penolakan wajib diisi.',
        'rejection_reason.max' => 'Alasan penolakan maksimal 1000 karakter.',
    ]);

    return DB::transaction(function () use ($id, $validated) {
        $event = Event::where('events_id', $id)
            ->lockForUpdate()
            ->first();

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
            'rejection_reason' => $validated['rejection_reason'],
        ]);

        return redirect()
            ->route('admin.dashboard')
            ->with('approval_success', 'Pengajuan peminjaman berhasil ditolak.');
    });
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
     */
    public function overrideRoom(Request $request, $id)
    {
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'move_reason' => 'required|string|max:1000',
        ], [
            'room_id.required' => 'Silakan pilih ruangan baru.',
            'room_id.exists' => 'Ruangan yang dipilih tidak ditemukan.',
            'move_reason.required' => 'Alasan pemindahan wajib diisi.',
            'move_reason.max' => 'Alasan pemindahan maksimal 1000 karakter.',
        ]);

        $result = DB::transaction(function () use ($validated, $id) {
            $event = Event::where('events_id', $id)
                ->lockForUpdate()
                ->first();

            if (!$event) {
                return 'not_found';
            }

            if ($event->status !== 'approved') {
                return 'not_approved';
            }

            $newRoom = Room::where('id', $validated['room_id'])
                ->where('is_active', 'Aktif')
                ->lockForUpdate()
                ->first();

            if (!$newRoom) {
                return 'room_inactive';
            }

            if ((int) $newRoom->id === (int) $event->room_id) {
                return 'same_room';
            }

            $isConflict = Event::where('room_id', $newRoom->id)
                ->where('date', $event->date)
                ->where('events_id', '!=', $event->events_id)
                ->whereIn('status', ['pending', 'approved'])
                ->where('start_time', '<', $event->end_time)
                ->where('end_time', '>', $event->start_time)
                ->exists();

            if ($isConflict) {
                return 'conflict';
            }

            $event->update([
                'room_id' => $newRoom->id,
                'move_reason' => $validated['move_reason'],
            ]);

            return 'success';
        });

        if ($result !== 'success') {
            $messages = [
                'not_found' => 'Agenda tidak ditemukan.',
                'not_approved' => 'Hanya agenda yang sudah disetujui yang dapat dipindahkan.',
                'room_inactive' => 'Ruangan baru tidak ditemukan atau sedang tidak aktif.',
                'same_room' => 'Pilih ruangan yang berbeda dari ruangan saat ini.',
                'conflict' => 'Ruangan tersebut sudah digunakan pada waktu yang sama.',
            ];

            return back()
                ->withInput()
                ->withErrors([
                    'room_id' => $messages[$result],
                ]);
        }

        return redirect()
            ->route('admin.dashboard')
            ->with(
                'success',
                'Ruangan berhasil dipindahkan dan alasan pemindahan berhasil disimpan.'
            );
    }
}
