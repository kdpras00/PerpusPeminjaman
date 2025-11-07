<?php

namespace App\Http\Controllers;

use App\Constants\StatusConstants;
use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the dashboard
     */
    public function index(): View
    {
        $totalBuku = $this->getTotalBuku();
        $totalAnggota = $this->getTotalAnggotaAktif();
        $totalPeminjaman = $this->getTotalPeminjamanAktif();
        $recentPeminjaman = $this->getRecentPeminjaman();

        return view('dashboard', compact(
            'totalBuku',
            'totalAnggota',
            'totalPeminjaman',
            'recentPeminjaman'
        ));
    }

    /**
     * Get total number of books
     */
    private function getTotalBuku(): int
    {
        return Buku::count();
    }

    /**
     * Get total number of active members
     */
    private function getTotalAnggotaAktif(): int
    {
        return Anggota::aktif()->count();
    }

    /**
     * Get total number of active borrowings
     */
    private function getTotalPeminjamanAktif(): int
    {
        return Peminjaman::dipinjam()->count();
    }

    /**
     * Get recent borrowings
     */
    private function getRecentPeminjaman()
    {
        return Peminjaman::with(['anggota', 'buku', 'petugas'])
            ->orderBy('created_at', 'desc')
            ->take(StatusConstants::RECENT_ITEMS_LIMIT)
            ->get();
    }
}
