@extends('admin.layouts.main')

@section('content')
<div class="container">
    <h1>Edit Barang</h1>
    <form action="{{ route('admin.pesanan.update', $pesanan->id) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control" value="{{ $pesanan->nama }}" readonly>
        </div>

        <div class="mb-3">
            <label>Waktu</label>
            <input type="text" name="created_at" class="form-control" value="{{ $pesanan->created_at }}" readonly>
        </div>
        
        <div class="mb-3">
            <label>Total Pembayaran</label>
            <input type="text" name="total_harga" class="form-control" value="{{ $pesanan->total_harga }}" readonly>
        </div>

        <div class="mb-3">
            <label>Bukti</label>
            <input type="text" name="total_harga" class="form-control" value="{{ $pesanan->total_harga }}" readonly>
        </div>

        <div class="mb-3">
            <label>Status</label>
            <input type="text" name="total_harga" class="form-control" value="{{ $pesanan->status }}">
        </div>

        <button type="submit" class="btn btn-success">Update</button>
    </form>
</div>
@endsection