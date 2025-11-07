<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\Petugas;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * Show the login form
     */
    public function showLogin(): RedirectResponse|View
    {
        if (Session::has('petugas')) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    /**
     * Handle login request
     */
    public function login(LoginRequest $request): JsonResponse|RedirectResponse
    {
        $petugas = Petugas::where('username', $request->validated()['username'])->first();

        if (!$petugas || !Hash::check($request->validated()['password'], $petugas->password)) {
            return $this->handleLoginFailure($request);
        }

        Session::put('petugas', $petugas);

        return $this->handleLoginSuccess($request, $petugas);
    }

    /**
     * Handle logout request
     */
    public function logout(): RedirectResponse
    {
        Session::forget('petugas');
        return redirect()->route('login')->with('success', 'Logout berhasil!');
    }

    /**
     * Handle successful login response
     */
    private function handleLoginSuccess($request, Petugas $petugas): JsonResponse|RedirectResponse
    {
        $message = 'Login berhasil! Selamat datang, ' . $petugas->nama_petugas;

        if ($this->isJsonRequest($request)) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'redirect' => route('dashboard')
            ], 200);
        }

        return redirect()->route('dashboard')->with('success', 'Login berhasil!');
    }

    /**
     * Handle failed login response
     */
    private function handleLoginFailure($request): JsonResponse|RedirectResponse
    {
        $message = 'Username atau password salah!';

        if ($this->isJsonRequest($request)) {
            return response()->json([
                'success' => false,
                'message' => $message
            ], 401);
        }

        return back()->with('error', $message);
    }

    /**
     * Check if request expects JSON response
     */
    private function isJsonRequest($request): bool
    {
        return $request->expectsJson() || $request->ajax() || $request->wantsJson();
    }
}
