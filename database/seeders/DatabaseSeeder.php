<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Anggota;
use App\Models\Buku;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PetugasSeeder::class,
        ]);

        // Sample Anggota
        Anggota::create([
            'nama' => 'John Doe',
            'alamat' => 'Jl. Contoh No. 123',
            'no_telp' => '08123456789',
            'tgl_daftar' => now(),
            'status' => 'aktif'
        ]);

        Anggota::create([
            'nama' => 'Jane Smith',
            'alamat' => 'Jl. Sample No. 456',
            'no_telp' => '08987654321',
            'tgl_daftar' => now(),
            'status' => 'aktif'
        ]);

        // Sample Buku
        Buku::create([
            'kode_buku' => 'BK001',
            'judul' => 'Pemrograman Laravel',
            'pengarang' => 'Taylor Otwell',
            'penerbit' => 'Penerbit IT',
            'tahun_terbit' => 2024,
            'stok' => 5
        ]);

        Buku::create([
            'kode_buku' => 'BK002',
            'judul' => 'Belajar PHP Modern',
            'pengarang' => 'Andi Prasetyo',
            'penerbit' => 'Gramedia',
            'tahun_terbit' => 2023,
            'stok' => 3
        ]);

        Buku::create([
            'kode_buku' => 'BK003',
            'judul' => 'Database MySQL',
            'pengarang' => 'Budi Santoso',
            'penerbit' => 'Elex Media',
            'tahun_terbit' => 2023,
            'stok' => 7
        ]);
    }
}
