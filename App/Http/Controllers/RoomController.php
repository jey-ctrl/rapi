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
            'room_name' => [
                'required',
                'string',
                'max:255',
            ],
            'location' => [
                'required',
                'string',
                'max:255',
            ],
            'capacity' => [
                'required',
                'integer',
                'min:1',
            ],
            'pic_id' => [
                'nullable',
                'integer',
                Rule::exists('users', 'id')
                    ->where('role_id', 2),
            ],
            'is_active' => [
                'required',
                'boolean',
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
            'room_name' => [
                'required',
                'string',
                'max:255',
            ],
            'location' => [
                'required',
                'string',
                'max:255',
            ],
            'capacity' => [
                'required',
                'integer',
                'min:1',
            ],
            'pic_id' => [
                'nullable',
                'integer',
                Rule::exists('users', 'id')
                    ->where('role_id', 2),
            ],
            'is_active' => [
                'required',
                'boolean',
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

        $room->delete();

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Ruangan berhasil dihapus.');
    }
}
