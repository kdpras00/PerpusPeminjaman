@extends('layouts.app')

@section('title', 'Detail Anggota')

@section('content')
<div class="mb-4">
    <h1 class="text-2xl font-bold text-gray-900">Detail Anggota</h1>
    <p class="text-gray-600">Informasi lengkap anggota</p>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="md:col-span-2">
            <label class="block mb-2 text-sm font-medium text-gray-500">Nama Lengkap</label>
            <p class="text-lg text-gray-900">{{ $anggota->nama }}</p>
        </div>

        <div class="md:col-span-2">
            <label class="block mb-2 text-sm font-medium text-gray-500">Alamat</label>
            <p class="text-lg text-gray-900">{{ $anggota->alamat }}</p>
        </div>

        <div>
            <label class="block mb-2 text-sm font-medium text-gray-500">No. Telepon</label>
            <p class="text-lg text-gray-900">{{ $anggota->no_telp }}</p>
        </div>

        <div>
            <label class="block mb-2 text-sm font-medium text-gray-500">Tanggal Daftar</label>
            <p class="text-lg text-gray-900">{{ $anggota->tgl_daftar->format('d F Y') }}</p>
        </div>

        <div>
            <label class="block mb-2 text-sm font-medium text-gray-500">Status</label>
            <p class="text-lg">
                <span class="px-3 py-1 text-sm font-semibold rounded-full {{ $anggota->status == 'aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ ucfirst($anggota->status) }}
                </span>
            </p>
        </div>
    </div>

    <div class="mt-6 flex space-x-4">
        <a href="{{ route('anggota.edit', $anggota->id) }}" class="text-white bg-yellow-500 hover:bg-yellow-600 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5">
            Edit
        </a>
        <a href="{{ route('anggota.index') }}" class="text-gray-700 bg-gray-200 hover:bg-gray-300 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5">
            Kembali
        </a>
    </div>
</div>
@endsection

