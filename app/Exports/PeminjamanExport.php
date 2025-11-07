<?php

namespace App\Exports;

use App\Models\Peminjaman;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PeminjamanExport implements FromCollection, WithHeadings, WithMapping
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $query = Peminjaman::with(['anggota', 'buku', 'petugas']);

        if (isset($this->filters['tanggal_mulai'])) {
            $query->whereDate('tgl_pinjam', '>=', $this->filters['tanggal_mulai']);
        }

        if (isset($this->filters['tanggal_akhir'])) {
            $query->whereDate('tgl_pinjam', '<=', $this->filters['tanggal_akhir']);
        }

        if (isset($this->filters['status'])) {
            $query->where('status_pinjam', $this->filters['status']);
        }

        return $query->orderBy('tgl_pinjam', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Tanggal Pinjam',
            'Nama Anggota',
            'Judul Buku',
            'Tanggal Harus Kembali',
            'Status',
            'Petugas'
        ];
    }

    public function map($peminjaman): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $peminjaman->tgl_pinjam->format('d/m/Y'),
            $peminjaman->anggota->nama,
            $peminjaman->buku->judul,
            $peminjaman->tgl_harus_kembali->format('d/m/Y'),
            ucfirst($peminjaman->status_pinjam),
            $peminjaman->petugas->nama_petugas
        ];
    }
}
