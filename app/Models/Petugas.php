<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Petugas extends Model
{
    protected $table = 'petugas';
    
    protected $fillable = [
        'nama_petugas',
        'username',
        'password',
        'role'
    ];

    protected $hidden = [
        'password',
    ];

    public function peminjaman(): HasMany
    {
        return $this->hasMany(Peminjaman::class);
    }
}
