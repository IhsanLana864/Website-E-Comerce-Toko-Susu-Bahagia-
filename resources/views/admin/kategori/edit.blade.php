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
                    <h3 class="fw-bold mb-4" style="color: #003366;">Edit Barang</h3>

                    <div class="p-4" style="background-color: #fcdcdc; border-radius: 12px;">
                        <form action="{{ route('admin.kategoris.update', $kategori->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf @method('PUT')
                            <div class="mb-3">
                                <label class="form-label">Kategori :</label>
                                <input type="text" class="form-control" name="kategori" value="{{ $kategori->kategori }}" required>
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
@endsection
