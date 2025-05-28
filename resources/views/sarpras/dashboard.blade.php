@extends ('layouts.template')

@section('content')
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