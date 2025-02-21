@extends('admin.layouts.main')

@section('content')
    <h1>Edit Barang Masuk</h1>
    <hr>
    <form action="{{ route('admin.masuk.update', $barangMasuk->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
        <div class="mb-3">
            <label class="form-label">Barang</label>
            <select class="form-select" name="barang_id" required>
                @foreach ($barangs as $barang)
                    <option value="{{ $barang->id }}" {{ $barangMasuk->barang_id == $barang->id ? 'selected' : '' }}>
                        {{ $barang->nama }}
                    </option>
                @endforeach
            </select>
        </div>   
        <div class="mb-3">
            <label class="form-label">Tanggal</label>
            <input type="date" class="form-control" name="tanggal" value="{{ $barangMasuk->tanggal }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Jam</label>
            <input type="time" class="form-control" name="jam" value="{{ $barangMasuk->jam }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Jumlah</label>
            <input type="number" class="form-control" name="jumlah" value="{{ $barangMasuk->jumlah }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Kedaluwarsa</label>
            <input type="date" class="form-control" name="kedaluwarsa" value="{{ $barangMasuk->kedaluwarsa }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Harga Satuan</label>
            <input type="number" class="form-control" name="harga_satuan" value="{{ $barangMasuk->harga_satuan }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Sumber</label>
            <input type="text" class="form-control" name="sumber" value="{{ $barangMasuk->sumber }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Penerima</label>
            <input type="text" class="form-control" name="penerima" value="{{ $barangMasuk->penerima }}" required>
        </div>
        
        <button type="submit" class="btn btn-primary">Update</button>
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