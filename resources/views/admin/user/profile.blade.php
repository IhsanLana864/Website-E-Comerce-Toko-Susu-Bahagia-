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
                <h3>Profil Admin</h3>
        
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <p><strong>Nama:</strong> {{ $user->name }}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>Nomor Telepon:</strong> {{ $user->no_telepon }}</p>

                <a href="{{ route('admin.profile.edit') }}" class="btn btn-primary">Edit Profil</a>
                <a href="{{ route('admin.profile.password') }}" class="btn btn-primary">Edit Password</a>
            </div>
        </div>
    </div>
@endsection
