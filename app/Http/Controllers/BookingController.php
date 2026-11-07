<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /**
     * Menampilkan halaman form peminjaman.
     */
    public function create()
    {
        $rooms = Room::all();

        return view('booking.create', compact('rooms'));
    }

    /**
     * Menyimpan pengajuan peminjaman ruangan.
     */
    public function store(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'event_name' => 'required|string|max:255',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ], [
            'room_id.required' => 'Ruangan wajib dipilih.',
            'room_id.exists' => 'Ruangan yang dipilih tidak ditemukan.',
            'event_name.required' => 'Nama kegiatan wajib diisi.',
            'date.required' => 'Tanggal kegiatan wajib diisi.',
            'start_time.required' => 'Jam mulai wajib diisi.',
            'end_time.required' => 'Jam selesai wajib diisi.',
            'end_time.after' => 'Jam selesai harus setelah jam mulai.',
        ]);

        // Cek bentrok hanya pada ruangan dan tanggal yang sama.
        $conflict = Event::where('room_id', $request->room_id)
            ->where('date', $request->date)
            ->where('status', 'approved')
            ->where('start_time', '<', $request->end_time)
            ->where('end_time', '>', $request->start_time)
            ->exists();

        if ($conflict) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'Gagal mengajukan peminjaman. Ruangan sudah digunakan oleh agenda yang disetujui pada waktu tersebut.'
                );
        }

        // Simpan pengajuan dengan status menunggu persetujuan.
        Event::create([
            'room_id' => $request->room_id,
            'pic_id' => Auth::id(),
            'event_name' => $request->event_name,
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'status' => 'pending',
        ]);

        return back()->with(
            'success',
            'Pengajuan peminjaman ruangan berhasil dikirim dan menunggu persetujuan Admin/Waka.'
        );
    }
}