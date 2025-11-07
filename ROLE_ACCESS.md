# Role-Based Access Control (RBAC)

Aplikasi ini menggunakan **Role-Based Access Control** untuk membatasi akses menu dan fitur berdasarkan role pengguna.

## 👥 Role & Akses

### 👨‍💼 **Admin** (`role: 'admin'`)
Admin fokus pada **manajemen data master** dan **monitoring laporan**.

**Menu yang Bisa Diakses:**
- ✅ Dashboard (statistik)
- ✅ **Kelola Data Buku** (tambah, edit, hapus, lihat)
- ✅ **Kelola Data Anggota** (tambah, edit, hapus, lihat)
- ✅ **Cetak Laporan** (semua jenis laporan)

**Menu yang TIDAK Bisa Diakses:**
- ❌ Transaksi Peminjaman (hanya petugas)
- ❌ Transaksi Pengembalian (hanya petugas)

**Alasan:**
Admin tidak melakukan transaksi langsung dengan anggota. Fokus admin adalah mengelola data dan memonitor laporan.

---

### 👤 **Petugas Perpustakaan** (`role: 'petugas'`)
Petugas menangani **transaksi harian** dan **pengelolaan data**.

**Menu yang Bisa Diakses:**
- ✅ Dashboard (statistik)
- ✅ **Kelola Data Buku** (tambah, edit, hapus, lihat)
- ✅ **Kelola Data Anggota** (tambah, edit, hapus, lihat)
- ✅ **Transaksi Peminjaman** (proses peminjaman buku)
- ✅ **Transaksi Pengembalian** (proses pengembalian & hitung denda)
- ✅ **Cetak Laporan** (semua jenis laporan)

**Alasan:**
Petugas bertanggung jawab langsung melayani anggota perpustakaan untuk peminjaman dan pengembalian buku.

---

## 🔒 Implementasi Teknis

### 1. **Middleware `CheckRole`**
File: `app/Http/Middleware/CheckRole.php`

Middleware ini memeriksa role user yang login:
```php
if (!in_array($petugas->role, $roles)) {
    return redirect()->route('dashboard')
        ->with('error', 'Anda tidak memiliki akses ke halaman ini');
}
```

### 2. **Route Protection**
File: `routes/web.php`

```php
// Transaksi hanya untuk Petugas
Route::middleware(['check.role:petugas'])->group(function () {
    Route::resource('peminjaman', PeminjamanController::class);
    Route::resource('pengembalian', PengembalianController::class);
});
```

### 3. **Dynamic Sidebar**
File: `resources/views/layouts/app.blade.php`

Menu sidebar ditampilkan secara conditional:
```blade
@if(Session::get('petugas')->role == 'petugas')
    <!-- Menu Transaksi Peminjaman -->
    <!-- Menu Transaksi Pengembalian -->
@endif
```

---

## 📊 Matrix Akses

| **Menu/Fitur**              | **Admin** | **Petugas** |
|-----------------------------|-----------|-------------|
| Dashboard                   | ✅        | ✅          |
| Kelola Data Buku            | ✅        | ✅          |
| Kelola Data Anggota         | ✅        | ✅          |
| Transaksi Peminjaman        | ❌        | ✅          |
| Transaksi Pengembalian      | ❌        | ✅          |
| Cetak Laporan               | ✅        | ✅          |

---

## 🎯 Sesuai Use Case Diagram

### Admin
Sesuai diagram, Admin berinteraksi dengan:
- ✅ Login
- ✅ Kelola Data Buku
- ✅ Kelola Data Anggota
- ✅ Cetak Laporan

### Petugas Perpustakaan
Sesuai diagram, Petugas berinteraksi dengan:
- ✅ Login
- ✅ Kelola Data Buku
- ✅ Kelola Data Anggota
- ✅ **Transaksi Peminjaman** (handling anggota)
- ✅ **Transaksi Pengembalian** (handling anggota)
- ✅ Cetak Laporan

### Anggota
Anggota adalah **subjek** dari transaksi, bukan actor yang login ke sistem.

---

## 🧪 Testing Akses

### Test sebagai Admin:
1. Login dengan: `admin` / `admin123`
2. Cek sidebar: **TIDAK ADA** menu Transaksi Peminjaman & Pengembalian
3. Coba akses manual: `http://localhost:8000/peminjaman`
4. Hasil: Redirect ke dashboard dengan pesan error ✅

### Test sebagai Petugas:
1. Login dengan: `petugas` / `petugas123`
2. Cek sidebar: **ADA** semua menu termasuk Transaksi
3. Akses peminjaman & pengembalian: **Berhasil** ✅

---

## 🔐 Security Features

1. **Middleware Protection**: Route dilindungi di level middleware
2. **UI Hiding**: Menu tidak ditampilkan untuk role yang tidak berhak
3. **Redirect dengan Pesan**: User diarahkan dengan notifikasi SweetAlert2
4. **Session-based Auth**: Verifikasi role dari session

---

## 📝 Catatan Penting

- **Seeder sudah include role**: 
  - `admin` → role 'admin'
  - `petugas` → role 'petugas'

- **Semua transaksi** (peminjaman & pengembalian) **harus** dilakukan oleh Petugas
  
- **Admin fokus** pada data master dan monitoring/reporting

- **Middleware `check.role`** dapat digunakan untuk proteksi route lain jika diperlukan:
  ```php
  Route::middleware(['check.role:admin,petugas'])->group(function () {
      // Route yang bisa diakses admin DAN petugas
  });
  ```

---

## ✅ Status

**Role-Based Access Control**: ✅ **FULLY IMPLEMENTED**

Sesuai dengan use case diagram yang diberikan! 🎉

