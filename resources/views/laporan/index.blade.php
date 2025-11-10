@extends('layouts.app')

@section('title', 'Laporan')

@section('content')
<div class="mb-4">
    <h1 class="text-2xl font-bold text-gray-900">Laporan</h1>
    <p class="text-gray-600">Pilih jenis laporan yang ingin dilihat</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <a href="{{ route('laporan.peminjaman') }}" class="block p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100">
        <div class="flex items-center mb-2">
            <svg class="w-8 h-8 text-blue-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path d="M8 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z"></path>
                <path d="M6 3a2 2 0 00-2 2v11a2 2 0 002 2h8a2 2 0 002-2V5a2 2 0 00-2-2 3 3 0 01-3 3H9a3 3 0 01-3-3z"></path>
            </svg>
            <h5 class="text-2xl font-bold tracking-tight text-gray-900">Laporan Peminjaman</h5>
        </div>
        <p class="font-normal text-gray-700">Lihat laporan data peminjaman buku</p>
    </a>

    <a href="{{ route('laporan.pengembalian') }}" class="block p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100">
        <div class="flex items-center mb-2">
            <svg class="w-8 h-8 text-green-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z" clip-rule="evenodd"></path>
            </svg>
            <h5 class="text-2xl font-bold tracking-tight text-gray-900">Laporan Pengembalian</h5>
        </div>
        <p class="font-normal text-gray-700">Lihat laporan data pengembalian buku dan denda</p>
    </a>

    <a href="{{ route('laporan.buku') }}" class="block p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100">
        <div class="flex items-center mb-2">
            <svg class="w-8 h-8 text-purple-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"></path>
            </svg>
            <h5 class="text-2xl font-bold tracking-tight text-gray-900">Laporan Buku</h5>
        </div>
        <p class="font-normal text-gray-700">Lihat laporan data buku dan statistik peminjaman</p>
    </a>

    <a href="{{ route('laporan.anggota') }}" class="block p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100">
        <div class="flex items-center mb-2">
            <svg class="w-8 h-8 text-yellow-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path>
            </svg>
            <h5 class="text-2xl font-bold tracking-tight text-gray-900">Laporan Anggota</h5>
        </div>
        <p class="font-normal text-gray-700">Lihat laporan data anggota dan aktivitas peminjaman</p>
    </a>
</div>
@endsection

