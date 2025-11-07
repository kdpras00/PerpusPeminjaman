@extends('layouts.app')

@section('title', 'Tambah Peminjaman')

@section('content')
<div class="mb-4">
    <h1 class="text-2xl font-bold text-gray-900">Tambah Peminjaman Baru</h1>
    <p class="text-gray-600">Masukkan data transaksi peminjaman</p>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <form action="{{ route('peminjaman.store') }}" method="POST">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="md:col-span-2">
                <label for="anggota_id" class="block mb-2 text-sm font-medium text-gray-900">Pilih Anggota</label>
                <select name="anggota_id" id="anggota_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                    <option value="">-- Pilih Anggota --</option>
                    @foreach($anggotas as $anggota)
                        <option value="{{ $anggota->id }}" {{ old('anggota_id') == $anggota->id ? 'selected' : '' }}>
                            {{ $anggota->nama }} - {{ $anggota->no_telp }}
                        </option>
                    @endforeach
                </select>
                @error('anggota_id')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="md:col-span-2">
                <label for="buku_id" class="block mb-2 text-sm font-medium text-gray-900">Pilih Buku</label>
                <select name="buku_id" id="buku_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                    <option value="">-- Pilih Buku --</option>
                    @foreach($bukus as $buku)
                        <option value="{{ $buku->id }}" {{ old('buku_id') == $buku->id ? 'selected' : '' }}>
                            {{ $buku->judul }} - {{ $buku->pengarang }} (Stok: {{ $buku->stok }})
                        </option>
                    @endforeach
                </select>
                @error('buku_id')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="tgl_pinjam" class="block mb-2 text-sm font-medium text-gray-900">Tanggal Pinjam</label>
                <input type="date" name="tgl_pinjam" id="tgl_pinjam" value="{{ old('tgl_pinjam', date('Y-m-d')) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                @error('tgl_pinjam')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="tgl_harus_kembali" class="block mb-2 text-sm font-medium text-gray-900">Tanggal Harus Kembali</label>
                <input type="date" name="tgl_harus_kembali" id="tgl_harus_kembali" value="{{ old('tgl_harus_kembali', date('Y-m-d', strtotime('+7 days'))) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                @error('tgl_harus_kembali')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mt-6 flex space-x-4">
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">
                Simpan
            </button>
            <a href="{{ route('peminjaman.index') }}" class="text-gray-700 bg-gray-200 hover:bg-gray-300 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection

