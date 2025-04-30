@extends('admin.layouts.main')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 p-0">
                @include('admin.sidebar')
            </div>
            <!-- Main content -->
            <div class="col-md-9 col-lg-10 mt-4 ps-md-4">
                <h3>Ganti Password</h3>

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form method="POST" action="{{ route('admin.profile.password.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label>Password Saat Ini</label>
                        <input type="password" name="current_password" class="form-control" required>
                        @error('current_password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label>Password Baru</label>
                        <input type="password" name="new_password" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Konfirmasi Password Baru</label>
                        <input type="password" name="new_password_confirmation" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Update Password</button>
                    <a href="{{ route('admin.profile.index') }}" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
@endsection
