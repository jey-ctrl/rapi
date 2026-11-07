<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RoomController extends Controller
{
    /**
     * Menampilkan seluruh data ruangan.
     */
    public function index()
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

    /**
     * Menambahkan ruangan baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'pic_id' => [
                'required',
                'integer',
                Rule::exists('users', 'id')
                    ->where('role_id', 2),
            ],
            'is_active' => [
                'required',
                Rule::in(['Aktif', 'Nonaktif']),
            ],
        ]);

        Room::create($validated);

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Ruangan baru berhasil ditambahkan.');
    }

    /**
     * Memperbarui data ruangan.
     */
    public function update(Request $request, $id)
    {
        $room = Room::findOrFail($id);

        $validated = $request->validate([
            'room_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'pic_id' => [
                'required',
                'integer',
                Rule::exists('users', 'id')
                    ->where('role_id', 2),
            ],
            'is_active' => [
                'required',
                Rule::in(['Aktif', 'Nonaktif']),
            ],
        ]);

        $room->update($validated);

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Data ruangan berhasil diperbarui.');
    }

    /**
     * Menghapus data ruangan.
     */
    public function destroy($id)
    {
        $room = Room::findOrFail($id);

        // Mencegah penghapusan jika masih memiliki agenda
        // atau laporan kerusakan agar data terkait tidak hilang.
        if ($room->events()->exists() || $room->complaints()->exists()) {
            return redirect()
                ->route('admin.dashboard')
                ->with(
                    'error',
                    'Ruangan tidak dapat dihapus karena masih memiliki riwayat peminjaman atau laporan kerusakan. Ubah status ruangan menjadi Nonaktif.'
                );
        }

        $room->delete();

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Ruangan berhasil dihapus.');
    }
}
