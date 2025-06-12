<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Pengguna - Mazer Admin Dashboard</title>
    
    <link rel="shortcut icon" href="https://siakad.polinema.ac.id/favicon.jpg" type="image/x-icon">
     <link rel="shortcut icon" href="{{ secure_asset('dist/assets/compiled/svg/favicon.svg') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ secure_asset('dist/assets/compiled/css/app.css') }}">
    <link rel="stylesheet" href="{{ secure_asset('dist/assets/compiled/css/app-dark.css') }}">
        <link rel="stylesheet" href="{{ secure_asset('dist/assets/compiled/css/auth.css') }}">

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
    <script src="{{ secure_asset('dist/assets/static/js/initTheme.js') }}"></script>
    <div id="auth">
        <div class="row h-100 justify-content-center">
            <div class="col-lg-5 col-12">
                <div id="auth-left">
                    <div class="auth-logo mb-4">
                        <a href="#">
                            <span class="brand-text">FixIT <span>POLINEMA</span></span>
                        </a>
                    </div>
                    <h1 class="auth-title">Sign In</h1>
                    <p class="auth-subtitle">Sign in to start your session</p>

                    <form action="{{ secure_url('login') }}" method="POST" id="form-login">
                        @csrf
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" id="login" name="login" class="form-control form-control-xl" placeholder="Username or Email">
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>
                            <small id="error-login" class="error-text"></small>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="password" id="password" name="password" class="form-control form-control-xl" placeholder="Password">
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                            <small id="error-password" class="error-text"></small>
                        </div>
                        <div class="form-check form-check-lg d-flex align-items-end mb-4">
                            <input class="form-check-input me-2" type="checkbox" id="remember">
                            <label class="form-check-label text-gray-600" for="remember">
                                Remember Me
                            </label>
                        </div>
                        <button class="btn btn-primary btn-block btn-lg shadow-lg">Sign In</button>
                    </form>
                    <div class="text-center mt-4 text-lg fs-4">
                        <p class="text-gray-600">Belum punya akun? <a href="{{ route('register') }}" class="font-bold">Daftar disini</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
      <script src="{{ secure_asset('dist/assets/static/js/components/dark.js') }}"></script>
    <script src="{{ secure_asset('dist/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ secure_asset('dist/assets/compiled/js/app.js') }}"></script>
    
    <!-- Additional scripts for validation -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/additional-methods.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function () {
            $("#form-login").validate({
                rules: {
                    login: { required: true},
                    password: { required: true, minlength: 6, maxlength: 20 }
                },
                submitHandler: function (form) {
                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: $(form).serialize(),
                        success: function (response) {
                            if (response.status) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message,
                                }).then(function () {
                                    window.location = response.redirect;
                                });
                            } else {
                                $('.error-text').text('');
                                $.each(response.msgField, function (prefix, val) {
                                    $('#error-' + prefix).text(val[0]);
                                });
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Terjadi Kesalahan',
                                    text: response.message || 'Terjadi kesalahan pada server',
                                });
                            }
                        }
                    });
                    return false;
                },
                errorElement: 'span',
                errorPlacement: function (error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function (element) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function (element) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>
</body>
</html>