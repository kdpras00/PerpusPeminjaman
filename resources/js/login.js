/**
 * Login form handling with AJAX support
 */

// Constants
const ENTER_KEY = 'Enter';
const ENTER_KEY_CODE = 13;
const SWAL_CHECK_INTERVAL = 100;
const FOCUS_DELAY = 100;

/**
 * Toggle password visibility
 */
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.getElementById('eye-icon');
    const eyeSlashIcon = document.getElementById('eye-slash-icon');

    if (!passwordInput || !eyeIcon || !eyeSlashIcon) {
        return;
    }

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

/**
 * Ensure SweetAlert is loaded before executing callback
 */
function ensureSwal(callback) {
    if (typeof Swal !== 'undefined') {
        callback();
    } else {
        setTimeout(() => ensureSwal(callback), SWAL_CHECK_INTERVAL);
    }
}

/**
 * Show success message
 */
function showSuccessMessage(message) {
    ensureSwal(() => {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: message,
            timer: 2000,
            showConfirmButton: false
        });
    });
}

/**
 * Show error message
 */
function showErrorMessage(message) {
    ensureSwal(() => {
        Swal.fire({
            icon: 'error',
            title: 'Login Gagal!',
            html: `<p class="text-lg font-semibold">${message}</p>`,
            timer: 3000,
            showConfirmButton: false,
            toast: true,
            position: 'top-end'
        });
    });
}

/**
 * Unlock form after submission
 */
function unlockForm(loginForm, submitBtn) {
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

    const parentDiv = document.querySelector('.flex.flex-col.items-center.justify-center');
    if (parentDiv) {
        parentDiv.removeAttribute('aria-hidden');
    }

    const usernameInput = document.getElementById('username');
    if (usernameInput) {
        setTimeout(() => {
            usernameInput.focus();
            usernameInput.select();
        }, FOCUS_DELAY);
    }
}

/**
 * Handle login form submission
 */
function handleLogin(e, loginForm, submitBtn, isSubmitting) {
    if (e) {
        e.preventDefault();
        e.stopPropagation();
    }

    if (isSubmitting.value) {
        return false;
    }

    isSubmitting.value = true;
    if (submitBtn) {
        submitBtn.disabled = true;
    }

    const formData = new FormData(loginForm);
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || formData.get('_token');
    const loginRoute = loginForm.getAttribute('action') || window.location.href;

    ensureSwal(() => {
        Swal.fire({
            title: 'Memproses Login...',
            html: 'Mohon tunggu sebentar',
            allowOutsideClick: false,
            allowEscapeKey: false,
            focusConfirm: false,
            didOpen: () => {
                Swal.showLoading();
                if (loginForm) {
                    loginForm.setAttribute('data-disabled', 'true');
                }
            },
            didClose: () => {
                if (isSubmitting.value) {
                    unlockForm(loginForm, submitBtn);
                }
            }
        });

        fetch(loginRoute, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            credentials: 'same-origin'
        })
        .then(async response => {
            Swal.close();

            let data;
            try {
                const text = await response.text();
                data = text ? JSON.parse(text) : {};
            } catch (e) {
                data = { message: 'Terjadi kesalahan saat memproses response.' };
            }

            if (!response.ok) {
                let errorMessage = data.message || 'Username atau password salah!';

                if (response.status === 422 && data.errors) {
                    const errorList = Object.values(data.errors).flat();
                    errorMessage = errorList.join(', ');
                }

                window.location.href = `${window.location.pathname}?error=${encodeURIComponent(errorMessage)}`;
                return;
            }

            return Swal.fire({
                icon: 'success',
                title: 'Login Berhasil!',
                text: data.message || 'Anda berhasil login.',
                timer: 1500,
                showConfirmButton: false,
                focusConfirm: false,
                willClose: () => {
                    window.location.href = data.redirect || window.location.origin + '/dashboard';
                }
            });
        })
        .catch(error => {
            Swal.close();
            window.location.href = `${window.location.pathname}?error=${encodeURIComponent('Tidak dapat terhubung ke server. Silakan coba lagi.')}`;
        });
    });
}

/**
 * Initialize login form
 */
document.addEventListener('DOMContentLoaded', function() {
    // Initialize password toggle
    const togglePasswordBtn = document.getElementById('togglePasswordBtn');
    if (togglePasswordBtn) {
        togglePasswordBtn.addEventListener('click', togglePassword);
    }

    // Show session messages
    const successMessage = document.querySelector('[data-success-message]')?.dataset.successMessage;
    if (successMessage) {
        showSuccessMessage(successMessage);
    }

    const errorMessage = document.querySelector('[data-error-message]')?.dataset.errorMessage;
    if (errorMessage) {
        showErrorMessage(errorMessage);
    }

    // Handle URL error parameter
    const urlParams = new URLSearchParams(window.location.search);
    const errorParam = urlParams.get('error');
    if (errorParam) {
        showErrorMessage(decodeURIComponent(errorParam));
        window.history.replaceState({}, document.title, window.location.pathname);
    }

    // Initialize form handlers
    const loginForm = document.getElementById('loginForm');
    const submitBtn = document.getElementById('submitButton');
    const isSubmitting = { value: false };

    if (!loginForm || !submitBtn) {
        return;
    }

    // Form submission handler
    loginForm.addEventListener('submit', (e) => {
        handleLogin(e, loginForm, submitBtn, isSubmitting);
    });

    // Submit button click handler
    submitBtn.addEventListener('click', (e) => {
        handleLogin(e, loginForm, submitBtn, isSubmitting);
    });

    // Enter key handler for submit button
    submitBtn.addEventListener('keydown', function(e) {
        if (e.key === ENTER_KEY || e.keyCode === ENTER_KEY_CODE) {
            e.preventDefault();
            handleLogin(e, loginForm, submitBtn, isSubmitting);
        }
    });

    // Enter key handler for username field
    const usernameInput = document.getElementById('username');
    if (usernameInput) {
        usernameInput.addEventListener('keydown', function(e) {
            if (e.key === ENTER_KEY || e.keyCode === ENTER_KEY_CODE) {
                e.preventDefault();
                const passwordInput = document.getElementById('password');
                if (passwordInput) {
                    passwordInput.focus();
                }
            }
        });
    }

    // Enter key handler for password field
    const passwordInput = document.getElementById('password');
    if (passwordInput) {
        passwordInput.addEventListener('keydown', function(e) {
            if ((e.key === ENTER_KEY || e.keyCode === ENTER_KEY_CODE) && !isSubmitting.value) {
                e.preventDefault();
                handleLogin(e, loginForm, submitBtn, isSubmitting);
            }
        });
    }
});

