<!DOCTYPE html>
<html>
<head>
    <title>Laporan Data Buku</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        h2 { text-align: center; margin-bottom: 5px; }
        h4 { text-align: center; margin-top: 0; color: #666; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .text-center { text-align: center; }
        .badge { padding: 4px 8px; border-radius: 4px; font-size: 10px; }
        .badge-success { background-color: #d1fae5; color: #065f46; }
        .badge-danger { background-color: #fee2e2; color: #991b1b; }
    </style>
</head>
<body>
    <h2>LAPORAN DATA BUKU</h2>
    <h4>Sistem Perpustakaan</h4>

    <table>
        <thead>
            <tr>
                <th class="text-center" width="5%">No</th>
                <th width="10%">Kode</th>
                <th width="25%">Judul</th>
                <th width="18%">Pengarang</th>
                <th width="15%">Penerbit</th>
                <th class="text-center" width="8%">Tahun</th>
                <th class="text-center" width="7%">Stok</th>
                <th class="text-center" width="7%">Total</th>
                <th class="text-center" width="7%">Dipinjam</th>
            </tr>
        </thead>
        <tbody>
            @forelse($bukus as $index => $buku)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $buku->kode_buku }}</td>
                <td>{{ $buku->judul }}</td>
                <td>{{ $buku->pengarang }}</td>
                <td>{{ $buku->penerbit }}</td>
                <td class="text-center">{{ $buku->tahun_terbit }}</td>
                <td class="text-center">
                    <span class="badge {{ $buku->stok > 0 ? 'badge-success' : 'badge-danger' }}">
                        {{ $buku->stok }}
                    </span>
                </td>
                <td class="text-center">{{ $buku->peminjaman_count }}</td>
                <td class="text-center">{{ $buku->peminjaman_aktif_count }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="9" class="text-center">Tidak ada data</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <p style="margin-top: 30px; font-size: 10px; color: #666;">
        Dicetak pada: {{ now()->format('d/m/Y H:i:s') }}
    </p>
</body>
</html>

