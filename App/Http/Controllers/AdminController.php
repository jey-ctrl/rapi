<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Event;
use App\Models\Complaint;
use App\Models\User;

class AdminController extends Controller
{
    /**
     * Dashboard Admin / Waka.
     */
    public function index()
    {
        // Statistik dashboard
        $totalRooms = Room::count();

        $totalEvents = Event::where(
            'date',
            '>=',
            now()->toDateString()
        )->count();

        $totalUsers = User::count();

        $pendingComplaints = Complaint::where(
            'status_repair',
            '!=',
            'Sudah Diperbaiki'
        )->count();

        // Data pengguna beserta relasi Roles
        $users = User::with('roles')->get();

        // Data ruangan dan PIC
        $rooms = Room::with('pic')
            ->orderBy('room_name', 'asc')
            ->get();

        $picUsers = User::where('role_id', 2)
            ->orderBy('fullname', 'asc')
            ->get();

        // Agenda mendatang
        $upcomingEvents = Event::with([
            'room',
            'applicant'
        ])
            ->where('date', '>=', now()->toDateString())
            ->orderBy('date', 'asc')
            ->orderBy('start_time', 'asc')
            ->limit(10)
            ->get();

        // Seluruh agenda untuk tabel pemindahan ruangan
        $events = Event::with([
            'room',
            'applicant'
        ])
            ->orderBy('date', 'asc')
            ->orderBy('start_time', 'asc')
            ->get();

        $recentEvents = $events;

        // Data pengaduan yang belum selesai
        $complaints = Complaint::with([
            'room',
            'reporter',
            'handler'
        ])
            ->where('status_repair', '!=', 'Sudah Diperbaiki')
            ->latest()
            ->get();

        $recentComplaints = $complaints;
        $pendingReports = $complaints;

        // Pengajuan yang menunggu persetujuan Admin/Waka
        $pendingApprovals = Event::with([
            'room',
            'applicant'
        ])
            ->where('status', 'pending')
            ->orderBy('date', 'asc')
            ->orderBy('start_time', 'asc')
            ->get();

        // Penggunaan ruang yang sedang berlangsung hari ini
        $activeRoomUses = Event::with([
            'room',
            'applicant'
        ])
            ->where('status', 'approved')
            ->whereDate('date', now()->toDateString())
            ->where('start_time', '<=', now()->format('H:i:s'))
            ->where('end_time', '>=', now()->format('H:i:s'))
            ->orderBy('start_time', 'asc')
            ->get();

        // Kirim semua data ke dashboard Admin
        return view('admin.dashboard', compact(
            'totalRooms',
            'totalEvents',
            'totalUsers',
            'pendingComplaints',
            'users',
            'rooms',
            'picUsers',
            'upcomingEvents',
            'events',
            'recentEvents',
            'complaints',
            'recentComplaints',
            'pendingReports',
            'pendingApprovals',
            'activeRoomUses'
        ));
    }

    /**
     * Halaman pengelolaan data ruangan.
     */
    public function manageRooms()
    {
        $rooms = Room::with('pic')
            ->orderBy('room_name', 'asc')
            ->get();

        $picUsers = User::where('role_id', 2)
            ->orderBy('fullname', 'asc')
            ->get();

        return view('admin.data_ruang', compact(
            'rooms',
            'picUsers'
        ));
    }
}
