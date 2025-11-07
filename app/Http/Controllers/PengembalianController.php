<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengembalian;
use App\Models\Peminjaman;
use App\Models\Buku;
use Carbon\Carbon;

class PengembalianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pengembalians = Pengembalian::with(['peminjaman.anggota', 'peminjaman.buku'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('pengembalian.index', compact('pengembalians'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $peminjamans = Peminjaman::with(['anggota', 'buku'])
            ->where('status_pinjam', 'dipinjam')
            ->whereDoesntHave('pengembalian')
            ->get();
        return view('pengembalian.create', compact('peminjamans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'peminjaman_id' => 'required|exists:peminjaman,id',
            'tgl_kembali_realisasi' => 'required|date',
        ]);

        $peminjaman = Peminjaman::findOrFail($request->peminjaman_id);
        
        // Calculate late fee (denda)
        $tglHarusKembali = Carbon::parse($peminjaman->tgl_harus_kembali);
        $tglKembaliRealisasi = Carbon::parse($request->tgl_kembali_realisasi);
        $denda = 0;
        
        if ($tglKembaliRealisasi->gt($tglHarusKembali)) {
            $hariTerlambat = $tglKembaliRealisasi->diffInDays($tglHarusKembali);
            $denda = $hariTerlambat * 1000; // Rp 1000 per hari
        }

        Pengembalian::create([
            'peminjaman_id' => $request->peminjaman_id,
            'tgl_kembali_realisasi' => $request->tgl_kembali_realisasi,
            'denda' => $denda,
        ]);

        // Update peminjaman status
        $peminjaman->update(['status_pinjam' => 'dikembalikan']);

        // Increase book stock
        $buku = Buku::findOrFail($peminjaman->buku_id);
        $buku->update(['stok' => $buku->stok + 1]);

        return redirect()->route('pengembalian.index')->with('success', 'Transaksi pengembalian berhasil! Denda: Rp ' . number_format($denda, 0, ',', '.'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pengembalian = Pengembalian::with(['peminjaman.anggota', 'peminjaman.buku', 'peminjaman.petugas'])
            ->findOrFail($id);
        return view('pengembalian.show', compact('pengembalian'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pengembalian = Pengembalian::with('peminjaman')->findOrFail($id);
        return view('pengembalian.edit', compact('pengembalian'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $pengembalian = Pengembalian::findOrFail($id);
        
        $request->validate([
            'tgl_kembali_realisasi' => 'required|date',
        ]);

        $peminjaman = Peminjaman::findOrFail($pengembalian->peminjaman_id);
        
        // Recalculate late fee
        $tglHarusKembali = Carbon::parse($peminjaman->tgl_harus_kembali);
        $tglKembaliRealisasi = Carbon::parse($request->tgl_kembali_realisasi);
        $denda = 0;
        
        if ($tglKembaliRealisasi->gt($tglHarusKembali)) {
            $hariTerlambat = $tglKembaliRealisasi->diffInDays($tglHarusKembali);
            $denda = $hariTerlambat * 1000;
        }

        $pengembalian->update([
            'tgl_kembali_realisasi' => $request->tgl_kembali_realisasi,
            'denda' => $denda,
        ]);

        return redirect()->route('pengembalian.index')->with('success', 'Data pengembalian berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pengembalian = Pengembalian::findOrFail($id);
        
        // Update peminjaman status back to dipinjam
        $peminjaman = Peminjaman::findOrFail($pengembalian->peminjaman_id);
        $peminjaman->update(['status_pinjam' => 'dipinjam']);
        
        // Decrease book stock again
        $buku = Buku::findOrFail($peminjaman->buku_id);
        $buku->update(['stok' => $buku->stok - 1]);
        
        $pengembalian->delete();

        return redirect()->route('pengembalian.index')->with('success', 'Data pengembalian berhasil dihapus!');
    }
}
