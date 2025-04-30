@extends('admin.layouts.main')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3 col-lg-2 p-0">
            @include('admin.sidebar')
        </div>

        <div class="col-md-9 col-lg-10 p-4">
            <h3 class="fw-bold mb-4">Notifikasi</h3>

            @include('partials.admin.notifikasi-list')
        </div>
    </div>
</div>
@endsection
