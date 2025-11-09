<!DOCTYPE html>
<html>
<head>
    <title>Laporan Data Anggota</title>
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
    <h2>LAPORAN DATA ANGGOTA</h2>
    <h4>Sistem Perpustakaan</h4>

    <table>
        <thead>
            <tr>
                <th class="text-center" width="5%">No</th>
                <th width="20%">Nama</th>
                <th width="30%">Alamat</th>
                <th width="13%">No. Telepon</th>
                <th class="text-center" width="12%">Tgl Daftar</th>
                <th class="text-center" width="10%">Status</th>
                <th class="text-center" width="10%">Total Pinjam</th>
            </tr>
        </thead>
        <tbody>
            @forelse($anggotas as $index => $anggota)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $anggota->nama }}</td>
                <td>{{ $anggota->alamat }}</td>
                <td>{{ $anggota->no_telp }}</td>
                <td class="text-center">{{ $anggota->tgl_daftar ? $anggota->tgl_daftar->format('d/m/Y') : '-' }}</td>
                <td class="text-center">
                    <span class="badge {{ $anggota->status == 'aktif' ? 'badge-success' : 'badge-danger' }}">
                        {{ ucfirst($anggota->status) }}
                    </span>
                </td>
                <td class="text-center">{{ $anggota->peminjaman_count }}</td>
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

