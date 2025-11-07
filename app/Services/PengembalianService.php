<?php

namespace App\Services;

use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Constants\StatusConstants;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PengembalianService
{
    /**
     * Calculate late fee based on return date
     */
    public function calculateDenda(Carbon $tglHarusKembali, Carbon $tglKembaliRealisasi): int
    {
        if ($tglKembaliRealisasi->lte($tglHarusKembali)) {
            return 0;
        }

        $hariTerlambat = $tglKembaliRealisasi->diffInDays($tglHarusKembali);
        return $hariTerlambat * StatusConstants::DENDA_PER_HARI;
    }

    /**
     * Create a new pengembalian transaction
     */
    public function createPengembalian(array $data): Pengembalian
    {
        return DB::transaction(function () use ($data) {
            $peminjaman = Peminjaman::findOrFail($data['peminjaman_id']);

            $tglHarusKembali = Carbon::parse($peminjaman->tgl_harus_kembali);
            $tglKembaliRealisasi = Carbon::parse($data['tgl_kembali_realisasi']);
            $denda = $this->calculateDenda($tglHarusKembali, $tglKembaliRealisasi);

            $pengembalian = Pengembalian::create([
                'peminjaman_id' => $data['peminjaman_id'],
                'tgl_kembali_realisasi' => $data['tgl_kembali_realisasi'],
                'denda' => $denda,
            ]);

            $peminjaman->update([
                'status_pinjam' => StatusConstants::STATUS_DIKEMBALIKAN,
            ]);

            $buku = $peminjaman->buku;
            $buku->increment('stok');

            Log::info('Pengembalian created', [
                'pengembalian_id' => $pengembalian->id,
                'peminjaman_id' => $peminjaman->id,
                'denda' => $denda,
                'buku_id' => $buku->id,
                'stok_after' => $buku->fresh()->stok,
            ]);

            return $pengembalian;
        });
    }

    /**
     * Update pengembalian
     */
    public function updatePengembalian(Pengembalian $pengembalian, array $data): Pengembalian
    {
        return DB::transaction(function () use ($pengembalian, $data) {
            $peminjaman = $pengembalian->peminjaman;

            $tglHarusKembali = Carbon::parse($peminjaman->tgl_harus_kembali);
            $tglKembaliRealisasi = Carbon::parse($data['tgl_kembali_realisasi']);
            $denda = $this->calculateDenda($tglHarusKembali, $tglKembaliRealisasi);

            $pengembalian->update([
                'tgl_kembali_realisasi' => $data['tgl_kembali_realisasi'],
                'denda' => $denda,
            ]);

            return $pengembalian->fresh();
        });
    }

    /**
     * Delete pengembalian and restore peminjaman status
     */
    public function deletePengembalian(Pengembalian $pengembalian): void
    {
        DB::transaction(function () use ($pengembalian) {
            $peminjaman = $pengembalian->peminjaman;

            $peminjaman->update([
                'status_pinjam' => StatusConstants::STATUS_DIPINJAM,
            ]);

            $buku = $peminjaman->buku;
            $buku->decrement('stok');

            Log::info('Pengembalian deleted, status restored', [
                'pengembalian_id' => $pengembalian->id,
                'peminjaman_id' => $peminjaman->id,
                'buku_id' => $buku->id,
            ]);

            $pengembalian->delete();
        });
    }
}

