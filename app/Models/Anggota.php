<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function peminjaman(): HasMany
    {
        return $this->hasMany(Peminjaman::class);
    }
}
