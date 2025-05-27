@extends('layouts.main')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>{{ $breadcrumb->title }}</h3>
                <p class="text-subtitle text-muted">View and manage your profile information</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        @foreach($breadcrumb->list as $item)
                        <li class="breadcrumb-item">{{ $item }}</li>
                        @endforeach
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="avatar avatar-xl mb-3">
                            <img src="{{ $user->profile_photo ? asset('storage/profile/'.$user->profile_photo) : asset('assets/compiled/jpg/1.jpg') }}" 
                                 class="rounded-circle" alt="Profile Photo">
                        </div>
                        <h4>{{ $user->nama }}</h4>
                        <p class="text-muted">{{ $user->level->level_nama }}</p>
                        <button class="btn btn-primary btn-sm" id="changePhotoBtn">Change Photo</button>
                        <input type="file" id="profilePhotoInput" style="display: none;" accept="image/*">
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Profile Information</h4>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <h6>Full Name</h6>
                            </div>
                            <div class="col-md-8 text-muted">
                                <span id="nama">{{ $user->nama }}</span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <h6>Username</h6>
                            </div>
                            <div class="col-md-8 text-muted">
                                <span id="username">{{ $user->username }}</span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <h6>Email</h6>
                            </div>
                            <div class="col-md-8 text-muted">
                                <span id="email">{{ $user->email }}</span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <h6>Role</h6>
                            </div>
                            <div class="col-md-8 text-muted">
                                <span>{{ $user->level->level_nama }}</span>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('profile.edit') }}" class="btn btn-primary">Edit Profile</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Change profile photo
    $('#changePhotoBtn').click(function() {
        $('#profilePhotoInput').click();
    });

    $('#profilePhotoInput').change(function() {
        if (this.files && this.files[0]) {
            var formData = new FormData();
            formData.append('profile_photo', this.files[0]);
            formData.append('_token', '{{ csrf_token() }}');

            $.ajax({
                url: '{{ route("profile.update.photo") }}',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.success);
                        $('.avatar img').attr('src', response.photo_url);
                        $('.user-img img').attr('src', response.photo_url); // Update navbar photo
                    }
                },
                error: function(xhr) {
                    var error = xhr.responseJSON.error || 'Failed to update photo';
                    toastr.error(error);
                }
            });
        }
    });
});
</script>
@endpush