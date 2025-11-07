<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
