@extends('admin.layouts.main')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 p-0">
            @include('admin.sidebar')
        </div>

        <!-- Main content -->
        <div class="col-md-9 col-lg-10 p-4">
            <div class="card shadow rounded-4 border-0">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-4">
                        <div class="me-3">
                            <div class="bg-primary text-white rounded-circle d-flex justify-content-center align-items-center" style="width: 70px; height: 70px; font-size: 32px;">
                                <i class="bi bi-person-fill"></i>
                            </div>
                        </div>
                        <div>
                            <h4 class="mb-0">{{ $user->name }}</h4>
                            <small class="text-muted">Admin</small>
                        </div>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <hr>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email</label>
                        <div class="form-control-plaintext">{{ $user->email }}</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nomor Telepon</label>
                        <div class="form-control-plaintext">{{ $user->no_telepon }}</div>
                    </div>

                    <div class="mt-4 d-flex gap-2">
                        <a href="{{ route('admin.profile.edit') }}" class="btn btn-outline-primary rounded-3">
                            <i class="bi bi-pencil-square me-1"></i> Edit Profil
                        </a>
                        <a href="{{ route('admin.profile.password') }}" class="btn btn-outline-secondary rounded-3">
                            <i class="bi bi-key me-1"></i> Ganti Password
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
