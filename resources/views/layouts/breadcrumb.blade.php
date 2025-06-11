@if(isset($breadcrumb) && isset($breadcrumb->list) && count($breadcrumb->list) > 0)
<div class="page-title">
    <div class="row mb-2">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h1>{{ $breadcrumb->title }}</h1>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                   @foreach($breadcrumb->list as $key => $value)
@if(isset($breadcrumb) && isset($breadcrumb->list) && count($breadcrumb->list) > 0)
<div class="page-title">
    <div class="row mb-2">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h1>{{ $breadcrumb->title }}</h1>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                   @foreach($breadcrumb->list as $key => $value)
                        @if($key == count($breadcrumb->list) - 1)
                            <li class="breadcrumb-item active">{{ $value }}</li>
                        @else
                            <li class="breadcrumb-item">{{ $value }}</li>
                        @endif
                    @endforeach
                </ol>
            </nav>
        </div>
    </div>
</div>
@endif
