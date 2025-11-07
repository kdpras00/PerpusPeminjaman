@extends('layouts.app')

@section('title', 'Edit Pengembalian')

@section('content')
<div class="mb-4">
    <h1 class="text-2xl font-bold text-gray-900">Edit Pengembalian</h1>
    <p class="text-gray-600">Perbarui data transaksi pengembalian</p>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <form action="{{ route('pengembalian.update', $pengembalian->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 gap-6">
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-900">Data Peminjaman</label>
                <p class="p-2.5 bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg">
                    {{ $pengembalian->peminjaman->anggota->nama }} - {{ $pengembalian->peminjaman->buku->judul }}
                </p>
            </div>

            <div>
                <label for="tgl_kembali_realisasi" class="block mb-2 text-sm font-medium text-gray-900">Tanggal Kembali</label>
                <input type="date" name="tgl_kembali_realisasi" id="tgl_kembali_realisasi" 
                       value="{{ old('tgl_kembali_realisasi', $pengembalian->tgl_kembali_realisasi->format('Y-m-d')) }}" 
                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                @error('tgl_kembali_realisasi')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <p class="text-sm text-blue-700">Denda akan dihitung ulang secara otomatis berdasarkan tanggal kembali yang baru</p>
            </div>
        </div>

        <div class="mt-6 flex space-x-4">
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">
                Update
            </button>
            <a href="{{ route('pengembalian.index') }}" class="text-gray-700 bg-gray-200 hover:bg-gray-300 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection

