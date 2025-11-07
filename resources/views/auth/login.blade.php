<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                <form class="space-y-4 md:space-y-6" action="{{ route('login.post') }}" method="POST" id="loginForm" autocomplete="on" novalidate>
                    @csrf
                    <div>
                        <label for="username" class="block mb-2 text-sm font-medium text-gray-900">Username</label>
                        <input 
                            type="text" 
                            name="username" 
                            id="username" 
                            autocomplete="username" 
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5" 
                            placeholder="Masukkan username" 
                            required 
                            autofocus
                        >
                        @error('username')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Password</label>
                        <div class="relative">
                            <input 
                                type="password" 
                                name="password" 
                                id="password" 
                                autocomplete="current-password" 
                                placeholder="••••••••" 
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 pr-10" 
                                required
                            >
                            <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-600 hover:text-gray-900">
                                {{-- SVG Icons --}}
                                <svg id="eye-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                <svg id="eye-slash-icon" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.29 3.29m13.42 13.42l-3.29-3.29M3 3l18 18"></path>
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="button" id="submitButton" class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Login</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // DEFINE TOGGLE PASSWORD (Pastikan ada di sini atau di app.js, jika di app.js, hapus definisi di sini)
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            const eyeSlashIcon = document.getElementById('eye-slash-icon');

            if (passwordInput && eyeIcon && eyeSlashIcon) {
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    eyeIcon.classList.add('hidden');
                    eyeSlashIcon.classList.remove('hidden');
                } else {
                    passwordInput.type = 'password';
                    eyeIcon.classList.remove('hidden');
                    eyeSlashIcon.classList.add('hidden');
                }
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Fungsi helper untuk memastikan Swal tersedia
            function ensureSwal(callback) {
                if (typeof Swal !== 'undefined') {
                    callback();
                } else {
                    setTimeout(() => ensureSwal(callback), 100);
                }
            }

            // Cek Success Session (Misalnya dari Logout)
            @if (session('success'))
                ensureSwal(() => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: '{{ session('success') }}',
                        timer: 2000,
                        showConfirmButton: false
                    });
                });
            @endif

            // Cek Error Session (Jika ada error non-login yang dikirim via session)
            @if (session('error'))
                ensureSwal(() => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Login Gagal!',
                        html: '<p class="text-lg font-semibold">{{ session('error') }}</p>',
                        timer: 3000,
                        showConfirmButton: false,
                        toast: true,
                        position: 'top-end'
                    });
                });
            @endif

            // Cek Error dari URL parameter (dari redirect AJAX)
            const urlParams = new URLSearchParams(window.location.search);
            const errorParam = urlParams.get('error');
            if (errorParam) {
                ensureSwal(() => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Login Gagal!',
                        html: '<p class="text-lg font-semibold">' + decodeURIComponent(errorParam) + '</p>',
                        timer: 3000,
                        showConfirmButton: false,
                        toast: true,
                        position: 'top-end'
                    });
                });
                // Hapus parameter error dari URL
                window.history.replaceState({}, document.title, window.location.pathname);
            }

            // =========================================================================
            // LOGIKA AJAX LOGIN DENGAN RESET TOTAL
            // =========================================================================

            const loginForm = document.getElementById('loginForm');
            const submitBtn = document.getElementById('submitButton');
            let isSubmitting = false; // Flag untuk mencegah double submit

            function handleUnlockForm() {
                // UNLOCK SEMUA ELEMEN FORM
                isSubmitting = false;
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.removeAttribute('disabled');
                }
                if (loginForm) {
                    loginForm.removeAttribute('data-disabled');

                    loginForm.querySelectorAll('input').forEach(input => {
                        input.disabled = false;
                        input.removeAttribute('disabled');
                    });
                }
                
                // Hapus aria-hidden dari parent elements
                const parentDiv = document.querySelector('.flex.flex-col.items-center.justify-center');
                if (parentDiv) {
                    parentDiv.removeAttribute('aria-hidden');
                }
                
                // Fokuskan kembali ke input username
                const usernameInput = document.getElementById('username');
                if (usernameInput) {
                    setTimeout(() => {
                        usernameInput.focus();
                        usernameInput.select();
                    }, 100);
                }
            }

            function handleLogin(e) {
                if (e) {
                    e.preventDefault();
                    e.stopPropagation();
                }

                if (isSubmitting) {
                    return false;
                }
                
                isSubmitting = true;
                if (submitBtn) {
                    submitBtn.disabled = true;
                }

                const form = loginForm;
                const formData = new FormData(form);

                ensureSwal(() => {
                    // Tampilkan loading SweetAlert
                    Swal.fire({
                        title: 'Memproses Login...',
                        html: 'Mohon tunggu sebentar',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        focusConfirm: false,
                        didOpen: () => {
                            Swal.showLoading();
                            // Tambahkan atribut disabled ke form agar tombol Enter/input tidak berfungsi
                            if (form) {
                                form.setAttribute('data-disabled', 'true');
                            }
                        },
                        didClose: () => {
                            // Pastikan form di-unlock jika SweetAlert ditutup secara manual (misal error jaringan)
                            if (isSubmitting) {
                                handleUnlockForm();
                            }
                        }
                    });

                    fetch('{{ route('login.post') }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || formData.get('_token')
                        },
                        credentials: 'same-origin'
                    })
                    .then(async response => {
                        // Tutup SweetAlert loading segera
                        Swal.close(); 
                        
                        let data;
                        try {
                            const text = await response.text();
                            data = text ? JSON.parse(text) : {};
                        } catch (e) {
                            data = { message: 'Terjadi kesalahan saat memproses response.' };
                        }

                        if (!response.ok) {
                            // Gagal (Status 401 atau 422) - Redirect ke login dengan error message
                            let errorMessage = data.message || 'Username atau password salah!';
                            
                            if (response.status === 422 && data.errors) {
                                const errorList = Object.values(data.errors).flat();
                                errorMessage = errorList.join(', ');
                            }
                            
                            // Redirect ke halaman login dengan error message
                            window.location.href = '{{ route('login') }}?error=' + encodeURIComponent(errorMessage);
                            return;
                        }
                        
                        // SUCCESS (Status 200)
                        return Swal.fire({
                            icon: 'success',
                            title: 'Login Berhasil!',
                            text: data.message || 'Anda berhasil login.',
                            timer: 1500,
                            showConfirmButton: false,
                            focusConfirm: false,
                            willClose: () => {
                                window.location.href = data.redirect || '{{ route('dashboard') ?? url('/') }}';
                            }
                        });

                    })
                    .catch(error => {
                        // Penanganan Error Jaringan/Parse JSON yang ekstrim - Redirect ke login
                        Swal.close();
                        window.location.href = '{{ route('login') }}?error=' + encodeURIComponent('Tidak dapat terhubung ke server. Silakan coba lagi.');
                    });
                }); // End ensureSwal
            }

            // Handler agar submit form maupun klik button bisa trigger handleLogin
            if (loginForm) {
                // Handle submit event (Enter pada input terakhir akan submit form secara default)
                loginForm.addEventListener('submit', handleLogin);
            }
            
            if (submitBtn) {
                submitBtn.addEventListener('click', handleLogin);
                
                // Handle Enter key pada button (saat button difokus dengan Tab)
                submitBtn.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter' || e.keyCode === 13) {
                        e.preventDefault();
                        handleLogin(e);
                    }
                });
            }
            
            // Handle Enter key pada input username - prevent submit tapi biarkan focus pindah ke password
            const usernameInput = document.getElementById('username');
            if (usernameInput) {
                usernameInput.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter' || e.keyCode === 13) {
                        // Prevent form submit
                        e.preventDefault();
                        // Pindahkan focus ke password field
                        const passwordInput = document.getElementById('password');
                        if (passwordInput) {
                            passwordInput.focus();
                        }
                    }
                });
            }
            
            // Handle Enter key pada input password (field terakhir) untuk trigger login
            const passwordInput = document.getElementById('password');
            if (passwordInput) {
                passwordInput.addEventListener('keydown', function(e) {
                    if ((e.key === 'Enter' || e.keyCode === 13) && !isSubmitting) {
                        e.preventDefault();
                        handleLogin(e);
                    }
                });
            }
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

        /* Pastikan form bisa digunakan setelah error */
        #loginForm:not([data-disabled="true"]) {
            pointer-events: auto !important;
        }

        #loginForm input:not(:disabled),
        #loginForm button:not(:disabled) {
            pointer-events: auto !important;
            cursor: pointer !important;
        }
    </style>
</body>
</html>
