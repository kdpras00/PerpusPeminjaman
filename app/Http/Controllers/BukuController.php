<?php

namespace App\Http\Controllers;

use App\Constants\StatusConstants;
use App\Http\Requests\BukuRequest;
use App\Models\Buku;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $bukus = Buku::orderBy('created_at', 'desc')
            ->paginate(StatusConstants::PAGINATION_PER_PAGE);

        return view('buku.index', compact('bukus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('buku.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BukuRequest $request): RedirectResponse
    {
        Buku::create($request->validated());

        return redirect()
            ->route('buku.index')
            ->with('success', 'Data buku berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Buku $buku): View
    {
        return view('buku.show', compact('buku'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Buku $buku): View
    {
        return view('buku.edit', compact('buku'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BukuRequest $request, Buku $buku): RedirectResponse
    {
        $buku->update($request->validated());

        return redirect()
            ->route('buku.index')
            ->with('success', 'Data buku berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Buku $buku): RedirectResponse
    {
        $buku->delete();

        return redirect()
            ->route('buku.index')
            ->with('success', 'Data buku berhasil dihapus!');
    }
}
