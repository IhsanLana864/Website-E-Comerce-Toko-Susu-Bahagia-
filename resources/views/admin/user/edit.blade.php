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
                <div class="card p-4" style="background-color: #eaf6ff; border-radius: 20px;">
                    <h3 class="fw-bold mb-4" style="color: #003366;">Edit Profil Admin</h3>

                    <div class="p-4" style="background-color: #fcdcdc; border-radius: 12px;">
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

                            <button type="submit" class="btn text-white px-4" style="background-color: #003366; border-radius: 8px;">
                                Simpan Perubahan
                            </button>
                            <a href="{{ route('admin.profile.index') }}" class="btn btn-secondary">Kembali</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
