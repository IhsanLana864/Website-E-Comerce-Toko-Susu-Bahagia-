@extends('admin.layouts.main')

@section('content')
    <h1>Tambah Barang</h1>
    <hr>
    <form action="{{ route('admin.barangs.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
        <div class="mb-3">
            <label class="form-label">Nama</label>
            <input type="text" class="form-control" name="nama" placeholder="nama" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Kategori</label>
            <select class="form-select" name="kategori_id" required>
                <option disabled selected value="">Pilih Kategori</option>
            @foreach ($kategoris as $kategori)
                <option value="{{ $kategori->id }}">{{ $kategori->kategori }}</option>
            @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Harga</label>
            <input type="number" class="form-control" name="harga" placeholder="17000" required>
        </div>
        <div class="mb-3">
            <label class="form-label">gambar</label>
            <input type="file" class="form-control" name="gambar" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Satuan</label>
            <input type="text" class="form-control" name="satuan" placeholder="Kg" required>
        </div>
        
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection