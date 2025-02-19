@extends('admin.layouts.main')

@section('content')
<div class="container">
    <h1>Data Barang Masuk</h1>
    <p>Selamat datang di panel admin Susu Bahagia.</p>
    <a href="{{ route('admin.masuk.create') }}" class="btn btn-secondary">Tambah Barang Masuk</a>
    <table class="table table-striped mt-2">
        <tr>
            <th>No</th>
            <th>Nama Barang</th>
            <th>Tanggal</th>
            <th>Jam</th>
            <th>Jumlah</th>
            <th>Kedaluwarsa</th>
            <th>Harga Satuan</th>
            <th>Sumber</th>
            <th>Penerima</th>
        </tr>
        @foreach($barangMasuk as $item)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->barang->nama }}</td>
            <td>{{ $item->tanggal }}</td>
            <td>{{ $item->jam }}</td>
            <td>{{ $item->jumlah }}</td>
            <td>{{ $item->kedaluwarsa }}</td>
            <td>{{ $item->harga_satuan }}</td>
            <td>{{ $item->sumber }}</td>
            <td>{{ $item->penerima }}</td>
        </tr>
        @endforeach
    </table>
</div>
@endsection
