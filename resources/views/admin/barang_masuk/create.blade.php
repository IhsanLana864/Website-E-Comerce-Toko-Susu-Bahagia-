@extends('admin.layouts.main')

@section('content')
    <h1>Tambah Barang</h1>
    <hr>
    <form action="{{ route('admin.masuk.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
        <div class="mb-3">
            <label class="form-label">Barang</label>
            <select class="form-select" name="barang_id" required>
                <option disabled selected value="">Pilih Barang</option>
            @foreach ($barangs as $barang)
                <option value="{{ $barang->id }}">{{ $barang->nama }}</option>
            @endforeach
            </select>
        </div>        
        <div class="mb-3">
            <label class="form-label">Tanggal</label>
            <input type="date" class="form-control" name="tanggal" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Jam</label>
            <input type="time" class="form-control" name="jam" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Jumlah</label>
            <input type="number" class="form-control" name="jumlah" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Kedaluwarsa</label>
            <input type="date" class="form-control" name="kedaluwarsa" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Harga Satuan</label>
            <input type="number" class="form-control" name="harga_satuan" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Sumber</label>
            <input type="text" class="form-control" name="sumber" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Penerima</label>
            <input type="text" class="form-control" name="penerima" required>
        </div>
        
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
@endsection