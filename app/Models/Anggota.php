<?php

namespace App\Models;

use App\Constants\StatusConstants;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class Anggota extends Model
{
    protected $table = 'anggota';

    protected $fillable = [
        'nama',
        'alamat',
        'no_telp',
        'tgl_daftar',
        'status'
    ];

    protected $casts = [
        'tgl_daftar' => 'date',
    ];

    /**
     * Scope a query to only include active members.
     */
    public function scopeAktif(Builder $query): Builder
    {
        return $query->where('status', StatusConstants::STATUS_AKTIF);
    }

    /**
     * Check if member is active
     */
    public function isAktif(): bool
    {
        return $this->status === StatusConstants::STATUS_AKTIF;
    }

    public function peminjaman(): HasMany
    {
        return $this->hasMany(Peminjaman::class);
    }
}
