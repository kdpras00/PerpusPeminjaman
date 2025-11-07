<?php

namespace App\Services;

use App\Constants\StatusConstants;
use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Illuminate\Database\Eloquent\Builder;

class LaporanService
{
    /**
     * Build peminjaman query with filters
     */
    public function buildPeminjamanQuery(array $filters = []): Builder
    {
        $query = Peminjaman::with(['anggota', 'buku', 'petugas']);

        if (!empty($filters['tanggal_mulai'])) {
            $query->whereDate('tgl_pinjam', '>=', $filters['tanggal_mulai']);
        }

        if (!empty($filters['tanggal_akhir'])) {
            $query->whereDate('tgl_pinjam', '<=', $filters['tanggal_akhir']);
        }

        if (!empty($filters['status'])) {
            $query->where('status_pinjam', $filters['status']);
        }

        return $query->orderBy('tgl_pinjam', 'desc');
    }

    /**
     * Build pengembalian query with filters
     */
    public function buildPengembalianQuery(array $filters = []): Builder
    {
        $query = Pengembalian::with(['peminjaman.anggota', 'peminjaman.buku']);

        if (!empty($filters['tanggal_mulai'])) {
            $query->whereDate('tgl_kembali_realisasi', '>=', $filters['tanggal_mulai']);
        }

        if (!empty($filters['tanggal_akhir'])) {
            $query->whereDate('tgl_kembali_realisasi', '<=', $filters['tanggal_akhir']);
        }

        return $query->orderBy('tgl_kembali_realisasi', 'desc');
    }

    /**
     * Get buku report data
     */
    public function getBukuReport(): \Illuminate\Database\Eloquent\Collection
    {
        return Buku::withCount([
            'peminjaman',
            'peminjaman as peminjaman_aktif_count' => function ($query) {
                $query->where('status_pinjam', StatusConstants::STATUS_DIPINJAM);
            }
        ])->get();
    }

    /**
     * Get anggota report data
     */
    public function getAnggotaReport(): \Illuminate\Database\Eloquent\Collection
    {
        return Anggota::withCount('peminjaman')
            ->orderBy('peminjaman_count', 'desc')
            ->get();
    }
}

