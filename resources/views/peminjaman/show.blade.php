@extends('layouts.app')

@section('title', 'Detail Peminjaman')

@section('content')
<div class="mb-4">
    <h1 class="text-2xl font-bold text-gray-900">Detail Peminjaman</h1>
    <p class="text-gray-600">Informasi lengkap transaksi peminjaman</p>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label class="block mb-2 text-sm font-medium text-gray-500">Nama Anggota</label>
            <p class="text-lg text-gray-900">{{ $peminjaman->anggota->nama }}</p>
        </div>

        <div>
            <label class="block mb-2 text-sm font-medium text-gray-500">Judul Buku</label>
            <p class="text-lg text-gray-900">{{ $peminjaman->buku->judul }}</p>
        </div>

        <div>
            <label class="block mb-2 text-sm font-medium text-gray-500">Tanggal Pinjam</label>
            <p class="text-lg text-gray-900">{{ $peminjaman->tgl_pinjam->format('d F Y') }}</p>
        </div>

        <div>
            <label class="block mb-2 text-sm font-medium text-gray-500">Tanggal Harus Kembali</label>
            <p class="text-lg text-gray-900">{{ $peminjaman->tgl_harus_kembali->format('d F Y') }}</p>
        </div>

        <div>
            <label class="block mb-2 text-sm font-medium text-gray-500">Status</label>
            <p class="text-lg">
                @if($peminjaman->status_pinjam == 'dipinjam')
                    <span class="px-3 py-1 text-sm font-semibold rounded-full bg-yellow-100 text-yellow-800">Dipinjam</span>
                @else
                    <span class="px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">Dikembalikan</span>
                @endif
            </p>
        </div>

        <div>
            <label class="block mb-2 text-sm font-medium text-gray-500">Petugas</label>
            <p class="text-lg text-gray-900">{{ $peminjaman->petugas->nama_petugas }}</p>
        </div>
    </div>

    @if($peminjaman->pengembalian)
    <div class="mt-6 border-t pt-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Pengembalian</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-500">Tanggal Kembali</label>
                <p class="text-lg text-gray-900">{{ $peminjaman->pengembalian->tgl_kembali_realisasi->format('d F Y') }}</p>
            </div>
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-500">Denda</label>
                <p class="text-lg text-gray-900">Rp {{ number_format($peminjaman->pengembalian->denda, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>
    @endif

    <div class="mt-6 flex space-x-4">
        @if($peminjaman->status_pinjam == 'dipinjam')
        <a href="{{ route('peminjaman.edit', $peminjaman->id) }}" class="text-white bg-yellow-500 hover:bg-yellow-600 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5">
            Edit
        </a>
        @endif
        <a href="{{ route('peminjaman.index') }}" class="text-gray-700 bg-gray-200 hover:bg-gray-300 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5">
            Kembali
        </a>
    </div>
</div>
@endsection

