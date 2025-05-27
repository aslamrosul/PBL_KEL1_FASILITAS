@extends('layouts.main')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>{{ $breadcrumb->title }}</h3>
                <p class="text-subtitle text-muted">Update your profile information</p>
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
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form id="profileForm">
                            @csrf
                            <div class="row mb-3">
                                <label for="nama" class="col-sm-3 col-form-label">Full Name</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="nama" name="nama" value="{{ $user->nama }}">
                                    <div class="invalid-feedback" id="nama-error"></div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="username" class="col-sm-3 col-form-label">Username</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="username" name="username" value="{{ $user->username }}">
                                    <div class="invalid-feedback" id="username-error"></div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="email" class="col-sm-3 col-form-label">Email</label>
                                <div class="col-sm-9">
                                    <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}">
                                    <div class="invalid-feedback" id="email-error"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-9 offset-sm-3">
                                    <button type="submit" class="btn btn-primary me-2" id="saveBtn">Save Changes</button>
                                    <a href="{{ route('profile.index') }}" class="btn btn-light">Cancel</a>
                                </div>
                            </div>
                        </form>
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
    $('#profileForm').submit(function(e) {
        e.preventDefault();
        $('#saveBtn').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...');
        $('#saveBtn').attr('disabled', true);
        
        // Clear previous errors
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').text('');

        $.ajax({
            url: '{{ route("profile.update") }}',
            type: 'PUT',
            data: $(this).serialize(),
            success: function(response) {
                toastr.success(response.success);
                $('#saveBtn').html('Save Changes');
                $('#saveBtn').attr('disabled', false);
                
                // Update the profile page with new data
                setTimeout(function() {
                    window.location.href = '{{ route("profile.index") }}';
                }, 1000);
            },
            error: function(xhr) {
                $('#saveBtn').html('Save Changes');
                $('#saveBtn').attr('disabled', false);
                
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    for (var field in errors) {
                        $('#' + field).addClass('is-invalid');
                        $('#' + field + '-error').text(errors[field][0]);
                    }
                } else {
                    toastr.error('An error occurred. Please try again.');
                }
            }
        });
    });
});
</script>
@endpush