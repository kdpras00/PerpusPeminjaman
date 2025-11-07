@extends('layouts.app')

@section('title', 'Tambah Buku')

@section('content')
<div class="mb-4">
    <h1 class="text-2xl font-bold text-gray-900">Tambah Buku Baru</h1>
    <p class="text-gray-600">Masukkan informasi buku baru</p>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <form action="{{ route('buku.store') }}" method="POST">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="kode_buku" class="block mb-2 text-sm font-medium text-gray-900">Kode Buku</label>
                <input type="text" name="kode_buku" id="kode_buku" value="{{ old('kode_buku') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                @error('kode_buku')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="judul" class="block mb-2 text-sm font-medium text-gray-900">Judul Buku</label>
                <input type="text" name="judul" id="judul" value="{{ old('judul') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                @error('judul')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="pengarang" class="block mb-2 text-sm font-medium text-gray-900">Pengarang</label>
                <input type="text" name="pengarang" id="pengarang" value="{{ old('pengarang') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                @error('pengarang')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="penerbit" class="block mb-2 text-sm font-medium text-gray-900">Penerbit</label>
                <input type="text" name="penerbit" id="penerbit" value="{{ old('penerbit') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                @error('penerbit')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="tahun_terbit" class="block mb-2 text-sm font-medium text-gray-900">Tahun Terbit</label>
                <input type="number" name="tahun_terbit" id="tahun_terbit" value="{{ old('tahun_terbit') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                @error('tahun_terbit')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="stok" class="block mb-2 text-sm font-medium text-gray-900">Stok</label>
                <input type="number" name="stok" id="stok" value="{{ old('stok') }}" min="0" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                @error('stok')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mt-6 flex space-x-4">
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">
                Simpan
            </button>
            <a href="{{ route('buku.index') }}" class="text-gray-700 bg-gray-200 hover:bg-gray-300 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection

