@extends('layouts.app')

@section('title', 'Detail Buku')

@section('content')
<div class="mb-4">
    <h1 class="text-2xl font-bold text-gray-900">Detail Buku</h1>
    <p class="text-gray-600">Informasi lengkap buku</p>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label class="block mb-2 text-sm font-medium text-gray-500">Kode Buku</label>
            <p class="text-lg text-gray-900">{{ $buku->kode_buku }}</p>
        </div>

        <div>
            <label class="block mb-2 text-sm font-medium text-gray-500">Judul Buku</label>
            <p class="text-lg text-gray-900">{{ $buku->judul }}</p>
        </div>

        <div>
            <label class="block mb-2 text-sm font-medium text-gray-500">Pengarang</label>
            <p class="text-lg text-gray-900">{{ $buku->pengarang }}</p>
        </div>

        <div>
            <label class="block mb-2 text-sm font-medium text-gray-500">Penerbit</label>
            <p class="text-lg text-gray-900">{{ $buku->penerbit }}</p>
        </div>

        <div>
            <label class="block mb-2 text-sm font-medium text-gray-500">Tahun Terbit</label>
            <p class="text-lg text-gray-900">{{ $buku->tahun_terbit }}</p>
        </div>

        <div>
            <label class="block mb-2 text-sm font-medium text-gray-500">Stok</label>
            <p class="text-lg">
                <span class="px-3 py-1 text-sm font-semibold rounded-full {{ $buku->stok > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ $buku->stok }} buku
                </span>
            </p>
        </div>
    </div>

    <div class="mt-6 flex space-x-4">
        <a href="{{ route('buku.edit', $buku->id) }}" class="text-white bg-yellow-500 hover:bg-yellow-600 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5">
            Edit
        </a>
        <a href="{{ route('buku.index') }}" class="text-gray-700 bg-gray-200 hover:bg-gray-300 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5">
            Kembali
        </a>
    </div>
</div>
@endsection

