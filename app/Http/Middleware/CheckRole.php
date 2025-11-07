<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $petugas = Session::get('petugas');

        if (!$petugas) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        }

        // Pastikan petugas adalah object dan memiliki property role
        if (!is_object($petugas) || !isset($petugas->role)) {
            Session::forget('petugas');
            return redirect()->route('login')->with('error', 'Session tidak valid. Silakan login kembali.');
        }

        if (!in_array($petugas->role, $roles)) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini');
        }

        return $next($request);
    }
}
