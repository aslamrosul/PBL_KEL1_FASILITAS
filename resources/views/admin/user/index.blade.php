@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title">{{ $page->title }}</h4>
            <div class="card-tools">
                <button onclick="modalAction('{{ url('/user/import') }}')" class="btn btn-info">Import User</button>
                <a href="{{ url('/user/export_excel') }}" class="btn btn-primary"><i class="bi bi-file-excel"></i> Export
                    User</a>
                <a href="{{ url('/user/export_pdf') }}" class="btn btn-warning"><i class="bi bi-file-pdf"></i> Export
                    User</a>
                <button onclick="modalAction('{{ url('/user/create_ajax') }}')" class="btn btn-success">
                    Tambah Ajax
                </button>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Filter:</label>
                        <div class="col-3">
                            <select class="form-control" id="level_id" name="level_id" required>
                                <option value="">- Semua -</option>
                                @foreach($level as $item)
                                    <option value="{{ $item->level_id }}">{{ $item->level_nama }}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Level Pengguna</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover" id="table_user">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Nama</th>
                            <th>Level Pengguna</th>
                           <th>email</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <div id="myModal" class="modal fade" tabindex="-1" aria-hidden="true">
    </div>
@endsection

@push('css')
    <!-- Add any additional CSS here -->

@endpush

@push('js')
    <!-- Add DataTables and other JS dependencies -->

    <script>
        function modalAction(url = '') {
            $('#myModal').load(url, function () {
                var myModal = new bootstrap.Modal(document.getElementById('myModal'), {
                    keyboard: false,
                    backdrop: 'static'
                });
                myModal.show();
            });
        }



        var dataUser;
        $(document).ready(function () {
            window.dataUser = $('#table_user').DataTable({
                serverSide: true,
                ajax: {
                    url: "{{ url('user/list') }}",
                    type: "POST",
                    data: function (d) {
                        d.level_id = $('#level_id').val();
                    }
                },
                columns: [
                    { data: "DT_RowIndex", className: "text-center", orderable: false, searchable: false },
                    { data: "username", className: "", orderable: true, searchable: true },
                    { data: "nama", className: "", orderable: true, searchable: true },
                     { data: "email", className: "", orderable: true, searchable: true },
                    { data: "level.level_nama", className: "", orderable: false, searchable: false },
                    { data: "aksi", className: "", orderable: false, searchable: false }
                ]
            });

            $('#level_id').on('change', function () {
                dataUser.ajax.reload();
            });
        });


    </script>
@endpush