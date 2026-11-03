<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    // Method ini yang dipanggil oleh Route::get('/login')
    public function showLoginForm()
    {
        return view('login'); // Memanggil resources/views/login.blade.php
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $roleId = Auth::user()->role_id;

            // Redirect ke dashboard sesuai role_id
            return match ((int)$roleId) {
                1 => redirect()->route('admin.dashboard'),
                2 => redirect()->route('pic.dashboard'),
                3 => redirect()->route('guru.dashboard'),
                default => redirect('/calendar'),
            };
        }

        return back()->withErrors([
            'username' => 'Username atau password yang dimasukkan salah.',
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