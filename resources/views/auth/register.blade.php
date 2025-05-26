<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Pengguna - Mazer Admin Dashboard</title>
    
    <link rel="shortcut icon" href="https://siakad.polinema.ac.id/favicon.jpg" type="image/x-icon">
   <link rel="stylesheet" href="{{ asset('dist/assets/compiled/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/assets/compiled/css/app-dark.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/assets/compiled/css/auth.css') }}">
    <style>
        .auth-logo img {
            height: 60px;
        }
        .brand-text {
            font-size: 2.25rem;
            font-weight: bold;
        }
        .brand-text span {
            color: rgb(41, 205, 255);
        }
        .auth-subtitle {
            font-size: 1rem;
            margin-bottom: 1.5rem !important;
        }
        .auth-title {
            font-size: 1.8rem;
            margin-bottom: 0.5rem;
        }
        .form-control {
            padding: 0.5rem 1rem;
        }
        .btn-block {
            display: block;
            width: 100%;
        }
        .error-text {
            display: block;
            width: 100%;
            margin-top: 0.25rem;
            font-size: 0.875em;
            color: #dc3545;
        }
    </style>
</head>

<body>
    <script src="{{ asset('dist/assets/static/js/initTheme.js') }}"></script>
    <div id="auth">
        <div class="row h-100 justify-content-center">
            <div class="col-lg-5 col-12">
                <div id="auth-left">
                    <div class="auth-logo mb-4">
                        <a href="#">
                            <span class="brand-text">SILATAS <span>POLINEMA</span></span>
                        </a>
                    </div>
                    <h1 class="auth-title">Register</h1>
                    <p class="auth-subtitle">Register akun baru</p>

                    <form id="registerForm">
                        @csrf
                        <!-- Pilihan Level -->
                        <div class="form-group position-relative has-icon-left mb-4">
                            <select name="level_id" class="form-control form-control-xl" required>
                                <option value="">-- Pilih Level --</option>
                                @foreach($levels as $level)
                                    <option value="{{ $level->level_id }}">{{ $level->level_nama }}</option>
                                @endforeach
                            </select>
                            <div class="form-control-icon">
                                <i class="bi bi-person-badge"></i>
                            </div>
                        </div>

                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" name="username" class="form-control form-control-xl" placeholder="Username" required>
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>
                        </div>

                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" name="nama" class="form-control form-control-xl" placeholder="Nama Lengkap" required>
                            <div class="form-control-icon">
                                <i class="bi bi-id-card"></i>
                            </div>
                        </div>

                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="email" name="email" class="form-control form-control-xl" placeholder="Alamat Email" required>
                            <div class="form-control-icon">
                                <i class="bi bi-envelope"></i>
                            </div>
                        </div>

                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="password" name="password" class="form-control form-control-xl" placeholder="Password" required>
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                        </div>

                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="password" name="password_confirmation" class="form-control form-control-xl" placeholder="Konfirmasi Password" required>
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                        </div>

                        <div class="form-check form-check-lg d-flex align-items-end mb-4">
                            <input class="form-check-input me-2" type="checkbox" id="agreeTerms" name="terms" value="agree">
                            <label class="form-check-label text-gray-600" for="agreeTerms">
                                Saya menyetujui <a href="#">syarat & ketentuan</a>
                            </label>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block btn-lg shadow-lg">Daftar</button>
                    </form>
                    <div class="text-center mt-4 text-lg fs-4">
                        <p class="text-gray-600">Saya sudah punya akun? <a href="{{ route('login') }}" class="font-bold">Login disini</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('dist/assets/static/js/components/dark.js') }}"></script>
    <script src="{{ asset('dist/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('dist/assets/compiled/js/app.js') }}"></script>
    
    <!-- Additional scripts -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    
    <script>
    document.getElementById("registerForm").addEventListener("submit", function(e) {
        e.preventDefault();

        let formData = new FormData(this);

        fetch("{{ route('register') }}", {
            method: "POST",
            body: formData,
            headers: {
                "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.status) {
                Swal.fire({
                    icon: 'success',
                    title: 'Registrasi Berhasil',
                    text: data.message,
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.href = data.redirect;
                });
            } else {
                // Jika validasi gagal, tampilkan semua error dari msgField
                let errorList = '';
                for (const field in data.msgField) {
                    if (data.msgField.hasOwnProperty(field)) {
                        errorList += `${data.msgField[field].join(', ')}\n`;
                    }
                }

                Swal.fire({
                    icon: 'error',
                    title: 'Registrasi Gagal',
                    text: errorList,
                });
            }
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Kesalahan Server',
                text: 'Terjadi kesalahan saat mengirim data. Silakan coba lagi.'
            });
            console.error('Error:', error);
        });
    });
</script>

</body>
</html>