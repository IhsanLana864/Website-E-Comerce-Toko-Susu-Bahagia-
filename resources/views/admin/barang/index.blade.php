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
                <div class="card-pink">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3 class="fw-bold mb-0" style="color: #003366;">Barang</h3>
                        <a href="{{ route('admin.barangs.create') }}" class="btn text-white"
                            style="background-color: #003366; border-radius: 8px;">Tambah</a>
                    </div>

                    <div class="table-responsive">
                        @if ($barangs->isEmpty())
                            <div class="col-12 text-center">
                                <p class="text-muted">Barang Kosong</p>
                            </div>
                        @else
                            <table id="myTable" class="table table-borderless table-barang">
                                <thead class="text-center fw-bold">
                                    <tr>
                                        <th>Nama</th>
                                        <th>Kategori</th>
                                        <th>Harga</th>
                                        <th>Satuan</th>
                                        <th>Stok</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="align-middle text-center">
                                    @foreach ($barangs as $barang)
                                        <tr>
                                            <td class="d-flex align-items-center gap-3 ps-4 py-3">
                                                <img src="{{ asset('storage/' . $barang->gambar) }}" alt="Produk"
                                                    width="50" height="50" style="border-radius: 10px;">
                                                    {{ $barang->nama }}
                                            </td>
                                            <td>{{ $barang->kategori->kategori }}</td>
                                            <td>Rp{{ number_format($barang->harga, 0, ',', '.') }}</td>
                                            <td>{{ $barang->satuan }}</td>
                                            <td>{{ $barang->stok }}</td>
                                            <td>
                                                <div class="d-flex justify-content-center gap-2">
                                                    <a href="{{ route('admin.barangs.edit', $barang->id) }}" class="btn btn-sm btn-edit">Edit</a>
                                                    <!-- <a href="#" class="btn btn-sm btn-hapus">Hapus</a> -->
                                                    <form action="{{ route('admin.barangs.destroy', $barang->id) }}" method="POST" style="display:inline;">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Hapus barang ini?')">Hapus</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready( function () {
            $('#myTable').DataTable( {
                paging: true,
                searching: true,
                ordering: true,
                responsive: true,
            } );
        } );
    </script>
@endsection