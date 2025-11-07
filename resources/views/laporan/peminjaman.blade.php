@extends('layouts.app')

@section('title', 'Laporan Peminjaman')

@section('content')
<div class="mb-4 flex justify-between items-start">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Laporan Peminjaman</h1>
        <p class="text-gray-600">Laporan data transaksi peminjaman buku</p>
    </div>
    <div class="flex flex-wrap gap-2">
        <button onclick="window.print()" class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-4 py-2">
            <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a2 2 0 002 2h6a2 2 0 002-2v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zm0 8H7v4h6v-4z" clip-rule="evenodd"></path>
            </svg>
            Print
        </button>
        <a href="{{ route('laporan.peminjaman.pdf', request()->all()) }}" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-4 py-2">
            <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z" clip-rule="evenodd"></path>
            </svg>
            PDF
        </a>
        <a href="{{ route('laporan.peminjaman.excel', request()->all()) }}" class="text-white bg-emerald-700 hover:bg-emerald-800 focus:ring-4 focus:ring-emerald-300 font-medium rounded-lg text-sm px-4 py-2">
            <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
            </svg>
            Excel
        </a>
    </div>
</div>

<div class="bg-white rounded-lg shadow p-6 mb-6">
    <form method="GET" action="{{ route('laporan.peminjaman') }}">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="tanggal_mulai" class="block mb-2 text-sm font-medium text-gray-900">Tanggal Mulai</label>
                <input type="date" name="tanggal_mulai" id="tanggal_mulai" value="{{ request('tanggal_mulai') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            </div>

            <div>
                <label for="tanggal_akhir" class="block mb-2 text-sm font-medium text-gray-900">Tanggal Akhir</label>
                <input type="date" name="tanggal_akhir" id="tanggal_akhir" value="{{ request('tanggal_akhir') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            </div>

            <div>
                <label for="status" class="block mb-2 text-sm font-medium text-gray-900">Status</label>
                <select name="status" id="status" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <option value="">Semua</option>
                    <option value="dipinjam" {{ request('status') == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                    <option value="dikembalikan" {{ request('status') == 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                </select>
            </div>

            <div class="flex items-end">
                <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">
                    Filter
                </button>
            </div>
        </div>
    </form>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3">No</th>
                    <th scope="col" class="px-6 py-3">Tanggal</th>
                    <th scope="col" class="px-6 py-3">Anggota</th>
                    <th scope="col" class="px-6 py-3">Buku</th>
                    <th scope="col" class="px-6 py-3">Tgl Harus Kembali</th>
                    <th scope="col" class="px-6 py-3">Status</th>
                    <th scope="col" class="px-6 py-3">Petugas</th>
                </tr>
            </thead>
            <tbody>
                @forelse($peminjamans as $index => $peminjaman)
                <tr class="bg-white border-b hover:bg-gray-50">
                    <td class="px-6 py-4">{{ $index + 1 }}</td>
                    <td class="px-6 py-4">{{ $peminjaman->tgl_pinjam->format('d/m/Y') }}</td>
                    <td class="px-6 py-4 font-medium text-gray-900">{{ $peminjaman->anggota->nama }}</td>
                    <td class="px-6 py-4">{{ $peminjaman->buku->judul }}</td>
                    <td class="px-6 py-4">{{ $peminjaman->tgl_harus_kembali->format('d/m/Y') }}</td>
                    <td class="px-6 py-4">
                        @if($peminjaman->status_pinjam == 'dipinjam')
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Dipinjam</span>
                        @else
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Dikembalikan</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">{{ $peminjaman->petugas->nama_petugas }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                        Tidak ada data
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4">
    <a href="{{ route('laporan.index') }}" class="text-gray-700 bg-gray-200 hover:bg-gray-300 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5">
        <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"></path>
        </svg>
        Kembali
    </a>
</div>
@endsection

