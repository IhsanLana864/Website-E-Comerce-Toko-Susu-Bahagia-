@extends('admin.layouts.main')

@section('content')
<div class="container">
    <h1>Edit Barang</h1>
    <form action="{{ route('admin.barangs.update', $barang->id) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control" value="{{ $barang->nama }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Kategori</label>
            <select class="form-select" name="kategori_id" required>
                <option disabled selected value="{{ $barang->kategori->kategori }}">{{ $barang->kategori->kategori }}</option>
            @foreach ($kategoris as $kategori)
                <option value="{{ $kategori->id }}">{{ $kategori->kategori }}</option>
            @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Harga</label>
            <input type="number" name="harga" class="form-control" value="{{ $barang->harga }}" required>
        </div>
        <div class="mb-3">
            <label>Gambar</label>
            <input type="file" name="gambar" class="form-control">
            <img src="{{ asset('storage/' . $barang->gambar) }}" width="100">
        </div>
        <div class="mb-3">
            <label>Satuan</label>
            <input type="text" name="satuan" class="form-control" value="{{ $barang->satuan }}" required>
        </div>
        
        <button type="submit" class="btn btn-success">Update</button>
    </form>
</div>
@endsection
