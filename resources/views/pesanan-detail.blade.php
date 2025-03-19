@extends('layouts.main')

@section('content')

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <h1>Ringkasan Pesanan</h1>
    <p>Terima kasih sudah berbelanja di toko kami.</p>
    
    <div class="container mt-5">
        <h2>Informasi Pesanan</h2>
        
        <div class="card mb-3">
            <div class="card-body">
                <p><strong>Order ID:</strong> {{ $pesanan->order_id }}</p>
                <p><strong>Nama:</strong> {{ $pesanan->nama }}</p>
                <p><strong>Alamat:</strong> {{ $pesanan->alamat }}</p>
                <p><strong>No. Telepon:</strong> {{ $pesanan->no_telepon }}</p>
                <p><strong>Total Harga:</strong> Rp{{ number_format($pesanan->total_harga, 0, ',', '.') }}</p>
                <p><strong>Status:</strong> {{ $pesanan->status }}</p>
                <p><strong>Ekspedisi:</strong> {{ $pesanan->ekspedisi }}</p>
            </div>
        </div>
        
        <h3>Detail Pesanan</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Nama Barang</th>
                    <th>Harga Satuan</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pesanan->detailPesanan as $detail)
                <tr>
                    <td>{{ $detail->barang->nama }}</td>
                    <td>Rp{{ number_format($detail->harga, 0, ',', '.') }}</td>
                    <td>{{ $detail->jumlah }}</td>
                    <td>Rp{{ number_format($detail->harga * $detail->jumlah, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <a class="btn btn-primary" href="{{ route('index') }}" role="button">Kembali Ke Halaman Utama</a>
    </div>
@endsection
