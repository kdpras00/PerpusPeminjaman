<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\Buku;
use App\Models\Anggota;
use App\Exports\PeminjamanExport;
use App\Exports\PengembalianExport;
use App\Exports\BukuExport;
use App\Exports\AnggotaExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index()
    {
        return view('laporan.index');
    }

    public function peminjaman(Request $request)
    {
        $query = Peminjaman::with(['anggota', 'buku', 'petugas']);

        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('tgl_pinjam', '>=', $request->tanggal_mulai);
        }

        if ($request->filled('tanggal_akhir')) {
            $query->whereDate('tgl_pinjam', '<=', $request->tanggal_akhir);
        }

        if ($request->filled('status')) {
            $query->where('status_pinjam', $request->status);
        }

        $peminjamans = $query->orderBy('tgl_pinjam', 'desc')->get();

        return view('laporan.peminjaman', compact('peminjamans'));
    }

    public function peminjamanPdf(Request $request)
    {
        $filters = $request->only(['tanggal_mulai', 'tanggal_akhir', 'status']);
        
        $query = Peminjaman::with(['anggota', 'buku', 'petugas']);

        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('tgl_pinjam', '>=', $request->tanggal_mulai);
        }

        if ($request->filled('tanggal_akhir')) {
            $query->whereDate('tgl_pinjam', '<=', $request->tanggal_akhir);
        }

        if ($request->filled('status')) {
            $query->where('status_pinjam', $request->status);
        }

        $peminjamans = $query->orderBy('tgl_pinjam', 'desc')->get();
        
        $pdf = Pdf::loadView('laporan.pdf.peminjaman', compact('peminjamans', 'filters'));
        return $pdf->download('laporan-peminjaman-'.date('Y-m-d').'.pdf');
    }

    public function peminjamanExcel(Request $request)
    {
        $filters = $request->only(['tanggal_mulai', 'tanggal_akhir', 'status']);
        return Excel::download(new PeminjamanExport($filters), 'laporan-peminjaman-'.date('Y-m-d').'.xlsx');
    }

    public function pengembalian(Request $request)
    {
        $query = Pengembalian::with(['peminjaman.anggota', 'peminjaman.buku']);

        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('tgl_kembali_realisasi', '>=', $request->tanggal_mulai);
        }

        if ($request->filled('tanggal_akhir')) {
            $query->whereDate('tgl_kembali_realisasi', '<=', $request->tanggal_akhir);
        }

        $pengembalians = $query->orderBy('tgl_kembali_realisasi', 'desc')->get();
        $totalDenda = $pengembalians->sum('denda');

        return view('laporan.pengembalian', compact('pengembalians', 'totalDenda'));
    }

    public function pengembalianPdf(Request $request)
    {
        $filters = $request->only(['tanggal_mulai', 'tanggal_akhir']);
        
        $query = Pengembalian::with(['peminjaman.anggota', 'peminjaman.buku']);

        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('tgl_kembali_realisasi', '>=', $request->tanggal_mulai);
        }

        if ($request->filled('tanggal_akhir')) {
            $query->whereDate('tgl_kembali_realisasi', '<=', $request->tanggal_akhir);
        }

        $pengembalians = $query->orderBy('tgl_kembali_realisasi', 'desc')->get();
        $totalDenda = $pengembalians->sum('denda');
        
        $pdf = Pdf::loadView('laporan.pdf.pengembalian', compact('pengembalians', 'totalDenda', 'filters'));
        return $pdf->download('laporan-pengembalian-'.date('Y-m-d').'.pdf');
    }

    public function pengembalianExcel(Request $request)
    {
        $filters = $request->only(['tanggal_mulai', 'tanggal_akhir']);
        return Excel::download(new PengembalianExport($filters), 'laporan-pengembalian-'.date('Y-m-d').'.xlsx');
    }

    public function buku()
    {
        $bukus = Buku::withCount([
            'peminjaman',
            'peminjaman as peminjaman_aktif_count' => function ($query) {
                $query->where('status_pinjam', 'dipinjam');
            }
        ])->get();

        return view('laporan.buku', compact('bukus'));
    }

    public function bukuPdf()
    {
        $bukus = Buku::withCount([
            'peminjaman',
            'peminjaman as peminjaman_aktif_count' => function ($query) {
                $query->where('status_pinjam', 'dipinjam');
            }
        ])->get();
        
        $pdf = Pdf::loadView('laporan.pdf.buku', compact('bukus'));
        return $pdf->download('laporan-buku-'.date('Y-m-d').'.pdf');
    }

    public function bukuExcel()
    {
        return Excel::download(new BukuExport, 'laporan-buku-'.date('Y-m-d').'.xlsx');
    }

    public function anggota()
    {
        $anggotas = Anggota::withCount('peminjaman')
            ->orderBy('peminjaman_count', 'desc')
            ->get();

        return view('laporan.anggota', compact('anggotas'));
    }

    public function anggotaPdf()
    {
        $anggotas = Anggota::withCount('peminjaman')
            ->orderBy('peminjaman_count', 'desc')
            ->get();
        
        $pdf = Pdf::loadView('laporan.pdf.anggota', compact('anggotas'));
        return $pdf->download('laporan-anggota-'.date('Y-m-d').'.pdf');
    }

    public function anggotaExcel()
    {
        return Excel::download(new AnggotaExport, 'laporan-anggota-'.date('Y-m-d').'.xlsx');
    }
}

