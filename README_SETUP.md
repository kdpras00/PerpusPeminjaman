# Sistem Peminjaman Buku - Panduan Setup

Website peminjaman buku menggunakan Laravel 12, Flowbite UI, dan Tailwind CSS v4.

## 📋 Fitur Utama

✅ **Authentication System**

-   Login untuk Admin dan Petugas Perpustakaan
-   Session-based authentication

✅ **Manajemen Data Master**

-   CRUD Buku (kode buku, judul, pengarang, penerbit, tahun terbit, stok)
-   CRUD Anggota (nama, alamat, no. telepon, tanggal daftar, status)

✅ **Transaksi**

-   Peminjaman Buku (dengan pengecekan stok otomatis)
-   Pengembalian Buku (dengan perhitungan denda otomatis Rp 1.000/hari)

✅ **Laporan**

-   Laporan Peminjaman (dengan filter tanggal dan status)
-   Laporan Pengembalian (dengan total denda)
-   Laporan Buku (dengan statistik peminjaman)
-   Laporan Anggota (dengan aktivitas peminjaman)
-   **Download PDF & Export Excel** untuk semua laporan

✅ **UI Modern**

-   Responsive design dengan Tailwind CSS v4
-   Komponen UI dari Flowbite
-   Dashboard dengan statistik
-   **SweetAlert2** untuk notifikasi dan konfirmasi yang cantik

## 🛠️ Teknologi

-   **Backend**: PHP 8.2+, Laravel 12
-   **Frontend**: Tailwind CSS v4, Flowbite, SweetAlert2, Vite
-   **Database**: MySQL

## 📦 Cara Setup

### 1. Setup Environment

Pastikan XAMPP sudah terinstall dan Apache + MySQL sudah running.

### 2. Buat Database

Buka **phpMyAdmin** (http://localhost/phpmyadmin) dan buat database baru:

```sql
CREATE DATABASE perpusPinjam;
```

### 3. Konfigurasi .env

Pastikan file `.env` sudah ada dan sesuaikan konfigurasi database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=perpusPinjam
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Install Dependencies

Jika belum diinstall:

```bash
composer install
npm install
```

### 5. Jalankan Migration dan Seeder

```bash
php artisan migrate:fresh --seed
```

### 6. Build Assets

```bash
npm run build
```

### 7. Jalankan Server

```bash
php artisan serve
```
### 7. Jalankan Key Generate
```bash
php artisan key:generate
```


Aplikasi akan berjalan di: **http://localhost:8000**

## 👤 Akun Default

Setelah seeder dijalankan, gunakan akun berikut untuk login:

### 👨‍💼 Admin

-   **Username**: `admin`
-   **Password**: `admin123`
-   **Role**: Admin
-   **Akses**: Dashboard, Kelola Data Buku, Kelola Data Anggota, Laporan

### 👤 Petugas Perpustakaan

-   **Username**: `petugas`
-   **Password**: `petugas123`
-   **Role**: Petugas
-   **Akses**: Dashboard, Kelola Data Buku, Kelola Data Anggota, Transaksi Peminjaman, Transaksi Pengembalian, Laporan

> **Note:** Admin fokus pada manajemen data & laporan. Petugas yang menangani transaksi peminjaman/pengembalian dengan anggota.

## 📂 Struktur Database

### Tabel Utama

1. **petugas** - Data admin dan petugas

    - id, nama_petugas, username, password, role

2. **anggota** - Data anggota perpustakaan

    - id, nama, alamat, no_telp, tgl_daftar, status

3. **buku** - Data buku

    - id, kode_buku, judul, pengarang, penerbit, tahun_terbit, stok

4. **peminjaman** - Transaksi peminjaman

    - id, anggota_id, buku_id, petugas_id, tgl_pinjam, tgl_harus_kembali, status_pinjam

5. **pengembalian** - Transaksi pengembalian
    - id, peminjaman_id, tgl_kembali_realisasi, denda

## 🎯 Use Case Diagram

Sesuai dengan requirement:

### Aktor:

-   **Admin**: Kelola semua data dan laporan
-   **Petugas Perpustakaan**: Kelola transaksi, anggota, dan buku
-   **Anggota**: Data peminjaman (dikelola oleh petugas)

### Use Case:

-   Login (Admin & Petugas)
-   Kelola Data Buku
-   Kelola Data Anggota
-   Transaksi Peminjaman
-   Transaksi Pengembalian
-   Cetak Laporan

## 🔄 Activity Diagram

### Proses Peminjaman:

1. Anggota datang ke perpustakaan
2. Petugas verifikasi keanggotaan
3. Cek ketersediaan buku
4. Catat transaksi peminjaman
5. Update stok buku (berkurang)
6. Cetak bukti peminjaman

### Proses Pengembalian:

1. Anggota mengembalikan buku
2. Petugas verifikasi transaksi
3. Cek tanggal (hitung denda jika terlambat)
4. Catat transaksi pengembalian
5. Update stok buku (bertambah)
6. Cetak bukti pengembalian

## 📊 Class Diagram

Relasi antar Class:

-   Anggota ← 1:N → Peminjaman
-   Buku ← 1:N → Peminjaman
-   Petugas ← 1:N → Peminjaman
-   Peminjaman ← 1:1 → Pengembalian

## 🖼️ Sequence Diagram

### Peminjaman Buku:

Petugas → Form Peminjaman → Controller → Database

-   Validasi data anggota dan buku
-   Cek stok buku
-   Simpan transaksi
-   Update stok buku

### Pengembalian Buku:

Petugas → Form Pengembalian → Controller → Database

-   Cari data peminjaman
-   Hitung denda (jika ada)
-   Simpan transaksi pengembalian
-   Update status peminjaman
-   Update stok buku

## 📝 Catatan

-   Denda keterlambatan: **Rp 1.000 per hari**
-   Masa peminjaman default: **7 hari**
-   Stok buku otomatis ter-update saat peminjaman dan pengembalian
-   Laporan dapat dicetak langsung (Print)
-   **SweetAlert2** digunakan untuk semua notifikasi (success/error toast & delete confirmation)

## 🚀 Development

Untuk development dengan hot reload:

```bash
npm run dev
```

Kemudian di terminal lain:

```bash
php artisan serve
```

## 📄 Lisensi

MIT License

---

**Dibuat menggunakan Laravel 12 + Flowbite UI + Tailwind CSS v4**
