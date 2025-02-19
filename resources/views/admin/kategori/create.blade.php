@extends('admin.layouts.main')

@section('content')
    <h1>Tambah Kategori</h1>
    <hr>
    <form action="{{ route('admin.kategoris.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
        <div class="mb-3">
            <label class="form-label">Kategori</label>
            <input type="text" class="form-control" name="kategori" placeholder="kategori" required>
        </div>
        
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection