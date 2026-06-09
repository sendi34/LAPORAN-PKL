<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:5',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Redirect berdasarkan role
            if ($user->role === 'admin') {
                return redirect('/admin/dashboard')
                ->with('success', 'Login berhasil! Selamat datang, ' . $user->nama . '.');
            }

            if ($user->role === 'petugas') {
                return redirect('/petugas/dashboard')
                ->with('success', 'Login berhasil! Selamat datang, ' . $user->nama . '.');
            }

            return redirect('/');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah!',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        return redirect('/login')
        ->with('success', 'Logout berhasil! Sampai jumpa.');
    }
}
