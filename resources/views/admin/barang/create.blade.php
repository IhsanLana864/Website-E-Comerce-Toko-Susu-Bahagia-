@extends('admin.layouts.main')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-12 col-md-3 col-lg-2 p-0">
                @include('admin.sidebar')
            </div>

            <!-- Main content -->
            <div class="col-12 col-md-9 col-lg-10 py-4">
                <div class="d-flex justify-content-start">
                    <div class="card shadow-sm p-4"
                        style="background-color: #FFE3E3; border-radius: 12px; width: 100%; max-width: 1200px; margin-left: 16px;">
                        <h5 class="fw-bold mb-4" style="color: #14213D;">Tambah Barang</h5>
                        <form action="{{ route('admin.barangs.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Nama :</label>
                                <input type="text" class="form-control" name="nama" placeholder="Masukkan nama barang"
                                    style="border-radius: 6px;" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Kategori :</label>
                                <select class="form-select" name="kategori_id" style="border-radius: 6px;" required>
                                    <option disabled selected value="">Pilih Kategori</option>
                                    @foreach ($kategoris as $kategori)
                                        <option value="{{ $kategori->id }}">{{ $kategori->kategori }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Harga :</label>
                                <input type="number" class="form-control" name="harga" placeholder="Masukkan harga" required
                                    style="border-radius: 6px;">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Satuan :</label>
                                <input type="text" class="form-control" name="satuan" placeholder="Masukkan satuan" required
                                    style="border-radius: 6px;">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Gambar</label>
                                <div class="input-group">
                                    <input type="file" class="form-control" name="gambar" placeholder="Belum ada file dipilih" required
                                        style="border-radius: 6px;">
                                </div>
                            </div>

                            <div class="text-end mt-4">
                                <button type="submit" class="btn text-white px-4"
                                    style="background-color: #14213D; border-radius: 6px;">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection