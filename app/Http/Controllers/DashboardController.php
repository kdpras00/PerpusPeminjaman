<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Anggota;
use App\Models\Peminjaman;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBuku = Buku::count();
        $totalAnggota = Anggota::where('status', 'aktif')->count();
        $totalPeminjaman = Peminjaman::where('status_pinjam', 'dipinjam')->count();
        $recentPeminjaman = Peminjaman::with(['anggota', 'buku', 'petugas'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('dashboard', compact('totalBuku', 'totalAnggota', 'totalPeminjaman', 'recentPeminjaman'));
    }
}
