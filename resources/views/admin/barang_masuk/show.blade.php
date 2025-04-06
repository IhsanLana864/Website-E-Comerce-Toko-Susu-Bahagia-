@extends('admin.layouts.main')

@section('content')
    <h1>Detail Barang Masuk</h1>
    <hr>
        <a href="{{ route('admin.masuk.edit', $barangMasuk->id) }}" class="btn btn-warning">Edit</a>
        <div class="mb-3">
            <label class="form-label">Barang</label>
            <input type="text" class="form-control" name="tanggal" value="{{ $barang->nama }}" readonly>
        </div>   
        <div class="mb-3">
            <label class="form-label">Tanggal</label>
            <input type="date" class="form-control" name="tanggal" value="{{ $barangMasuk->tanggal }}" readonly>
        </div>
        <div class="mb-3">
            <label class="form-label">Jam</label>
            <input type="time" class="form-control" name="jam" value="{{ $barangMasuk->jam }}" readonly>
        </div>
        <div class="mb-3">
            <label class="form-label">Jumlah</label>
            <input type="number" class="form-control" name="jumlah" value="{{ $barangMasuk->jumlah }}" readonly>
        </div>
        <div class="mb-3">
            <label class="form-label">Kedaluwarsa</label>
            <input type="date" class="form-control" name="kedaluwarsa" value="{{ $barangMasuk->kedaluwarsa }}" readonly>
        </div>
        <div class="mb-3">
            <label class="form-label">Harga Satuan</label>
            <input type="number" class="form-control" name="harga_satuan" value="{{ $barangMasuk->harga_satuan }}" readonly>
        </div>
        <div class="mb-3">
            <label class="form-label">Sumber</label>
            <input type="text" class="form-control" name="sumber" value="{{ $barangMasuk->sumber }}" readonly>
        </div>
        <div class="mb-3">
            <label class="form-label">Penerima</label>
            <input type="text" class="form-control" name="penerima" value="{{ $barangMasuk->penerima }}" readonly>
        </div>

        <a class="btn btn-primary" href="{{ route('admin.masuk.index') }}" role="button">Kembali</a>

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