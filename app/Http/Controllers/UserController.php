<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Menampilkan halaman Data Pengguna.
     */
    public function index()
    {
        $users = User::with('roles')->get();

        return view('admin.data_pengguna', compact('users'));
    }

    /**
     * Menambahkan pengguna baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'fullname' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:6',
            'phone_number' => 'required|string|max:20',
            'role_id' => [
                'required',
                'integer',
                Rule::exists('roles', 'id'),
            ],
        ]);

        $user = User::create([
            'fullname' => $validated['fullname'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'phone_number' => $validated['phone_number'],
            'role_id' => $validated['role_id'],
        ]);

        if (!$request->wantsJson()) {
            return redirect()
                ->back()
                ->with('success', 'Pengguna baru berhasil ditambahkan.');
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Pengguna baru berhasil ditambahkan.',
            'data' => $user,
        ], 201);
    }

    /**
     * Memperbarui data pengguna.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'fullname' => 'sometimes|required|string|max:255',

            'username' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                Rule::unique('users', 'username')->ignore($user->id),
            ],

            'email' => [
                'sometimes',
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],

            'phone_number' => 'sometimes|required|string|max:20',

            'role_id' => [
                'sometimes',
                'required',
                'integer',
                Rule::exists('roles', 'id'),
            ],

            'password' => 'nullable|string|min:6',
        ]);

        if (isset($validated['fullname'])) {
            $user->fullname = $validated['fullname'];
        }

        if (isset($validated['username'])) {
            $user->username = $validated['username'];
        }

        if (isset($validated['email'])) {
            $user->email = $validated['email'];
        }

        if (isset($validated['phone_number'])) {
            $user->phone_number = $validated['phone_number'];
        }

        if (isset($validated['role_id'])) {
            $user->role_id = $validated['role_id'];
        }

        if (!empty($validated['password'])) {
            $user->password = $validated['password'];
        }

        $user->save();

        if (!$request->wantsJson()) {
            return redirect()
                ->back()
                ->with('success', 'Data pengguna berhasil diperbarui.');
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Data pengguna berhasil diperbarui.',
            'data' => $user,
        ], 200);
    }

    /**
     * Menghapus pengguna.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Mencegah pengguna menghapus akunnya sendiri.
        if ((int) $user->id === (int) auth()->id()) {
            return redirect()
                ->back()
                ->with('error', 'Anda tidak dapat menghapus akun yang sedang digunakan.');
        }

        // Memeriksa keterkaitan pengguna dengan data lain.
        $hasRelatedData =
            DB::table('rooms')
                ->where('pic_id', $id)
                ->exists()

            || DB::table('events')
                ->where('pic_id', $id)
                ->orWhere('approve_by', $id)
                ->exists()

            || DB::table('complaints')
                ->where('reporter_id', $id)
                ->exists();

        if ($hasRelatedData) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'Pengguna tidak dapat dihapus karena masih memiliki keterkaitan dengan data ruangan, peminjaman, atau pengaduan.'
                );
        }

        $user->delete();

        return redirect()
            ->back()
            ->with('success', 'Pengguna berhasil dihapus.');
    }
}
