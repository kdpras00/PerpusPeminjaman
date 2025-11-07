<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Anggota;

class AnggotaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $anggotas = Anggota::orderBy('created_at', 'desc')->paginate(10);
        return view('anggota.index', compact('anggotas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('anggota.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'no_telp' => 'required',
            'tgl_daftar' => 'required|date',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        Anggota::create($request->all());

        return redirect()->route('anggota.index')->with('success', 'Data anggota berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $anggota = Anggota::with('peminjaman')->findOrFail($id);
        return view('anggota.show', compact('anggota'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $anggota = Anggota::findOrFail($id);
        return view('anggota.edit', compact('anggota'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $anggota = Anggota::findOrFail($id);
        
        $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'no_telp' => 'required',
            'tgl_daftar' => 'required|date',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $anggota->update($request->all());

        return redirect()->route('anggota.index')->with('success', 'Data anggota berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $anggota = Anggota::findOrFail($id);
        $anggota->delete();

        return redirect()->route('anggota.index')->with('success', 'Data anggota berhasil dihapus!');
    }
}
