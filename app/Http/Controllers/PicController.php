<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\Room;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class PicController extends Controller
{
    public function index()
    {
        $picId = Auth::id();

        // 1. Ambil daftar ruangan yang menjadi tanggung jawab PIC ini
        $myRooms = Room::where('pic_id', $picId)->get();

        // 2. Ambil seluruh pengaduan dari ruangan yang dipegang oleh PIC ini (SOLUSI ERROR SQL)
        $myComplaints = Complaint::with(['room', 'reporter'])
            ->whereHas('room', function ($query) use ($picId) {
                $query->where('pic_id', $picId);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        // 3. Menghitung statistik widget card
        $totalAssignedRooms = $myRooms->count();
        $pendingCount       = $myComplaints->where('status_repair', 'Belum Diperbaiki')->count();
        $inProgressCount    = $myComplaints->where('status_repair', 'Menunggu Spare Part')->count();
        $completedCount     = $myComplaints->where('status_repair', 'Sudah Diperbaiki')->count();

        // 4. Memanggil resources/views/pic/dashboard.blade.php
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