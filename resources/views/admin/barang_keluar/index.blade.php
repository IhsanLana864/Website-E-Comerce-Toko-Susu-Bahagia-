@extends('admin.layouts.main')

@section('content')
<div class="container">
    <h1>Data Barang Keluar</h1>
    <p>Selamat datang di panel admin Susu Bahagia.</p>
    <a href="{{ route('admin.keluar.create') }}" class="btn btn-secondary">Tambah Barang Keluar</a>
    <table class="table table-striped mt-2">
        <tr>
            <th>No</th>
            <th>Nama Barang</th>
            <th>Tanggal</th>
            <th>Jam</th>
            <th>Jumlah</th>
            <th>Harga Satuan</th>
            <th>Penjual</th>
        </tr>
        @foreach($barangKeluar as $item)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->barang->nama }}</td>
            <td>{{ $item->tanggal }}</td>
            <td>{{ $item->jam }}</td>
            <td>{{ $item->jumlah }}</td>
            <td>{{ $item->harga_satuan }}</td>
            <td>{{ $item->penjual }}</td>
        </tr>
        @endforeach
    </table>
</div>
@endsection
