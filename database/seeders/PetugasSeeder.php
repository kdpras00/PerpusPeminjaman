<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Petugas;
use Illuminate\Support\Facades\Hash;

class PetugasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Petugas::create([
            'nama_petugas' => 'Administrator',
            'username' => 'admin',
            'password' => Hash::make('admin123'),
            'role' => 'admin'
        ]);

        Petugas::create([
            'nama_petugas' => 'Petugas Perpustakaan',
            'username' => 'petugas',
            'password' => Hash::make('petugas123'),
            'role' => 'petugas'
        ]);
    }
}
