<?php

namespace App\Exports;

use App\Models\Pengembalian;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PengembalianExport implements FromCollection, WithHeadings, WithMapping
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
        $query = Pengembalian::with(['peminjaman.anggota', 'peminjaman.buku']);

        if (isset($this->filters['tanggal_mulai'])) {
            $query->whereDate('tgl_kembali_realisasi', '>=', $this->filters['tanggal_mulai']);
        }

        if (isset($this->filters['tanggal_akhir'])) {
            $query->whereDate('tgl_kembali_realisasi', '<=', $this->filters['tanggal_akhir']);
        }

        return $query->orderBy('tgl_kembali_realisasi', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Tanggal Kembali',
            'Nama Anggota',
            'Judul Buku',
            'Tanggal Pinjam',
            'Tanggal Harus Kembali',
            'Denda (Rp)'
        ];
    }

    public function map($pengembalian): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $pengembalian->tgl_kembali_realisasi->format('d/m/Y'),
            $pengembalian->peminjaman->anggota->nama,
            $pengembalian->peminjaman->buku->judul,
            $pengembalian->peminjaman->tgl_pinjam->format('d/m/Y'),
            $pengembalian->peminjaman->tgl_harus_kembali->format('d/m/Y'),
            number_format($pengembalian->denda, 0, ',', '.')
        ];
    }
}
