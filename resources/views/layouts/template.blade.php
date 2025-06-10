<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Mazer Admin Dashboard') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('dist/assets/compiled/svg/favicon.svg') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('dist/assets/compiled/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/assets/compiled/css/app-dark.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <!-- DataTables CSS -->
    <link rel="stylesheet"
        href="{{ asset('dist/assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('dist/assets/css/pages/datatables.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-bootstrap-4/bootstrap-4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    @stack('css')
</head>

<body>
    <script src="{{ asset('dist/assets/static/js/initTheme.js') }}"></script>

    <div id="app">
        <!-- Sidebar -->
        @include('layouts.sidebar')

        <!-- Main Content -->
        <div id="main" class='layout-navbar navbar-fixed'>
            <!-- Navbar -->
            @include('layouts.header')

            {{-- breadcrumb dan main content --}}
            <div id="main-content">
                <div class="page-heading">
                    {{-- breadcrumb --}}
                    @include('layouts.breadcrumb')

                    {{-- main content --}}
                    <section class="section">
                        @yield('content')
                    </section>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- jQuery must be loaded first -->
    <script src="{{ asset('dist/assets/extensions/jquery/jquery.min.js') }}"></script>

    <!-- Bootstrap JS -->
    Harus 2 kali
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Bootstrap 5 -->
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Other scripts -->
    <script src="{{ asset('dist/assets/static/js/components/dark.js') }}"></script>
    <script src="{{ asset('dist/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('dist/assets/compiled/js/app.js') }}"></script>

    <!-- DataTables JS -->
    <script src="{{ asset('dist/assets/extensions/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('dist/assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>

    <!-- jQuery Validation -->
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/additional-methods.min.js"></script>
{{-- script badge status --}}
    <script>
        function renderStatusBadge(status) {
            let badgeClass = '';
            switch (status.toLowerCase()) {
                case 'menunggu':
                    badgeClass = 'badge bg-warning text-dark';
                    break;
                case 'diterima':
                    badgeClass = 'badge bg-primary text-white';
                    break;
                case 'diproses':
                    badgeClass = 'badge bg-info text-white';
                    break;
                case 'selesai':
                    badgeClass = 'badge bg-success';
                    break;
                case 'ditolak':
                    badgeClass = 'badge bg-danger';
                    break;
                default:
                    badgeClass = 'badge bg-secondary';
            }
            return `<span class="${badgeClass}">${status}</span>`;
        }

    </script>

    <!-- Correct CSRF Token Setup -->
    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });
    </script>

    @stack('js')
</body>

</html>