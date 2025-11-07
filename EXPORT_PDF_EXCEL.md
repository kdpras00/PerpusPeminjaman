# Export Laporan PDF & Excel

Semua laporan di aplikasi Peminjaman Buku sudah dilengkapi dengan fitur **Download PDF** dan **Export Excel**! 📊📄

## 📦 Library yang Digunakan

### 1. **Laravel DomPDF** (untuk PDF)
```bash
composer require barryvdh/laravel-dompdf
```
- Package: `barryvdh/laravel-dompdf`
- Fitur: Generate PDF dari HTML/Blade views
- Format: PDF dengan styling inline

### 2. **Laravel Excel** (untuk Excel)
```bash
composer require maatwebsite/excel
```
- Package: `maatwebsite/excel`
- Fitur: Export data ke Excel (.xlsx)
- Format: Excel dengan headers dan formatting

---

## 📋 Fitur Export yang Tersedia

### 1. **Laporan Peminjaman** ✅
- **PDF**: `laporan-peminjaman-YYYY-MM-DD.pdf`
- **Excel**: `laporan-peminjaman-YYYY-MM-DD.xlsx`
- **Filter Support**: Tanggal mulai, tanggal akhir, status
- **Kolom**: No, Tanggal, Anggota, Buku, Harus Kembali, Status, Petugas

### 2. **Laporan Pengembalian** ✅
- **PDF**: `laporan-pengembalian-YYYY-MM-DD.pdf`
- **Excel**: `laporan-pengembalian-YYYY-MM-DD.xlsx`
- **Filter Support**: Tanggal mulai, tanggal akhir
- **Kolom**: No, Tgl Kembali, Anggota, Buku, Tgl Pinjam, Harus Kembali, Denda
- **Extra**: Total Denda ditampilkan di footer

### 3. **Laporan Buku** ✅
- **PDF**: `laporan-buku-YYYY-MM-DD.pdf`
- **Excel**: `laporan-buku-YYYY-MM-DD.xlsx`
- **Kolom**: No, Kode, Judul, Pengarang, Penerbit, Tahun, Stok, Total Peminjaman, Sedang Dipinjam

### 4. **Laporan Anggota** ✅
- **PDF**: `laporan-anggota-YYYY-MM-DD.pdf`
- **Excel**: `laporan-anggota-YYYY-MM-DD.xlsx`
- **Kolom**: No, Nama, Alamat, No. Telepon, Tgl Daftar, Status, Total Peminjaman

---

## 🎯 Cara Menggunakan

### Dari UI Web:

1. **Buka Halaman Laporan**
   - Dashboard → Cetak Laporan → Pilih jenis laporan

2. **Filter Data (opsional)**
   - Untuk Peminjaman & Pengembalian: Set tanggal mulai & akhir
   - Klik tombol "Filter"

3. **Download**
   - Klik tombol **"Download PDF"** (merah) → File PDF akan ter-download
   - Klik tombol **"Download Excel"** (hijau emerald) → File Excel akan ter-download

---

## 🔧 Implementasi Teknis

### Export Classes (Laravel Excel)

Lokasi: `app/Exports/`

1. **PeminjamanExport.php**
   - Support filter: tanggal_mulai, tanggal_akhir, status
   - With relations: anggota, buku, petugas

2. **PengembalianExport.php**
   - Support filter: tanggal_mulai, tanggal_akhir
   - With relations: peminjaman.anggota, peminjaman.buku

3. **BukuExport.php**
   - With count: total peminjaman & sedang dipinjam
   - Statistik lengkap per buku

4. **AnggotaExport.php**
   - With count: total peminjaman per anggota
   - Sorted by activity (most active first)

### PDF Views

Lokasi: `resources/views/laporan/pdf/`

1. **peminjaman.blade.php**
2. **pengembalian.blade.php**
3. **buku.blade.php**
4. **anggota.blade.php**

**Styling:** Inline CSS (karena PDF tidak support external CSS)

### Controller Methods

Lokasi: `app/Http/Controllers/LaporanController.php`

```php
// PDF Methods
peminjamanPdf(Request $request)
pengembalianPdf(Request $request)
bukuPdf()
anggotaPdf()

// Excel Methods
peminjamanExcel(Request $request)
pengembalianExcel(Request $request)
bukuExcel()
anggotaExcel()
```

### Routes

Lokasi: `routes/web.php`

