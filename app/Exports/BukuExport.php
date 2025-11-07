<?php

namespace App\Exports;

use App\Models\Buku;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BukuExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Buku::withCount([
            'peminjaman',
            'peminjaman as peminjaman_aktif_count' => function ($query) {
                $query->where('status_pinjam', 'dipinjam');
            }
        ])->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Kode Buku',
            'Judul',
            'Pengarang',
            'Penerbit',
            'Tahun Terbit',
            'Stok',
            'Total Peminjaman',
            'Sedang Dipinjam'
        ];
    }

    public function map($buku): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $buku->kode_buku,
            $buku->judul,
            $buku->pengarang,
            $buku->penerbit,
            $buku->tahun_terbit,
            $buku->stok,
            $buku->peminjaman_count,
            $buku->peminjaman_aktif_count
        ];
    }
}
