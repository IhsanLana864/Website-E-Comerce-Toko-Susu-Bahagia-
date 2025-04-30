@extends('admin.layouts.main')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 p-0">
                @include('admin.sidebar')
            </div>

            <!-- Main content -->
            <div class="col-md-9 col-lg-10 mt-4 ps-md-4">
                <div class="card p-4" style="background-color: #eaf6ff; border-radius: 20px;">
                    <h3 class="fw-bold mb-4" style="color: #003366;">Show Barang Masuk</h3>

                    <div class="p-4" style="background-color: #fcdcdc; border-radius: 12px;">
                        <div class="mb-3">
                            <label class="form-label">Barang :</label>
                            <input type="text" class="form-control" value="{{ $barang->nama }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tanggal :</label>
                            <input type="date" class="form-control" value="{{ $barangMasuk->tanggal }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Jam :</label>
                            <input type="time" class="form-control" value="{{ $barangMasuk->jam }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Jumlah :</label>
                            <input type="number" class="form-control" value="{{ $barangMasuk->jumlah }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kedaluwarsa :</label>
                            <input type="date" class="form-control" value="{{ $barangMasuk->kedaluwarsa }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Harga Satuan :</label>
                            <input type="text" class="form-control" value="Rp{{ number_format($barangMasuk->harga_satuan, 0, ',', '.') }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Sumber :</label>
                            <input type="text" class="form-control" value="{{ $barangMasuk->sumber }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Penerima :</label>
                            <input type="text" class="form-control" value="{{ $barangMasuk->penerima }}" readonly>
                        </div>

                        <div class="mb-3">
                            <a class="btn btn-primary" href="{{ route('admin.masuk.index') }}" role="button">Kembali</a>
                            <a href="{{ route('admin.masuk.edit', $barangMasuk->id) }}" class="btn btn-warning">Edit</a>   
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection