<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ], [
            'username.required' => 'Username wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $roleId = Auth::user()->role_id;

            if (!$roleId) {
                Auth::logout();

                return back()->withErrors([
                    'username' => 'Akun belum memiliki role. Silakan hubungi administrator.',
                ]);
            }

            return match ((int) $roleId) {
                1 => redirect()->route('admin.dashboard'),
                2 => redirect()->route('pic.dashboard'),
                3 => redirect()->route('guru.dashboard'),
                default => redirect('/calendar')->with(
                    'warning',
                    'Role akun tidak dikenali.'
                ),
            };
        }

        return back()->withErrors([
            'username' => 'Login gagal. Username atau password salah.',
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}