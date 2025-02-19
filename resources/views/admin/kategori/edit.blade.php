@extends('admin.layouts.main')

@section('content')
<div class="container">
    <h1>Edit Barang</h1>
    <form action="{{ route('admin.kategoris.update', $kategori->id) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="mb-3">
            <label>Kategori</label>
            <input type="text" name="kategori" class="form-control" value="{{ $kategori->kategori }}" required>
        </div>
        
        <button type="submit" class="btn btn-success">Update</button>
    </form>
</div>
@endsection
