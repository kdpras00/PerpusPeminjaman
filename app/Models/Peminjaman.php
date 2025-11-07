<?php

namespace App\Models;

use App\Constants\StatusConstants;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Builder;

class Peminjaman extends Model
{
    protected $table = 'peminjaman';

    protected $fillable = [
        'anggota_id',
        'buku_id',
        'petugas_id',
        'tgl_pinjam',
        'tgl_harus_kembali',
        'status_pinjam'
    ];

    protected $casts = [
        'tgl_pinjam' => 'date',
        'tgl_harus_kembali' => 'date',
    ];

    /**
     * Scope a query to only include active borrowings (not returned).
     */
    public function scopeDipinjam(Builder $query): Builder
    {
        return $query->where('status_pinjam', StatusConstants::STATUS_DIPINJAM);
    }

    /**
     * Scope a query to only include returned borrowings.
     */
    public function scopeDikembalikan(Builder $query): Builder
    {
        return $query->where('status_pinjam', StatusConstants::STATUS_DIKEMBALIKAN);
    }

    /**
     * Scope a query to only include borrowings without pengembalian.
     */
    public function scopeBelumDikembalikan(Builder $query): Builder
    {
        return $query->whereDoesntHave('pengembalian');
    }

    /**
     * Check if peminjaman is still borrowed
     */
    public function isDipinjam(): bool
    {
        return $this->status_pinjam === StatusConstants::STATUS_DIPINJAM;
    }

    public function anggota(): BelongsTo
    {
        return $this->belongsTo(Anggota::class);
    }

    public function buku(): BelongsTo
    {
        return $this->belongsTo(Buku::class);
    }

    public function petugas(): BelongsTo
    {
        return $this->belongsTo(Petugas::class);
    }

    public function pengembalian(): HasOne
    {
        return $this->hasOne(Pengembalian::class);
    }
}
