<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Menampilkan halaman profil pengguna.
     */
    public function index()
    {
        $user = auth()->user();

        return view('profile.index', compact('user'));
    }

    /**
     * Memperbarui informasi profil pengguna.
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'fullname' => [
                'required',
                'string',
                'max:255',
            ],

            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users', 'username')->ignore($user->id),
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],

            'phone_number' => [
                'required',
                'string',
                'max:20',
            ],

            'profile_photo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ]);

        if ($request->hasFile('profile_photo')) {
            $newPhoto = $request->file('profile_photo')
                ->store('profile-photos', 'public');

            $oldPhoto = $user->profile_photo;

            $user->profile_photo = $newPhoto;

            if ($oldPhoto) {
                Storage::disk('public')->delete($oldPhoto);
            }
        }

        $user->fullname = $validated['fullname'];
        $user->username = $validated['username'];
        $user->email = $validated['email'];
        $user->phone_number = $validated['phone_number'];

        $user->save();

        return redirect()
            ->route('profile.index')
            ->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Memperbarui password pengguna.
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => [
                'required',
                'current_password',
            ],

            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'different:current_password',
            ],
        ]);

        $user = auth()->user();

        $user->password = $validated['password'];
        $user->save();

        return redirect()
            ->route('profile.index')
            ->with('success', 'Password berhasil diperbarui.');
    }
}
