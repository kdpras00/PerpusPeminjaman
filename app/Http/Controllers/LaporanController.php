<?php

namespace App\Http\Controllers;

use App\Exports\AnggotaExport;
use App\Exports\BukuExport;
use App\Exports\PeminjamanExport;
use App\Exports\PengembalianExport;
use App\Services\LaporanService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class LaporanController extends Controller
{
    public function __construct(
        private readonly LaporanService $laporanService
    ) {
    }

    /**
     * Display the report index page
     */
    public function index(): View
    {
        return view('laporan.index');
    }

    /**
     * Display peminjaman report
     */
    public function peminjaman(Request $request): View
    {
        $filters = $this->getPeminjamanFilters($request);
        $peminjamans = $this->laporanService->buildPeminjamanQuery($filters)->get();

        return view('laporan.peminjaman', compact('peminjamans'));
    }

    /**
     * Generate peminjaman PDF report
     */
    public function peminjamanPdf(Request $request): Response
    {
        $filters = $this->getPeminjamanFilters($request);
        $peminjamans = $this->laporanService->buildPeminjamanQuery($filters)->get();
        
        $pdf = Pdf::loadView('laporan.pdf.peminjaman', compact('peminjamans', 'filters'));
        $filename = 'laporan-peminjaman-' . date('Y-m-d') . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Generate peminjaman Excel report
     */
    public function peminjamanExcel(Request $request): BinaryFileResponse
    {
        $filters = $this->getPeminjamanFilters($request);
        $filename = 'laporan-peminjaman-' . date('Y-m-d') . '.xlsx';

        return Excel::download(new PeminjamanExport($filters), $filename);
    }

    /**
     * Display pengembalian report
     */
    public function pengembalian(Request $request): View
    {
        $filters = $this->getPengembalianFilters($request);
        $pengembalians = $this->laporanService->buildPengembalianQuery($filters)->get();
        $totalDenda = $pengembalians->sum('denda');

        return view('laporan.pengembalian', compact('pengembalians', 'totalDenda'));
    }

    /**
     * Generate pengembalian PDF report
     */
    public function pengembalianPdf(Request $request): Response
    {
        $filters = $this->getPengembalianFilters($request);
        $pengembalians = $this->laporanService->buildPengembalianQuery($filters)->get();
        $totalDenda = $pengembalians->sum('denda');
        
        $pdf = Pdf::loadView('laporan.pdf.pengembalian', compact('pengembalians', 'totalDenda', 'filters'));
        $filename = 'laporan-pengembalian-' . date('Y-m-d') . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Generate pengembalian Excel report
     */
    public function pengembalianExcel(Request $request): BinaryFileResponse
    {
        $filters = $this->getPengembalianFilters($request);
        $filename = 'laporan-pengembalian-' . date('Y-m-d') . '.xlsx';

        return Excel::download(new PengembalianExport($filters), $filename);
    }

    /**
     * Display buku report
     */
    public function buku(): View
    {
        $bukus = $this->laporanService->getBukuReport();

        return view('laporan.buku', compact('bukus'));
    }

    /**
     * Generate buku PDF report
     */
    public function bukuPdf(): Response
    {
        $bukus = $this->laporanService->getBukuReport();
        
        $pdf = Pdf::loadView('laporan.pdf.buku', compact('bukus'));
        $filename = 'laporan-buku-' . date('Y-m-d') . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Generate buku Excel report
     */
    public function bukuExcel(): BinaryFileResponse
    {
        $filename = 'laporan-buku-' . date('Y-m-d') . '.xlsx';

        return Excel::download(new BukuExport, $filename);
    }

    /**
     * Display anggota report
     */
    public function anggota(): View
    {
        $anggotas = $this->laporanService->getAnggotaReport();

        return view('laporan.anggota', compact('anggotas'));
    }

    /**
     * Generate anggota PDF report
     */
    public function anggotaPdf(): Response
    {
        $anggotas = $this->laporanService->getAnggotaReport();
        
        $pdf = Pdf::loadView('laporan.pdf.anggota', compact('anggotas'));
        $filename = 'laporan-anggota-' . date('Y-m-d') . '.pdf';

        return $pdf->download($filename);
    }

    /**
     * Generate anggota Excel report
     */
    public function anggotaExcel(): BinaryFileResponse
    {
        $filename = 'laporan-anggota-' . date('Y-m-d') . '.xlsx';

        return Excel::download(new AnggotaExport, $filename);
    }

    /**
     * Get peminjaman filters from request
     */
    private function getPeminjamanFilters(Request $request): array
    {
        return $request->only(['tanggal_mulai', 'tanggal_akhir', 'status']);
    }

    /**
     * Get pengembalian filters from request
     */
    private function getPengembalianFilters(Request $request): array
    {
        return $request->only(['tanggal_mulai', 'tanggal_akhir']);
    }
}

