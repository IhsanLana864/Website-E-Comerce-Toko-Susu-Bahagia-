@extends('admin.layouts.main')

@section('content')
    <h1>Tambah Barang Keluar</h1>
    <hr>
    <form action="{{ route('admin.keluar.store') }}" method="POST" enctype="multipart/form-data">
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
            <label class="form-label">Harga Satuan</label>
            <input type="number" class="form-control" name="harga_satuan" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Penjual</label>
            <input type="text" class="form-control" name="penjual" required>
        </div>        
        
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection