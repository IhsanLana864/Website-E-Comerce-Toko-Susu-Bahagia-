@extends('admin.layouts.main')

@section('content')
    <h1>Tambah Barang Keluar</h1>
    <hr>
    <form action="{{ route('admin.keluar.update', $barangKeluar->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
        <div class="mb-3">
            <label class="form-label">Barang</label>
            <select class="form-select" name="barang_id" required>
                @foreach ($barangs as $barang)
                    <option value="{{ $barang->id }}" {{ $barangKeluar->barang_id == $barang->id ? 'selected' : '' }}>
                        {{ $barang->nama }}
                    </option>
                @endforeach
            </select>
        </div>        
        <div class="mb-3">
            <label class="form-label">Tanggal</label>
            <input type="date" class="form-control" name="tanggal" value="{{ $barangKeluar->tanggal }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Jam</label>
            <input type="time" class="form-control" name="jam" value="{{ $barangKeluar->jam }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Jumlah</label>
            <input type="number" class="form-control" name="jumlah" value="{{ $barangKeluar->jumlah }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Harga Satuan</label>
            <input type="number" class="form-control" name="harga_satuan" value="{{ $barangKeluar->harga_satuan }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Penjual</label>
            <input type="text" class="form-control" name="penjual" value="{{ $barangKeluar->penjual }}" required>
        </div>        
        
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection