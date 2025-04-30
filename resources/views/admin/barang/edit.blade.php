@extends('admin.layouts.main')

@section('content')
@if ($errors->any())
    <div class="alert alert-danger mb-3">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 p-0">
                @include('admin.sidebar')
            </div>
            <!-- Main content -->
            <div class="col-md-9 col-lg-10 mt-4 ps-md-4">
                <div class="card p-4" style="background-color: #eaf6ff; border-radius: 20px;">
                    <h3 class="fw-bold mb-4" style="color: #003366;">Edit Barang</h3>
                    <div class="p-4" style="background-color: #fcdcdc; border-radius: 12px;">
                        <form action="{{ route('admin.barangs.update', $barang->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf @method('PUT')
                            <div class="mb-3">
                                <label class="form-label">Nama :</label>
                                <input type="text" class="form-control" name="nama" value="{{ $barang->nama }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Kategori :</label>
                                <select class="form-select" name="kategori_id" required>
                                    @foreach ($kategoris as $kategori)
                                        <option value="{{ $kategori->id }}" {{ $barang->kategori_id == $kategori->id ? 'selected' : '' }}>
                                            {{ $kategori->kategori }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Harga :</label>
                                <input type="number" class="form-control" name="harga" value="{{ $barang->harga }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Satuan :</label>
                                <input type="text" class="form-control" name="satuan" value="{{ $barang->satuan }}" required>
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Gambar</label>
                                <input type="file" class="form-control" name="gambar" value="{{ asset('storage/' . $barang->gambar) }}">
                                <img src="{{ asset('storage/' . $barang->gambar) }}" width="100">
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn text-white px-4" style="background-color: #003366; border-radius: 8px;">
                                    Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            form.addEventListener('submit', function(e) {
                console.log('Form submitted');
                // Uncomment baris di bawah untuk melihat data yang dikirim
                console.log(new FormData(this));
            });
        });
    </script>
@endsection
