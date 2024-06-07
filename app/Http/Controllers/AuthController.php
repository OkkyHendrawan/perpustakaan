<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Menampilkan halaman login
    public function login()
    {
        return view('auth.login');
    }

    // Proses autentikasi login
    public function AuthLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Jika autentikasi berhasil, arahkan ke halaman dashboard dengan pesan sukses
            return redirect()->intended('admin/dashboard')->with('success', 'Login berhasil!');
        }

        // Jika autentikasi gagal, kembali ke halaman login dengan pesan error
        return redirect()->back()->with('error', 'Invalid credentials');
    }


   // Proses logout
   public function logout()
    {
        Auth::logout();
        return redirect(url(''))->with('success', 'Anda telah berhasil logout.');
    }


    public function showRegistrationForm()
    {
        return view('auth.register');
    }

}

