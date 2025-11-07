<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Petugas;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Session::has('petugas')) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $petugas = Petugas::where('username', $request->username)->first();

        if ($petugas && Hash::check($request->password, $petugas->password)) {
            Session::put('petugas', $petugas);
            
            // Check if AJAX request
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Login berhasil! Selamat datang, ' . $petugas->nama_petugas,
                    'redirect' => route('dashboard')
                ]);
            }
            
            return redirect()->route('dashboard')->with('success', 'Login berhasil!');
        }

        // Check if AJAX request
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'Username atau password salah!'
            ], 401);
        }

        return back()->with('error', 'Username atau password salah!');
    }

    public function logout()
    {
        Session::forget('petugas');
        return redirect()->route('login')->with('success', 'Logout berhasil!');
    }
}
