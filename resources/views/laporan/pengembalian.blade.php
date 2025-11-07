@extends('layouts.app')

@section('title', 'Laporan Pengembalian')

@section('content')
<div class="mb-4 flex justify-between items-start">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Laporan Pengembalian</h1>
        <p class="text-gray-600">Laporan data transaksi pengembalian buku dan denda</p>
    </div>
    <div class="flex flex-wrap gap-2">
        <button onclick="window.print()" class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-4 py-2">
            <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a2 2 0 002 2h6a2 2 0 002-2v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zm0 8H7v4h6v-4z" clip-rule="evenodd"></path>
            </svg>
            Print
        </button>
        <a href="{{ route('laporan.pengembalian.pdf', request()->all()) }}" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-4 py-2">
            <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z" clip-rule="evenodd"></path>
            </svg>
            PDF
        </a>
        <a href="{{ route('laporan.pengembalian.excel', request()->all()) }}" class="text-white bg-emerald-700 hover:bg-emerald-800 focus:ring-4 focus:ring-emerald-300 font-medium rounded-lg text-sm px-4 py-2">
            <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
            </svg>
            Excel
        </a>
    </div>
</div>

<div class="bg-white rounded-lg shadow p-6 mb-6">
    <form method="GET" action="{{ route('laporan.pengembalian') }}">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label for="tanggal_mulai" class="block mb-2 text-sm font-medium text-gray-900">Tanggal Mulai</label>
                <input type="date" name="tanggal_mulai" id="tanggal_mulai" value="{{ request('tanggal_mulai') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            </div>

            <div>
                <label for="tanggal_akhir" class="block mb-2 text-sm font-medium text-gray-900">Tanggal Akhir</label>
                <input type="date" name="tanggal_akhir" id="tanggal_akhir" value="{{ request('tanggal_akhir') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            </div>

            <div class="flex items-end">
                <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">
                    Filter
                </button>
            </div>
        </div>
    </form>
</div>

<div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
    <div class="flex items-center">
        <svg class="w-6 h-6 text-blue-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
            <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"></path>
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"></path>
        </svg>
        <div>
            <p class="text-sm font-medium text-blue-800">Total Denda</p>
            <p class="text-xl font-bold text-blue-900">Rp {{ number_format($totalDenda, 0, ',', '.') }}</p>
        </div>
    </div>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3">No</th>
                    <th scope="col" class="px-6 py-3">Tgl Kembali</th>
                    <th scope="col" class="px-6 py-3">Anggota</th>
                    <th scope="col" class="px-6 py-3">Buku</th>
                    <th scope="col" class="px-6 py-3">Tgl Pinjam</th>
                    <th scope="col" class="px-6 py-3">Tgl Harus Kembali</th>
                    <th scope="col" class="px-6 py-3">Denda</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pengembalians as $index => $pengembalian)
                <tr class="bg-white border-b hover:bg-gray-50">
                    <td class="px-6 py-4">{{ $index + 1 }}</td>
                    <td class="px-6 py-4">{{ $pengembalian->tgl_kembali_realisasi->format('d/m/Y') }}</td>
                    <td class="px-6 py-4 font-medium text-gray-900">{{ $pengembalian->peminjaman->anggota->nama }}</td>
                    <td class="px-6 py-4">{{ $pengembalian->peminjaman->buku->judul }}</td>
                    <td class="px-6 py-4">{{ $pengembalian->peminjaman->tgl_pinjam->format('d/m/Y') }}</td>
                    <td class="px-6 py-4">{{ $pengembalian->peminjaman->tgl_harus_kembali->format('d/m/Y') }}</td>
                    <td class="px-6 py-4">
                        <span class="font-medium {{ $pengembalian->denda > 0 ? 'text-red-600' : 'text-green-600' }}">
                            Rp {{ number_format($pengembalian->denda, 0, ',', '.') }}
                        </span>
                    </td>
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

