@extends('admin.layouts.main')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 p-0">
                @include('admin.sidebar')
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 p-4">
                <div class="card p-4" style="background-color: #EAF6FF; border-radius: 20px;">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3 class="fw-bold mb-0" style="color: #003366;">Barang Keluar</h3>
                        <a href="{{ route('admin.keluar.create') }}" class="btn text-white px-4"
                            style="background-color: #003366; border-radius: 8px;">Tambah</a>
                    </div>

                    <div class="table-responsive">
                        @if ($barangKeluar->isEmpty())
                            <div class="col-12 text-center">
                                <p class="text-muted">Barang Keluar Kosong</p>
                            </div>
                        @else
                            <table id="myTable" class="table align-middle text-center" style="border-collapse: separate; border-spacing: 0 10px;">
                                <thead style="background-color: #FFD6D6; color: #003366;" class="fw-bold">
                                    <tr>
                                        <th>No</th>
                                        <th>Barang</th>
                                        <th>Tanggal</th>
                                        <th>Jam</th>
                                        <th>Jumlah</th>
                                        <th>Harga Satuan</th>
                                        <th>Keuntungan</th>
                                        <th>Penjual</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($barangKeluar as $item)
                                        <tr style="background-color: #FFE5E5; border-radius: 12px;">
                                            <td>{{ $loop->iteration }}</td>
                                            <td class="d-flex align-items-center gap-3 ps-3 py-3">
                                                <img src="{{ asset('storage/' . $item->barang->gambar) }}" alt="Produk"
                                                    width="50" height="50" style="border-radius: 10px;">
                                                <div class="text-start fw-semibold">
                                                    {{ $item->barang->nama }}
                                                </div>
                                            </td>
                                            <td>{{ $item->tanggal }}</td>
                                            <td>{{ $item->jam }}</td>
                                            <td>{{ $item->jumlah }}</td>
                                            <td>Rp{{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                                            <td>Rp{{ number_format($item->keuntungan, 0, ',', '.') }}</td>
                                            <td>{{ $item->penjual }}</td>
                                            <td>
                                                <a href="{{ route('admin.keluar.edit', $item->id) }}" class="btn btn-sm text-white"
                                                    style="background-color: #003366; border-radius: 6px;">Edit</a>
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
