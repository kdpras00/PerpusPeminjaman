@extends('layouts.app')

@section('title', 'Proses Pengembalian')

@section('content')
<div class="mb-4">
    <h1 class="text-2xl font-bold text-gray-900">Proses Pengembalian Buku</h1>
    <p class="text-gray-600">Masukkan data transaksi pengembalian</p>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <form action="{{ route('pengembalian.store') }}" method="POST">
        @csrf
        
        <div class="grid grid-cols-1 gap-6">
            <div>
                <label for="peminjaman_id" class="block mb-2 text-sm font-medium text-gray-900">Pilih Peminjaman yang Akan Dikembalikan</label>
                <select name="peminjaman_id" id="peminjaman_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required onchange="updateDenda()">
                    <option value="">-- Pilih Peminjaman --</option>
                    @foreach($peminjamans as $peminjaman)
                        <option value="{{ $peminjaman->id }}" 
                                data-tgl-harus-kembali="{{ $peminjaman->tgl_harus_kembali->format('Y-m-d') }}"
                                {{ old('peminjaman_id') == $peminjaman->id ? 'selected' : '' }}>
                            {{ $peminjaman->anggota->nama }} - {{ $peminjaman->buku->judul }} 
                            (Pinjam: {{ $peminjaman->tgl_pinjam->format('d/m/Y') }}, Harus Kembali: {{ $peminjaman->tgl_harus_kembali->format('d/m/Y') }})
                        </option>
                    @endforeach
                </select>
                @error('peminjaman_id')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="tgl_kembali_realisasi" class="block mb-2 text-sm font-medium text-gray-900">Tanggal Kembali</label>
                <input type="date" name="tgl_kembali_realisasi" id="tgl_kembali_realisasi" value="{{ old('tgl_kembali_realisasi', date('Y-m-d')) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required onchange="updateDenda()">
                @error('tgl_kembali_realisasi')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div id="info-denda" class="hidden p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                <h3 class="text-sm font-medium text-yellow-800 mb-2">Informasi Denda</h3>
                <p class="text-sm text-yellow-700">Keterlambatan: <span id="hari-terlambat">0</span> hari</p>
                <p class="text-sm font-bold text-yellow-900 mt-1">Total Denda: Rp <span id="total-denda">0</span></p>
            </div>
        </div>

        <div class="mt-6 flex space-x-4">
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">
                Proses Pengembalian
            </button>
            <a href="{{ route('pengembalian.index') }}" class="text-gray-700 bg-gray-200 hover:bg-gray-300 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5">
                Batal
            </a>
        </div>
    </form>
</div>

<script>
function updateDenda() {
    const peminjamanSelect = document.getElementById('peminjaman_id');
    const tglKembaliInput = document.getElementById('tgl_kembali_realisasi');
    const infoDenda = document.getElementById('info-denda');
    
    if (peminjamanSelect.value && tglKembaliInput.value) {
        const selectedOption = peminjamanSelect.options[peminjamanSelect.selectedIndex];
        const tglHarusKembali = new Date(selectedOption.dataset.tglHarusKembali);
        const tglKembaliRealisasi = new Date(tglKembaliInput.value);
        
        const diffTime = tglKembaliRealisasi - tglHarusKembali;
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
        
        if (diffDays > 0) {
            const denda = diffDays * 1000;
            document.getElementById('hari-terlambat').textContent = diffDays;
            document.getElementById('total-denda').textContent = denda.toLocaleString('id-ID');
            infoDenda.classList.remove('hidden');
        } else {
            infoDenda.classList.add('hidden');
        }
    } else {
        infoDenda.classList.add('hidden');
    }
}
</script>
@endsection

