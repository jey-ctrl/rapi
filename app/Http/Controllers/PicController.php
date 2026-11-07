<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\Room;
use Illuminate\Support\Facades\Auth;

class PicController extends Controller
{
    public function index()
    {
        $picId = Auth::id();

        // 1. Ambil ruangan yang menjadi tanggung jawab PIC
        $myRooms = Room::where('pic_id', $picId)->get();

        // 2. Ambil pengaduan dari ruangan yang ditangani PIC
        $myComplaints = Complaint::with(['room', 'reporter'])
            ->whereHas('room', function ($query) use ($picId) {
                $query->where('pic_id', $picId);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        // 3. Hitung statistik pengaduan
        $totalAssignedRooms = $myRooms->count();

        $pendingCount = $myComplaints
            ->where('status_repair', 'Belum Diperbaiki')
            ->count();

        $inProgressCount = $myComplaints
            ->where('status_repair', 'Menunggu Spare Part')
            ->count();

        $completedCount = $myComplaints
            ->where('status_repair', 'Sudah Diperbaiki')
            ->count();

        // 4. Tampilkan dashboard PIC
        return view('pic.dashboard', compact(
            'myRooms',
            'myComplaints',
            'totalAssignedRooms',
            'pendingCount',
            'inProgressCount',
            'completedCount'
        ));
    }
}