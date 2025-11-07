<?php

namespace App\Services;

use App\Models\Buku;
use App\Models\Peminjaman;
use App\Constants\StatusConstants;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PeminjamanService
{
    /**
     * Create a new peminjaman transaction
     */
    public function createPeminjaman(array $data, int $petugasId): Peminjaman
    {
        return DB::transaction(function () use ($data, $petugasId) {
            $buku = Buku::findOrFail($data['buku_id']);

            if (!$buku->isAvailable()) {
                throw new \Exception('Stok buku tidak tersedia!');
            }

            $peminjaman = Peminjaman::create([
                'anggota_id' => $data['anggota_id'],
                'buku_id' => $data['buku_id'],
                'petugas_id' => $petugasId,
                'tgl_pinjam' => $data['tgl_pinjam'],
                'tgl_harus_kembali' => $data['tgl_harus_kembali'],
                'status_pinjam' => StatusConstants::STATUS_DIPINJAM,
            ]);

            $buku->decrement('stok');

            Log::info('Peminjaman created', [
                'peminjaman_id' => $peminjaman->id,
                'buku_id' => $buku->id,
                'stok_after' => $buku->fresh()->stok,
            ]);

            return $peminjaman;
        });
    }

    /**
     * Update peminjaman
     */
    public function updatePeminjaman(Peminjaman $peminjaman, array $data): Peminjaman
    {
        $peminjaman->update($data);
        return $peminjaman->fresh();
    }

    /**
     * Delete peminjaman and restore book stock if needed
     */
    public function deletePeminjaman(Peminjaman $peminjaman): void
    {
        DB::transaction(function () use ($peminjaman) {
            if ($peminjaman->isDipinjam()) {
                $buku = $peminjaman->buku;
                $buku->increment('stok');

                Log::info('Peminjaman deleted, stock restored', [
                    'peminjaman_id' => $peminjaman->id,
                    'buku_id' => $buku->id,
                ]);
            }

            $peminjaman->delete();
        });
    }
}

