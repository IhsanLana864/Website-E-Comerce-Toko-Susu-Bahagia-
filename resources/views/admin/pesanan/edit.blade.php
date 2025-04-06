@extends('admin.layouts.main')

@section('content')
<div class="container">
    <h1>Edit Pesanan</h1>
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
            <label>Bukti</label><br>
            <img src="{{ asset('storage/' . $pesanan->bukti) }}" width="100">
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select class="form-select" name="status" required>
                <option disabled selected value="{{ $pesanan->status }}">{{ $pesanan->status }}</option>
                <option value="Pending">Pending</option>
                <option value="Diterima">Diterima</option>
                <option value="Ditolak">Ditolak</option>
                <option value="Dikemas">Dikemas</option>
                <option value="Dikirim">Dikirim</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Update</button>
    </form>
</div>
@endsection