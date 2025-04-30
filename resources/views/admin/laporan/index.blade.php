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
                    <h3 class="fw-bold mb-4" style="color: #003366;">Laporan Penjualan</h3>
                    <p class="mb-3" style="font-weight: 500;">Silakan pilih rentang waktu untuk melihat laporan.</p>
                    <form method="GET" action="{{ route('admin.laporan.index') }}">
                        <div class="row g-3 mb-4 align-items-end">
                            <div class="col-md-5">
                                <label class="form-label fw-semibold">Dari Tanggal</label>
                                <input type="date" name="tanggal_awal" class="form-control" style="border-radius: 10px;" value="{{ request('tanggal_awal') }}">
                            </div>
                            <div class="col-md-5">
                                <label class="form-label fw-semibold">Sampai Tanggal</label>
                                <input type="date" name="tanggal_akhir" class="form-control" style="border-radius: 10px;" value="{{ request('tanggal_akhir') }}">
                            </div>
                            <div class="col-md-2">
                                <button class="btn text-white px-4" style="background-color: #003366; border-radius: 10px;">
                                    Filter
                                </button>
                            </div>
                        </div>
                    </form>
                    <a href="{{ route('admin.laporan.exportPDF', request()->only(['tanggal_awal', 'tanggal_akhir'])) }}" class="btn text-white px-4 mb-4" style="background-color: #003366; border-radius: 10px;">
                        Export PDF
                    </a>
                    <table id="myTable" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Barang</th>
                                <th>Tanggal</th>
                                <th>Jam</th>
                                <th>Penjual</th>
                                <th>Jumlah</th>
                                <th>Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($penjualans as $key => $penjualan)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $penjualan->barang->nama }}</td>
                                <td>{{ $penjualan->tanggal }}</td>
                                <td>{{ $penjualan->jam }}</td>
                                <td>{{ $penjualan->penjual }}</td>
                                <td>{{ $penjualan->jumlah }}</td>
                                <td>Rp{{ number_format($penjualan->harga_satuan, 0, ',', '.') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada data</td>
                            </tr>
                            @endforelse
                            <!-- <tr>
                                <td colspan="5" class="text-end fw-bold">Total</td>
                                <td class="fw-bold">
                                    {{ $penjualans->sum('jumlah') }}
                                </td>
                                <td class="fw-bold">
                                    Rp{{ number_format($penjualans->sum('harga_satuan'), 0, ',', '.') }}
                                </td>
                            </tr> -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready( function () {
            $('#myTable').DataTable( {
                searching: false,
                paging: true,
                responsive: true,
            } );
        } );
    </script>
@endsection
