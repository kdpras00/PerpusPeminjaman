@extends('layouts.app')

@section('title', 'Tambah Anggota')

@section('content')
<div class="mb-4">
    <h1 class="text-2xl font-bold text-gray-900">Tambah Anggota Baru</h1>
    <p class="text-gray-600">Masukkan informasi anggota baru</p>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <form action="{{ route('anggota.store') }}" method="POST">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="md:col-span-2">
                <label for="nama" class="block mb-2 text-sm font-medium text-gray-900">Nama Lengkap</label>
                <input type="text" name="nama" id="nama" value="{{ old('nama') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                @error('nama')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="md:col-span-2">
                <label for="alamat" class="block mb-2 text-sm font-medium text-gray-900">Alamat</label>
                <textarea name="alamat" id="alamat" rows="3" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>{{ old('alamat') }}</textarea>
                @error('alamat')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="no_telp" class="block mb-2 text-sm font-medium text-gray-900">No. Telepon</label>
                <input type="text" name="no_telp" id="no_telp" value="{{ old('no_telp') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                @error('no_telp')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="tgl_daftar" class="block mb-2 text-sm font-medium text-gray-900">Tanggal Daftar</label>
                <input type="date" name="tgl_daftar" id="tgl_daftar" value="{{ old('tgl_daftar', date('Y-m-d')) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                @error('tgl_daftar')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="status" class="block mb-2 text-sm font-medium text-gray-900">Status</label>
                <select name="status" id="status" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                    <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>Non Aktif</option>
                </select>
                @error('status')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mt-6 flex space-x-4">
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">
                Simpan
            </button>
            <a href="{{ route('anggota.index') }}" class="text-gray-700 bg-gray-200 hover:bg-gray-300 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection

