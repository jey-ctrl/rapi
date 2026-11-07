<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\User;
use App\Models\Event;
use App\Models\Complaint;

class AdminController extends Controller
{
    /**
     * Dashboard Admin / Waka.
     */
    public function index()
    {
        $totalRooms = Room::count();
        $totalEvents = Event::count();
        $totalUsers = User::count();

        $pendingComplaints = Complaint::where(
            'status_repair',
            '!=',
            'Sudah Diperbaiki'
        )->count();

        $users = User::with('roles')
            ->orderBy('fullname')
            ->get();

        $rooms = Room::with('pic')
            ->orderBy('room_name')
            ->get();

        $picUsers = User::where('role_id', 2)
            ->orderBy('fullname')
            ->get();

        $events = Event::with(['room', 'applicant'])
            ->orderBy('date', 'desc')
            ->orderBy('start_time')
            ->get();

        $pendingApprovals = Event::with(['room', 'applicant'])
            ->where('status', 'pending')
            ->orderBy('date')
            ->orderBy('start_time')
            ->get();

        $complaints = Complaint::with(['room', 'reporter'])
            ->latest()
            ->get();

        $recentComplaints = $complaints;
        $pendingReports = $complaints;

        $upcomingEvents = Event::with(['room', 'applicant'])
            ->where('status', 'approved')
            ->whereDate('date', '>=', now()->toDateString())
            ->orderBy('date')
            ->orderBy('start_time')
            ->get();

        $recentEvents = Event::with(['room', 'applicant'])
            ->latest('created_at')
            ->take(5)
            ->get();

        $activeRoomUses = Event::with(['room', 'applicant'])
            ->where('status', 'approved')
            ->whereDate('date', now()->toDateString())
            ->orderBy('start_time')
            ->get();

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
     * Halaman persetujuan peminjaman.
     */
    public function manageApprovals()
    {
        $pendingApprovals = Event::with(['room', 'applicant'])
            ->where('status', 'pending')
            ->orderBy('date')
            ->orderBy('start_time')
            ->get();

        return view('admin.persetujuan', compact(
            'pendingApprovals'
        ));
    }

    /**
     * Halaman pengelolaan data ruangan.
     */
    public function manageRooms()
    {
        $rooms = Room::with('pic')
            ->orderBy('room_name')
            ->get();

        $picUsers = User::where('role_id', 2)
            ->orderBy('fullname')
            ->get();

        return view('admin.data_ruang', compact(
            'rooms',
            'picUsers'
        ));
    }
}
