<?php

namespace App\Http\Controllers;

use App\Constants\StatusConstants;
use App\Http\Requests\AnggotaRequest;
use App\Models\Anggota;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AnggotaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = Anggota::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('alamat', 'like', "%{$search}%")
                    ->orWhere('no_telp', 'like', "%{$search}%");
            });
        }

        $anggotas = $query->orderBy('created_at', 'desc')
            ->paginate(StatusConstants::PAGINATION_PER_PAGE)
            ->withQueryString();

        return view('anggota.index', compact('anggotas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('anggota.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AnggotaRequest $request): RedirectResponse
    {
        Anggota::create($request->validated());

        return redirect()
            ->route('anggota.index')
            ->with('success', 'Data anggota berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Anggota $anggota): View
    {
        $anggota->load('peminjaman.buku', 'peminjaman.pengembalian');

        return view('anggota.show', compact('anggota'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Anggota $anggota): View
    {
        return view('anggota.edit', compact('anggota'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AnggotaRequest $request, Anggota $anggota): RedirectResponse
    {
        $anggota->update($request->validated());

        return redirect()
            ->route('anggota.index')
            ->with('success', 'Data anggota berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Anggota $anggota): RedirectResponse
    {
        $anggota->delete();

        return redirect()
            ->route('anggota.index')
            ->with('success', 'Data anggota berhasil dihapus!');
    }
}
