<?php

namespace App\Exports;

use App\Models\Anggota;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AnggotaExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Anggota::withCount('peminjaman')
            ->orderBy('peminjaman_count', 'desc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama',
            'Alamat',
            'No. Telepon',
            'Tanggal Daftar',
            'Status',
            'Total Peminjaman'
        ];
    }

    public function map($anggota): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $anggota->nama,
            $anggota->alamat,
            $anggota->no_telp,
            $anggota->tgl_daftar->format('d/m/Y'),
            ucfirst($anggota->status),
            $anggota->peminjaman_count
        ];
    }
}
