<?php

namespace App\Http\Controllers;

use App\Constants\StatusConstants;
use App\Http\Requests\PengembalianRequest;
use App\Models\Pengembalian;
use App\Services\PengembalianService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PengembalianController extends Controller
{
    public function __construct(
        private readonly PengembalianService $pengembalianService
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $pengembalians = Pengembalian::with(['peminjaman.anggota', 'peminjaman.buku'])
            ->orderBy('created_at', 'desc')
            ->paginate(StatusConstants::PAGINATION_PER_PAGE);

        return view('pengembalian.index', compact('pengembalians'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $peminjamans = \App\Models\Peminjaman::with(['anggota', 'buku'])
            ->dipinjam()
            ->belumDikembalikan()
            ->get();

        return view('pengembalian.create', compact('peminjamans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PengembalianRequest $request): RedirectResponse
    {
        try {
            $pengembalian = $this->pengembalianService->createPengembalian(
                $request->validated()
            );

            $dendaFormatted = number_format($pengembalian->denda, 0, ',', '.');

            return redirect()
                ->route('pengembalian.index')
                ->with('success', "Transaksi pengembalian berhasil! Denda: Rp {$dendaFormatted}");
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Pengembalian $pengembalian): View
    {
        $pengembalian->load([
            'peminjaman.anggota',
            'peminjaman.buku',
            'peminjaman.petugas'
        ]);

        return view('pengembalian.show', compact('pengembalian'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pengembalian $pengembalian): View
    {
        $pengembalian->load('peminjaman');

        return view('pengembalian.edit', compact('pengembalian'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PengembalianRequest $request, Pengembalian $pengembalian): RedirectResponse
    {
        try {
            $this->pengembalianService->updatePengembalian(
                $pengembalian,
                $request->validated()
            );

            return redirect()
                ->route('pengembalian.index')
                ->with('success', 'Data pengembalian berhasil diupdate!');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pengembalian $pengembalian): RedirectResponse
    {
        try {
            $this->pengembalianService->deletePengembalian($pengembalian);

            return redirect()
                ->route('pengembalian.index')
                ->with('success', 'Data pengembalian berhasil dihapus!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
