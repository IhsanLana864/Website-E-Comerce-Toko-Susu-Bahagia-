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
                        <form action="{{ route('admin.masuk.update', $barangMasuk->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf @method('PUT')
                            <div class="mb-3">
                                <label class="form-label">Barang :</label>
                                <select class="form-select select-barang" name="barang_id" required>
                                    <option value="{{ $barangMasuk->barang_id }}" selected>{{ $barangMasuk->barang->nama }}</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Tanggal :</label>
                                <input type="date" class="form-control" name="tanggal" value="{{ $barangMasuk->tanggal }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Jam :</label>
                                <input type="time" class="form-control" name="jam" value="{{ $barangMasuk->jam }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Jumlah :</label>
                                <input type="number" class="form-control" name="jumlah" value="{{ $barangMasuk->jumlah }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Kedaluwarsa :</label>
                                <input type="date" class="form-control" name="kedaluwarsa" value="{{ $barangMasuk->kedaluwarsa }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Harga Satuan :</label>
                                <input type="number" class="form-control" name="harga_satuan" value="{{ $barangMasuk->harga_satuan }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Sumber :</label>
                                <input type="text" class="form-control" name="sumber" value="{{ $barangMasuk->sumber }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Penerima :</label>
                                <input type="text" class="form-control" name="penerima" value="{{ $barangMasuk->penerima }}" required>
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