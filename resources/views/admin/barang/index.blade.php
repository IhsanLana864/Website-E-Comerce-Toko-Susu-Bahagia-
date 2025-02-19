@extends('admin.layouts.main')

@section('content')
    <h1>Barang Admin yey</h1>
    <p>Selamat datang di panel admin Susu Bahagia.</p>
    <a href="{{ route('admin.barangs.create') }}" class="btn btn-secondary">Tambah</a>
    <table class="table table-striped mt-2">
        <tr>
            <th>Nama</th>
            <th>Kategori</th>
            <th>Gambar</th>
            <th>Satuan</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Action</th>
        </tr>
        @foreach ($barangs as $barang)
        <tr>
            <td>{{ $barang->nama }}</td>
            <td>{{ $barang->kategori->kategori }}</td>
            <td><img src="{{ asset('storage/' . $barang->gambar) }}" width="60"></td>
            <td>{{ $barang->satuan }}</td>
            <td>{{ $barang->harga }}</td>
            <td>{{ $barang->stok }}</td>
            <td>
                <a href="{{ route('admin.barangs.edit', $barang->id) }}" class="btn btn-warning">Edit</a>
                <form action="{{ route('admin.barangs.destroy', $barang->id) }}" method="POST" style="display:inline;">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Hapus barang ini?')">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
@endsection