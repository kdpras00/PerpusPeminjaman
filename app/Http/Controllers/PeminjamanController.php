<?php

namespace App\Http\Controllers;

use App\Constants\StatusConstants;
use App\Http\Requests\PeminjamanRequest;
use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Services\PeminjamanService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class PeminjamanController extends Controller
{
    public function __construct(
        private readonly PeminjamanService $peminjamanService
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = Peminjaman::with(['anggota', 'buku', 'petugas']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('anggota', function ($q) use ($search) {
                    $q->where('nama', 'like', "%{$search}%");
                })
                ->orWhereHas('buku', function ($q) use ($search) {
                    $q->where('judul', 'like', "%{$search}%")
                        ->orWhere('kode_buku', 'like', "%{$search}%");
                });
            });
        }

        $peminjamans = $query->orderBy('created_at', 'desc')
            ->paginate(StatusConstants::PAGINATION_PER_PAGE)
            ->withQueryString();

        return view('peminjaman.index', compact('peminjamans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $anggotas = Anggota::aktif()->get();
        $bukus = Buku::available()->get();

        return view('peminjaman.create', compact('anggotas', 'bukus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PeminjamanRequest $request): RedirectResponse
    {
        try {
            $petugas = Session::get('petugas');

            if (!$petugas) {
                return back()->with('error', 'Session tidak valid. Silakan login kembali.');
            }

            $this->peminjamanService->createPeminjaman(
                $request->validated(),
                $petugas->id
            );

            return redirect()
                ->route('peminjaman.index')
                ->with('success', 'Transaksi peminjaman berhasil!');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Peminjaman $peminjaman): View
    {
        $peminjaman->load(['anggota', 'buku', 'petugas', 'pengembalian']);

        return view('peminjaman.show', compact('peminjaman'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Peminjaman $peminjaman): View
    {
        $anggotas = Anggota::aktif()->get();
        $bukus = Buku::all();

        return view('peminjaman.edit', compact('peminjaman', 'anggotas', 'bukus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PeminjamanRequest $request, Peminjaman $peminjaman): RedirectResponse
    {
        $this->peminjamanService->updatePeminjaman(
            $peminjaman,
            $request->validated()
        );

        return redirect()
            ->route('peminjaman.index')
            ->with('success', 'Data peminjaman berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Peminjaman $peminjaman): RedirectResponse
    {
        try {
            $this->peminjamanService->deletePeminjaman($peminjaman);

            return redirect()
                ->route('peminjaman.index')
                ->with('success', 'Data peminjaman berhasil dihapus!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
