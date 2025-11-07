<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Anggota;
use App\Models\Buku;
use Illuminate\Support\Facades\Session;

class PeminjamanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $peminjamans = Peminjaman::with(['anggota', 'buku', 'petugas'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('peminjaman.index', compact('peminjamans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $anggotas = Anggota::where('status', 'aktif')->get();
        $bukus = Buku::where('stok', '>', 0)->get();
        return view('peminjaman.create', compact('anggotas', 'bukus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'anggota_id' => 'required|exists:anggota,id',
            'buku_id' => 'required|exists:buku,id',
            'tgl_pinjam' => 'required|date',
            'tgl_harus_kembali' => 'required|date|after:tgl_pinjam',
        ]);

        // Check if book is available
        $buku = Buku::findOrFail($request->buku_id);
        if ($buku->stok <= 0) {
            return back()->with('error', 'Stok buku tidak tersedia!');
        }

        $petugas = Session::get('petugas');

        Peminjaman::create([
            'anggota_id' => $request->anggota_id,
            'buku_id' => $request->buku_id,
            'petugas_id' => $petugas->id,
            'tgl_pinjam' => $request->tgl_pinjam,
            'tgl_harus_kembali' => $request->tgl_harus_kembali,
            'status_pinjam' => 'dipinjam',
        ]);

        // Decrease book stock
        $buku->update(['stok' => $buku->stok - 1]);

        return redirect()->route('peminjaman.index')->with('success', 'Transaksi peminjaman berhasil!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $peminjaman = Peminjaman::with(['anggota', 'buku', 'petugas', 'pengembalian'])
            ->findOrFail($id);
        return view('peminjaman.show', compact('peminjaman'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $anggotas = Anggota::where('status', 'aktif')->get();
        $bukus = Buku::all();
        return view('peminjaman.edit', compact('peminjaman', 'anggotas', 'bukus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        
        $request->validate([
            'anggota_id' => 'required|exists:anggota,id',
            'buku_id' => 'required|exists:buku,id',
            'tgl_pinjam' => 'required|date',
            'tgl_harus_kembali' => 'required|date|after:tgl_pinjam',
        ]);

        $peminjaman->update($request->only(['anggota_id', 'buku_id', 'tgl_pinjam', 'tgl_harus_kembali']));

        return redirect()->route('peminjaman.index')->with('success', 'Data peminjaman berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        
        // Return book stock if not returned yet
        if ($peminjaman->status_pinjam == 'dipinjam') {
            $buku = Buku::findOrFail($peminjaman->buku_id);
            $buku->update(['stok' => $buku->stok + 1]);
        }
        
        $peminjaman->delete();

        return redirect()->route('peminjaman.index')->with('success', 'Data peminjaman berhasil dihapus!');
    }
}
