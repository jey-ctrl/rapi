<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Menampilkan halaman Data Pengguna
     */
    public function index()
    {
        $users = User::all();

        return view('admin.data_pengguna', compact('users'));
    }

    /**
     * Menambahkan pengguna baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'fullname'     => 'required|string|max:255',
            'username'     => 'required|string|max:255|unique:users,username',
            'email'        => 'required|email|unique:users,email',
            'password'     => 'required|string|min:6',
            'phone_number' => 'nullable|string|max:20',
            'role_id'      => 'required|integer',
        ]);

        $user = User::create([
            'fullname'     => $request->fullname,
            'username'     => $request->username,
            'email'        => $request->email,
            'password'     => Hash::make($request->password),
            'phone_number' => $request->phone_number,
            'role_id'      => $request->role_id,
        ]);

        if (!$request->wantsJson()) {
            return redirect()
                ->back()
                ->with('success', 'Pengguna baru berhasil ditambahkan.');
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Pengguna baru berhasil ditambahkan.',
            'data'    => $user
        ], 201);
    }

    /**
     * Memperbarui data pengguna
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'fullname'     => 'sometimes|required|string|max:255',
            'username'     => 'sometimes|required|string|max:255|unique:users,username,' . $id,
            'email'        => 'sometimes|required|email|unique:users,email,' . $id,
            'phone_number' => 'nullable|string|max:20',
            'role_id'      => 'sometimes|required|integer',
            'password'     => 'nullable|string|min:6',
        ]);

        if ($request->has('fullname')) {
            $user->fullname = $request->fullname;
        }

        if ($request->has('username')) {
            $user->username = $request->username;
        }

        if ($request->has('email')) {
            $user->email = $request->email;
        }

        if ($request->has('phone_number')) {
            $user->phone_number = $request->phone_number;
        }

        if ($request->has('role_id')) {
            $user->role_id = $request->role_id;
        }

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        if (!$request->wantsJson()) {
            return redirect()
                ->back()
                ->with('success', 'Data pengguna berhasil diperbarui.');
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Data pengguna berhasil diperbarui.',
            'data'    => $user
        ], 200);
    }

    /**
     * Menghapus pengguna
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        return redirect()
            ->back()
            ->with('success', 'Pengguna berhasil dihapus.');
    }
}