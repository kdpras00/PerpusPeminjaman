@extends('layouts.app')

@section('title', 'Detail Pengembalian')

@section('content')
<div class="mb-4">
    <h1 class="text-2xl font-bold text-gray-900">Detail Pengembalian</h1>
    <p class="text-gray-600">Informasi lengkap transaksi pengembalian</p>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label class="block mb-2 text-sm font-medium text-gray-500">Nama Anggota</label>
            <p class="text-lg text-gray-900">{{ $pengembalian->peminjaman->anggota->nama }}</p>
        </div>

        <div>
            <label class="block mb-2 text-sm font-medium text-gray-500">Judul Buku</label>
            <p class="text-lg text-gray-900">{{ $pengembalian->peminjaman->buku->judul }}</p>
        </div>

        <div>
            <label class="block mb-2 text-sm font-medium text-gray-500">Tanggal Pinjam</label>
            <p class="text-lg text-gray-900">{{ $pengembalian->peminjaman->tgl_pinjam->format('d F Y') }}</p>
        </div>

        <div>
            <label class="block mb-2 text-sm font-medium text-gray-500">Tanggal Harus Kembali</label>
            <p class="text-lg text-gray-900">{{ $pengembalian->peminjaman->tgl_harus_kembali->format('d F Y') }}</p>
        </div>

        <div>
            <label class="block mb-2 text-sm font-medium text-gray-500">Tanggal Kembali Realisasi</label>
            <p class="text-lg text-gray-900">{{ $pengembalian->tgl_kembali_realisasi->format('d F Y') }}</p>
        </div>

        <div>
            <label class="block mb-2 text-sm font-medium text-gray-500">Denda</label>
            <p class="text-lg">
                <span class="font-bold {{ $pengembalian->denda > 0 ? 'text-red-600' : 'text-green-600' }}">
                    Rp {{ number_format($pengembalian->denda, 0, ',', '.') }}
                </span>
            </p>
        </div>

        <div>
            <label class="block mb-2 text-sm font-medium text-gray-500">Petugas</label>
            <p class="text-lg text-gray-900">{{ $pengembalian->peminjaman->petugas->nama_petugas }}</p>
        </div>
    </div>

    <div class="mt-6 flex space-x-4">
        <a href="{{ route('pengembalian.edit', $pengembalian->id) }}" class="text-white bg-yellow-500 hover:bg-yellow-600 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5">
            Edit
        </a>
        <a href="{{ route('pengembalian.index') }}" class="text-gray-700 bg-gray-200 hover:bg-gray-300 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5">
            Kembali
        </a>
    </div>
</div>
@endsection

