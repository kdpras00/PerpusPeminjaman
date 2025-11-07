<!DOCTYPE html>
<html>
<head>
    <title>Laporan Peminjaman Buku</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        h2 { text-align: center; margin-bottom: 5px; }
        h4 { text-align: center; margin-top: 0; color: #666; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .text-center { text-align: center; }
        .badge { padding: 4px 8px; border-radius: 4px; font-size: 10px; }
        .badge-warning { background-color: #fef3c7; color: #92400e; }
        .badge-success { background-color: #d1fae5; color: #065f46; }
    </style>
</head>
<body>
    <h2>LAPORAN DATA PEMINJAMAN BUKU</h2>
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
                <th width="12%">Tanggal</th>
                <th width="20%">Nama Anggota</th>
                <th width="25%">Judul Buku</th>
                <th width="12%">Harus Kembali</th>
                <th width="13%">Status</th>
                <th width="13%">Petugas</th>
            </tr>
        </thead>
        <tbody>
            @forelse($peminjamans as $index => $peminjaman)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $peminjaman->tgl_pinjam->format('d/m/Y') }}</td>
                <td>{{ $peminjaman->anggota->nama }}</td>
                <td>{{ $peminjaman->buku->judul }}</td>
                <td>{{ $peminjaman->tgl_harus_kembali->format('d/m/Y') }}</td>
                <td class="text-center">
                    <span class="badge {{ $peminjaman->status_pinjam == 'dipinjam' ? 'badge-warning' : 'badge-success' }}">
                        {{ ucfirst($peminjaman->status_pinjam) }}
                    </span>
                </td>
                <td>{{ $peminjaman->petugas->nama_petugas }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">Tidak ada data</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <p style="margin-top: 30px; font-size: 10px; color: #666;">
        Dicetak pada: {{ now()->format('d/m/Y H:i:s') }}
    </p>
</body>
</html>

