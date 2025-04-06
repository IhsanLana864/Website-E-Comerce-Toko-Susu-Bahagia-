@extends('admin.layouts.main')

@section('content')
    <h1>Barang Admin yey</h1>
    <p>Selamat datang di panel admin Susu Bahagia.</p>
    <a href="" class="btn btn-secondary">Tambah</a>
    <table class="table table-striped mt-2">
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Waktu</th>
            <th>Total Pembayaran</th>
            <th>Bukti</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        @foreach ($pesanans as $pesanan)
        <tr>
            <td>{{ $pesanan->id }}</td>
            <td>{{ $pesanan->nama }}</td>
            <td>{{ $pesanan->created_at }}</td>
            <td>{{ $pesanan->total_harga }}</td>
            <td><img src="{{ asset('storage/' . $pesanan->bukti) }}" width="60"></td>
            <td>{{ $pesanan->status }}</td>

            <td>
                <a href="{{ route('admin.pesanan.show', $pesanan->id) }}" class="btn btn-primary">Show</a>
                <a href="{{ route('admin.pesanan.edit', $pesanan->id) }}" class="btn btn-warning">Edit</a>
            </td>
        </tr>
        @endforeach
    </table>
@endsection