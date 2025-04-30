@extends('admin.layouts.main')

@section('content')
    <style>
        .select2-results__options {
            max-height: 200px;
            overflow-y: auto;
        }
    </style>
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
                        <h5 class="fw-bold mb-4" style="color: #14213D;">Tambah Barang Keluar</h5>
                        <form action="{{ route('admin.keluar.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                            <div class="mb-3">
                                <label for="kategori" class="form-label fw-semibold">Barang :</label>
                                <select class="form-select select-barang" name="barang_id" style="border-radius: 6px;" required>
                                    
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Tanggal :</label>
                                <input type="date" class="form-control" name="tanggal" required
                                    style="border-radius: 6px;">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Jam :</label>
                                <input type="time" class="form-control" name="jam" required
                                    style="border-radius: 6px;">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Jumlah :</label>
                                <input type="number" class="form-control" name="jumlah" placeholder="Masukkan jumlah" required
                                    style="border-radius: 6px;">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Harga Satuan :</label>
                                <input type="number" class="form-control" name="harga_satuan" placeholder="Masukkan harga satuan" required
                                    style="border-radius: 6px;">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Penjual :</label>
                                <input type="text" class="form-control" name="penjual" placeholder="Masukkan nama penjual" required
                                    style="border-radius: 6px;">
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
    <!-- Script -->
    <script>
        $(document).ready(function() {
            $('.select-barang').select2({
                placeholder: 'Cari Barang...',
                allowClear: true,
                width: '100%',
                ajax: {
                    url: '{{ route("admin.search.barang") }}', // Ganti ke route pencarian barang-mu
                    dataType: 'json',
                    delay: 250, // tunda 250ms setelah ketik
                    data: function (params) {
                        return {
                            q: params.term // kirim teks yang diketik
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: data.map(function(barang) {
                                return {
                                    id: barang.id,
                                    text: barang.nama
                                }
                            })
                        };
                    },
                    cache: true
                },
                minimumInputLength: 1, // mulai search setelah 1 karakter diketik
            });
        });
    </script>
@endsection