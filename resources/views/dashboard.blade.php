@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="mb-4">
    <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
    <p class="text-gray-600">Selamat datang di Sistem Peminjaman Buku</p>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <svg class="w-12 h-12 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"></path>
                </svg>
            </div>
            <div class="ml-5">
                <h3 class="text-gray-500 text-sm font-medium">Total Buku</h3>
                <p class="text-2xl font-bold text-gray-900">{{ $totalBuku }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <svg class="w-12 h-12 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path>
                </svg>
            </div>
            <div class="ml-5">
                <h3 class="text-gray-500 text-sm font-medium">Anggota Aktif</h3>
                <p class="text-2xl font-bold text-gray-900">{{ $totalAnggota }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <svg class="w-12 h-12 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M8 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z"></path>
                    <path d="M6 3a2 2 0 00-2 2v11a2 2 0 002 2h8a2 2 0 002-2V5a2 2 0 00-2-2 3 3 0 01-3 3H9a3 3 0 01-3-3z"></path>
                </svg>
            </div>
            <div class="ml-5">
                <h3 class="text-gray-500 text-sm font-medium">Sedang Dipinjam</h3>
                <p class="text-2xl font-bold text-gray-900">{{ $totalPeminjaman }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Recent Transactions -->
<div class="bg-white rounded-lg shadow">
    <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="text-lg font-semibold text-gray-900">Transaksi Peminjaman Terbaru</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3">Anggota</th>
                    <th scope="col" class="px-6 py-3">Buku</th>
                    <th scope="col" class="px-6 py-3">Tanggal Pinjam</th>
                    <th scope="col" class="px-6 py-3">Harus Kembali</th>
                    <th scope="col" class="px-6 py-3">Status</th>
                    <th scope="col" class="px-6 py-3">Petugas</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentPeminjaman as $peminjaman)
                <tr class="bg-white border-b hover:bg-gray-50">
                    <td class="px-6 py-4 font-medium text-gray-900">
                        {{ $peminjaman->anggota->nama }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $peminjaman->buku->judul }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $peminjaman->tgl_pinjam->format('d/m/Y') }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $peminjaman->tgl_harus_kembali->format('d/m/Y') }}
                    </td>
                    <td class="px-6 py-4">
                        @if($peminjaman->status_pinjam == 'dipinjam')
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Dipinjam</span>
                        @else
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Dikembalikan</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        {{ $peminjaman->petugas->nama_petugas }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                        Belum ada transaksi peminjaman
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