```php
// Peminjaman
Route::get('/laporan/peminjaman/pdf', [LaporanController::class, 'peminjamanPdf']);
Route::get('/laporan/peminjaman/excel', [LaporanController::class, 'peminjamanExcel']);

// Pengembalian
Route::get('/laporan/pengembalian/pdf', [LaporanController::class, 'pengembalianPdf']);
Route::get('/laporan/pengembalian/excel', [LaporanController::class, 'pengembalianExcel']);

// Buku
Route::get('/laporan/buku/pdf', [LaporanController::class, 'bukuPdf']);
Route::get('/laporan/buku/excel', [LaporanController::class, 'bukuExcel']);

// Anggota
Route::get('/laporan/anggota/pdf', [LaporanController::class, 'anggotaPdf']);
Route::get('/laporan/anggota/excel', [LaporanController::class, 'anggotaExcel']);
```

---

## 📊 Format Data

### PDF
- **Header**: Judul laporan + Sistem Perpustakaan
- **Periode**: Ditampilkan jika ada filter tanggal
- **Table**: Data lengkap dengan styling
- **Footer**: Timestamp "Dicetak pada: dd/mm/yyyy HH:mm:ss"
- **Styling**: Professional dengan borders & badges

### Excel
- **Sheet 1**: Data laporan
- **Row 1**: Headers (bold)
- **Row 2+**: Data records
- **Format**: .xlsx (Excel 2007+)
- **Encoding**: UTF-8

---

## 🎨 UI Buttons

### Layout:
```
[← Kembali] [🖨️ Print] [📄 Download PDF] [📊 Download Excel]
```

### Warna:
- **Kembali**: Gray (bg-gray-200)
- **Print**: Green (bg-green-700)
- **Download PDF**: Red (bg-red-700)
- **Download Excel**: Emerald (bg-emerald-700)

### Icons:
- Kembali: Arrow left
- Print: Printer
- PDF: Document with arrow down
- Excel: Upload/download icon

---

## 🔍 Filter Support

### Laporan Peminjaman
```php
?tanggal_mulai=2025-01-01&tanggal_akhir=2025-12-31&status=dipinjam
```

### Laporan Pengembalian
```php
?tanggal_mulai=2025-01-01&tanggal_akhir=2025-12-31
```

### Laporan Buku & Anggota
Tidak ada filter (menampilkan semua data)

---

## 📝 Contoh Export

### PDF:
```php
$pdf = Pdf::loadView('laporan.pdf.peminjaman', compact('peminjamans', 'filters'));
return $pdf->download('laporan-peminjaman-'.date('Y-m-d').'.pdf');
```

### Excel:
```php
return Excel::download(
    new PeminjamanExport($filters), 
    'laporan-peminjaman-'.date('Y-m-d').'.xlsx'
);
```

---

## ✅ Fitur Lengkap

- ✅ Download PDF untuk semua laporan
- ✅ Export Excel untuk semua laporan
- ✅ Support filter tanggal
- ✅ Nama file dengan timestamp
- ✅ Professional styling (PDF)
- ✅ Headers & formatting (Excel)
- ✅ Responsive buttons
- ✅ Icons pada setiap tombol
- ✅ Total denda di laporan pengembalian
- ✅ Statistik di laporan buku & anggota

---

## 🎯 Testing

1. **Test Download PDF**:
   - Buka laporan → Klik "Download PDF"
   - File PDF akan ter-download otomatis
   - Buka file PDF → Check layout & data

2. **Test Export Excel**:
   - Buka laporan → Klik "Download Excel"
   - File .xlsx akan ter-download otomatis
   - Buka di Excel/Google Sheets → Check headers & data

3. **Test dengan Filter**:
   - Set filter tanggal
   - Download PDF/Excel
   - Verify data sesuai filter

---

## 📚 Dependencies

```json
"require": {
    "barryvdh/laravel-dompdf": "^3.1",
    "maatwebsite/excel": "^3.1"
}
```

---

## 🚀 Status

**Export PDF & Excel**: ✅ **FULLY IMPLEMENTED**

Semua 4 jenis laporan sudah support download PDF dan Excel dengan filter yang sesuai! 🎊

---

## 📖 Dokumentasi Library

- **DomPDF**: https://github.com/barryvdh/laravel-dompdf
- **Laravel Excel**: https://laravel-excel.com/

