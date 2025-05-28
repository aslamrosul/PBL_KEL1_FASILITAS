@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h4 class="card-title">{{ $page->title }}</h4>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="row">
                <div class="col-md-4">
                    <div class="text-center">
                        <img src="{{ asset($user->profile_photo ? $user->profile_photo : 'dist/assets/compiled/jpg/1.jpg') }}" 
                             class="img-thumbnail rounded-circle" 
                             style="width: 200px; height: 200px; object-fit: cover;" 
                             alt="Profile Photo">
                        <h4 class="mt-3">{{ $user->nama }}</h4>
                        <p class="text-muted">{{ $user->level->level_nama }}</p>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h5>Informasi Profile</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-4 fw-bold">Username</div>
                                <div class="col-md-8">{{ $user->username }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4 fw-bold">Nama Lengkap</div>
                                <div class="col-md-8">{{ $user->nama }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4 fw-bold">Email</div>
                                <div class="col-md-8">{{ $user->email }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4 fw-bold">Level</div>
                                <div class="col-md-8">{{ $user->level->level_nama }}</div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <button onclick="modalAction('{{ route('profile.show_ajax') }}')" 
                                            class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i> Detail
                                    </button>
                                    <button onclick="modalAction('{{ route('profile.edit_ajax') }}')" 
                                            class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> Edit Profile
                                    </button>
                                    <button onclick="modalAction('{{ route('profile.edit_password_ajax') }}')" 
                                            class="btn btn-danger btn-sm">
                                        <i class="fas fa-key"></i> Ubah Password
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="myModal" class="modal fade" tabindex="-1" aria-hidden="true">
    </div>
@endsection

@push('js')
    <script>
       function modalAction(url = '') {
    console.log('Modal action called with URL:', url);
    $('#myModal').load(url, function() {
        console.log('Modal content loaded');
        var myModal = new bootstrap.Modal(document.getElementById('myModal'), {
            keyboard: false,
            backdrop: 'static'
        });
        myModal.show();
    }).fail(function(xhr, status, error) {
        console.error('Error loading modal content:', error);
    });
}
    </script>
@endpush