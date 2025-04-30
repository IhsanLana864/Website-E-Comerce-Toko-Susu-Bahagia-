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
                <h3>Edit Profil Admin</h3>

                <form action="{{ route('admin.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label">Nama</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Nomor Telepon</label>
                        <input type="text" name="no_telepon" class="form-control" value="{{ old('no_telepon', $user->no_telepon) }}" required>
                    </div>

                    <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                    <a href="{{ route('admin.profile.index') }}" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
@endsection
