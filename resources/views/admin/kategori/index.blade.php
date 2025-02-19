@extends('admin.layouts.main')

@section('content')
    <h1>Kategori Admin yey</h1>
    <p>Selamat datang di panel admin Susu Bahagia.</p>
    <a href="{{ route('admin.kategoris.create') }}" class="btn btn-secondary">Tambah</a>
    <table class="table table-striped mt-2">
        <tr>
            <th>No</th>
            <th>Kategori</th>
            <th>Action</th>
        </tr>
        @foreach ($kategoris as $kategori)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $kategori->kategori }}</td>
            <td>
                <a href="{{ route('admin.kategoris.edit', $kategori->id) }}" class="btn btn-warning">Edit</a>
                <form action="{{ route('admin.kategoris.destroy', $kategori->id) }}" method="POST" style="display:inline;">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Hapus kategori ini?')">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
@endsection