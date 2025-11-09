@extends('layouts.app')

@section('title', 'Detail Anggota')

@section('content')
<!-- Header Section with Gradient -->
<div class="mb-6">
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-lg shadow-lg p-6 text-white">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <!-- Avatar dengan Inisial -->
                <div class="relative">
                    <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center border-4 border-white shadow-xl overflow-hidden">
                        @php
                            // Ambil inisial dari nama (2 huruf pertama)
                            $namaParts = explode(' ', trim($anggota->nama));
                            if (count($namaParts) >= 2) {
                                // Jika ada lebih dari 1 kata, ambil huruf pertama dari 2 kata pertama
                                $inisial = strtoupper(substr($namaParts[0], 0, 1) . substr($namaParts[1], 0, 1));
                            } else {
                                // Jika hanya 1 kata, ambil 2 huruf pertama
                                $inisial = strtoupper(substr($anggota->nama, 0, 2));
                            }
                            
                            // Generate warna berdasarkan nama (konsisten untuk nama yang sama)
                            $warna = [
                                'bg-gradient-to-br from-blue-500 to-blue-600',
                                'bg-gradient-to-br from-green-500 to-green-600',
                                'bg-gradient-to-br from-purple-500 to-purple-600',
                                'bg-gradient-to-br from-pink-500 to-pink-600',
                                'bg-gradient-to-br from-yellow-500 to-yellow-600',
                                'bg-gradient-to-br from-indigo-500 to-indigo-600',
                                'bg-gradient-to-br from-teal-500 to-teal-600',
                                'bg-gradient-to-br from-orange-500 to-orange-600'
                            ];
                            $warnaIndex = ord(strtolower($anggota->nama[0])) % count($warna);
                        @endphp
                        <div class="w-full h-full {{ $warna[$warnaIndex] }} flex items-center justify-center">
                            <span class="text-3xl font-bold text-white drop-shadow-md">{{ $inisial ?: 'U' }}</span>
                        </div>
                    </div>
                    <!-- Badge status kecil di sudut kanan bawah -->
                    <div class="absolute -bottom-1 -right-1 w-7 h-7 {{ $anggota->status == 'aktif' ? 'bg-green-500' : 'bg-red-500' }} rounded-full border-4 border-white shadow-md flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                            @if($anggota->status == 'aktif')
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            @else
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            @endif
                        </svg>
                    </div>
                </div>
                <div>
                    <h1 class="text-3xl font-bold">{{ $anggota->nama }}</h1>
                    <p class="text-blue-100 mt-1">Informasi Lengkap Anggota Perpustakaan</p>
                </div>
            </div>
            <div class="text-right">
                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold shadow-md {{ $anggota->status == 'aktif' ? 'bg-green-500 text-white' : 'bg-red-500 text-white' }}">
                    <span class="w-2 h-2 rounded-full mr-2 bg-white"></span>
                    {{ ucfirst($anggota->status) }}
                </span>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Total Peminjaman</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">{{ $anggota->peminjaman->count() }}</p>
            </div>
            <div class="bg-blue-100 rounded-full p-3">
                <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"></path>
                </svg>
            </div>
        </div>
        </div>

    <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
        <div class="flex items-center justify-between">
        <div>
                <p class="text-sm font-medium text-gray-600">Sedang Dipinjam</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">{{ $anggota->peminjaman->where('status_pinjam', 'dipinjam')->count() }}</p>
            </div>
            <div class="bg-green-100 rounded-full p-3">
                <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                </svg>
            </div>
        </div>
        </div>

    <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-purple-500">
        <div class="flex items-center justify-between">
        <div>
                <p class="text-sm font-medium text-gray-600">Sudah Dikembalikan</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">{{ $anggota->peminjaman->where('status_pinjam', 'dikembalikan')->count() }}</p>
            </div>
            <div class="bg-purple-100 rounded-full p-3">
                <svg class="w-8 h-8 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Main Information Card -->
<div class="bg-white rounded-lg shadow-lg overflow-hidden">
    <!-- Card Header -->
    <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
        <h2 class="text-xl font-bold text-gray-800 flex items-center">
            <svg class="w-6 h-6 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
            </svg>
            Informasi Personal
        </h2>
    </div>

    <!-- Card Body -->
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Nama Lengkap -->
            <div class="md:col-span-2">
                <div class="flex items-start space-x-4 p-4 bg-blue-50 rounded-lg border border-blue-100">
                    <div class="bg-blue-500 rounded-lg p-2">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <label class="block text-sm font-semibold text-gray-600 mb-1">Nama Lengkap</label>
                        <p class="text-lg font-medium text-gray-900">{{ $anggota->nama }}</p>
                    </div>
                </div>
            </div>

            <!-- Alamat -->
            <div class="md:col-span-2">
                <div class="flex items-start space-x-4 p-4 bg-green-50 rounded-lg border border-green-100">
                    <div class="bg-green-500 rounded-lg p-2">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <label class="block text-sm font-semibold text-gray-600 mb-1">Alamat</label>
                        <p class="text-lg text-gray-900 leading-relaxed">{{ $anggota->alamat }}</p>
                    </div>
                </div>
            </div>

            <!-- No. Telepon -->
            <div>
                <div class="flex items-start space-x-4 p-4 bg-purple-50 rounded-lg border border-purple-100">
                    <div class="bg-purple-500 rounded-lg p-2">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <label class="block text-sm font-semibold text-gray-600 mb-1">No. Telepon</label>
                        <p class="text-lg font-medium text-gray-900">{{ $anggota->no_telp }}</p>
                    </div>
                </div>
        </div>

            <!-- Tanggal Daftar -->
        <div>
                <div class="flex items-start space-x-4 p-4 bg-yellow-50 rounded-lg border border-yellow-100">
                    <div class="bg-yellow-500 rounded-lg p-2">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <label class="block text-sm font-semibold text-gray-600 mb-1">Tanggal Daftar</label>
                        <p class="text-lg font-medium text-gray-900">{{ $anggota->tgl_daftar ? $anggota->tgl_daftar->format('d F Y') : '-' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card Footer with Actions -->
    <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex justify-between items-center">
        <a href="{{ route('anggota.index') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:ring-4 focus:ring-gray-200 transition duration-200">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"></path>
            </svg>
            Kembali
        </a>
        <a href="{{ route('anggota.edit', $anggota->id) }}" class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-lg hover:from-yellow-600 hover:to-yellow-700 focus:ring-4 focus:ring-yellow-300 shadow-md transition duration-200">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
            </svg>
            Edit Data
        </a>
    </div>
</div>
@endsection


