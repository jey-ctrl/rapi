<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Event;
use App\Models\Complaint;
use Illuminate\Support\Facades\Auth;

class GuruController extends Controller
{
    /**
     * Menampilkan dashboard Guru/Organisasi.
     */
    public function index()
    {
        $userId = Auth::id();

        // Agenda milik Guru/Organisasi yang login.
        $myEvents = Event::with('room')
            ->where('pic_id', $userId)
            ->orderBy('date', 'desc')
            ->get();

        // Agenda milik pengguna yang pernah dipindahkan.
        $movedEvents = Event::with('room')
            ->where('pic_id', $userId)
            ->whereNotNull('move_reason')
            ->where('move_reason', '!=', '')
            ->orderBy('updated_at', 'desc')
            ->get();

        // Laporan kerusakan milik pengguna.
        $myComplaints = Complaint::with('room')
            ->where('reporter_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        // Daftar ruangan.
        $rooms = Room::all();

        return view('guru.dashboard', compact(
            'myEvents',
            'movedEvents',
            'myComplaints',
            'rooms'
        ));
    }
}
