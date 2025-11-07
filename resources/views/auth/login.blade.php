<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Peminjaman Buku</title>
    {{-- Memuat semua aset, termasuk SweetAlert melalui app.js --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100">
    <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
        
        <div class="w-full bg-white rounded-lg shadow md:mt-0 sm:max-w-md xl:p-0">
            <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl">
                    Login ke Akun Anda
                </h1>

                {{-- FORM HTML --}}
                <form class="space-y-4 md:space-y-6" action="{{ route('login.post') }}" method="POST" id="loginForm">
                    @csrf
                    <div>
                        <label for="username" class="block mb-2 text-sm font-medium text-gray-900">Username</label>
                        <input type="text" name="username" id="username" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5" placeholder="Masukkan username" required autofocus>
                        {{-- Laravel @error bisa dihapus jika AJAX menangani validasi, tapi boleh dipertahankan sebagai fallback --}}
                        @error('username')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Password</label>
                        <div class="relative">
                            <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 pr-10" required>
                            <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-600 hover:text-gray-900">
                                {{-- SVG Icons --}}
                                <svg id="eye-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"></svg>
                                <svg id="eye-slash-icon" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"></svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" id="submitButton" class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Login</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // SweetAlert for session messages (Hanya untuk kasus non-AJAX seperti Logout)
        // SweetAlert error/success untuk LOGIN akan ditangani oleh AJAX di bawah.
        
        // Cek Success Session (Misalnya dari Logout)
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                timer: 2000,
                showConfirmButton: false
            });
        @endif

        // Cek Error Session (Jika ada error non-login yang dikirim via session)
        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Informasi!',
                html: '<p class="text-lg font-semibold">{{ session('error') }}</p>',
                confirmButtonText: 'OK',
                confirmButtonColor: '#3b82f6'
            });
        @endif


        // =========================================================================
        // AJAX LOGIN LOGIC (Memperbaiki loading dan alert error)
        // =========================================================================
        
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault(); // Mencegah form submit normal
            
            const form = this;
            const formData = new FormData(form);
            const submitBtn = document.getElementById('submitButton');
            
            // Tampilkan loading SweetAlert
            Swal.fire({
                title: 'Memproses Login...',
                html: 'Mohon tunggu sebentar',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading();
                    submitBtn.disabled = true; // Nonaktifkan tombol saat loading
                }
            });

            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest', // Penting untuk deteksi AJAX di Laravel
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if (response.status === 422) { // Kode untuk Validation Errors
                    return response.json().then(data => { throw { status: 422, errors: data.errors } });
                }
                if (!response.ok) { // Kode untuk General Authentication Failure (mis. 401)
                    return response.json().then(data => { throw { status: response.status, message: data.message || 'Login gagal.' } });
                }
                return response.json(); // Respons sukses (200)
            })
            .then(data => {
                // SUCCESS
                Swal.fire({
                    icon: 'success',
                    title: 'Login Berhasil!',
                    text: data.message || 'Anda berhasil login.',
                    timer: 1500,
                    showConfirmButton: false,
                    willClose: () => {
                        window.location.href = data.redirect || '{{ route('dashboard') ?? url('/') }}'; // Arahkan ke dashboard
                    }
                });
            })
            .catch(error => {
                submitBtn.disabled = false; // Aktifkan kembali tombol
                
                let errorMessage = 'Terjadi kesalahan tidak terduga.';
                
                if (error.status === 422 && error.errors) {
                    // Penanganan Validation Error
                    const errorList = Object.values(error.errors).flat();
                    errorMessage = errorList.join('<br>');
                    
                    // Hilangkan kelas error form bawaan jika ada (opsional)
                    form.querySelectorAll('input').forEach(input => input.classList.remove('border-red-600')); 
                } else if (error.message) {
                    // Penanganan Authentication Error dari server
                    errorMessage = error.message;
                }

                // ERROR ALERT
                Swal.fire({
                    icon: 'error',
                    title: 'Login Gagal!',
                    html: `<p class="text-lg font-semibold">${errorMessage}</p>`,
                    confirmButtonText: 'Coba Lagi',
                    confirmButtonColor: '#3b82f6',
                    customClass: {
                        popup: 'animated-popup'
                    }
                });
            });
        });
    </script>

    <style>
        .animated-popup {
            animation: shake 0.5s;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-10px); }
            20%, 40%, 60%, 80% { transform: translateX(10px); }
        }
    </style>
</body>
</html>