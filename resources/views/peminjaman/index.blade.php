@extends('layouts.app')

@section('title', 'Data Peminjaman')

@section('content')
<div class="mb-4 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Data Peminjaman</h1>
        <p class="text-gray-600">Kelola transaksi peminjaman buku</p>
    </div>
    <a href="{{ route('peminjaman.create') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">
        <svg class="w-5 h-5 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
        </svg>
        Tambah Peminjaman
    </a>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3">Anggota</th>
                    <th scope="col" class="px-6 py-3">Buku</th>
                    <th scope="col" class="px-6 py-3">Tgl Pinjam</th>
                    <th scope="col" class="px-6 py-3">Harus Kembali</th>
                    <th scope="col" class="px-6 py-3">Status</th>
                    <th scope="col" class="px-6 py-3">Petugas</th>
                    <th scope="col" class="px-6 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($peminjamans as $peminjaman)
                <tr class="bg-white border-b hover:bg-gray-50">
                    <td class="px-6 py-4 font-medium text-gray-900">
                        {{ $peminjaman->anggota->nama }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $peminjaman->buku->judul }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $peminjaman->tgl_pinjam->format('d/m/Y') }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $peminjaman->tgl_harus_kembali->format('d/m/Y') }}
                    </td>
                    <td class="px-6 py-4">
                        @if($peminjaman->status_pinjam == 'dipinjam')
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Dipinjam</span>
                        @else
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Dikembalikan</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        {{ $peminjaman->petugas->nama_petugas }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex space-x-2">
                            <a href="{{ route('peminjaman.show', $peminjaman->id) }}" class="text-blue-600 hover:text-blue-900">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                                </svg>
                            </a>
                            @if($peminjaman->status_pinjam == 'dipinjam')
                            <a href="{{ route('peminjaman.edit', $peminjaman->id) }}" class="text-yellow-600 hover:text-yellow-900">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                </svg>
                            </a>
                            <form action="{{ route('peminjaman.destroy', $peminjaman->id) }}" method="POST" class="inline delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="text-red-600 hover:text-red-900 delete-btn">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                        Belum ada data peminjaman
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($peminjamans->hasPages())
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $peminjamans->links() }}
    </div>
    @endif
</div>

<script>
document.querySelectorAll('.delete-btn').forEach(button => {
    button.addEventListener('click', function(e) {
        e.preventDefault();
        const form = this.closest('.delete-form');
        
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});
</script>
@endsection

