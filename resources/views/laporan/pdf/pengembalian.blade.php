<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pengembalian Buku</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        h2 { text-align: center; margin-bottom: 5px; }
        h4 { text-align: center; margin-top: 0; color: #666; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .highlight { background-color: #eff6ff; padding: 10px; border-radius: 5px; margin-top: 20px; }
    </style>
</head>
<body>
    <h2>LAPORAN DATA PENGEMBALIAN BUKU</h2>
    <h4>Sistem Perpustakaan</h4>
    
    @if(isset($filters['tanggal_mulai']) || isset($filters['tanggal_akhir']))
    <p style="text-align: center;">
        Periode: 
        {{ isset($filters['tanggal_mulai']) ? \Carbon\Carbon::parse($filters['tanggal_mulai'])->format('d/m/Y') : '...' }}
        s/d
        {{ isset($filters['tanggal_akhir']) ? \Carbon\Carbon::parse($filters['tanggal_akhir'])->format('d/m/Y') : '...' }}
    </p>
    @endif

    <table>
        <thead>
            <tr>
                <th class="text-center" width="5%">No</th>
                <th width="12%">Tgl Kembali</th>
                <th width="18%">Nama Anggota</th>
                <th width="23%">Judul Buku</th>
                <th width="12%">Tgl Pinjam</th>
                <th width="15%">Harus Kembali</th>
                <th class="text-right" width="15%">Denda</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pengembalians as $index => $pengembalian)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $pengembalian->tgl_kembali_realisasi->format('d/m/Y') }}</td>
                <td>{{ $pengembalian->peminjaman->anggota->nama }}</td>
                <td>{{ $pengembalian->peminjaman->buku->judul }}</td>
                <td>{{ $pengembalian->peminjaman->tgl_pinjam->format('d/m/Y') }}</td>
                <td>{{ $pengembalian->peminjaman->tgl_harus_kembali->format('d/m/Y') }}</td>
                <td class="text-right">Rp {{ number_format($pengembalian->denda, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">Tidak ada data</td>
            </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th colspan="6" class="text-right">TOTAL DENDA:</th>
                <th class="text-right">Rp {{ number_format($totalDenda, 0, ',', '.') }}</th>
            </tr>
        </tfoot>
    </table>

    <p style="margin-top: 30px; font-size: 10px; color: #666;">
        Dicetak pada: {{ now()->format('d/m/Y H:i:s') }}
    </p>
</body>
</html>

