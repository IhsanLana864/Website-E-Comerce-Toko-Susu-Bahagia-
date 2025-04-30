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
                <h3 class="fw-bold mb-4" style="color: #003366;">Pesanan</h3>

                <div class="table-responsive">
                    @if ($pesanans->isEmpty())
                        <div class="col-12 text-center">
                            <p class="text-muted">Pesanan Kosong</p>
                        </div>
                    @else
                        <table id="myTable" class="table align-middle text-center" style="border-collapse: separate; border-spacing: 0 10px;">
                            <thead>
                                <tr style="background-color: #FFE5E5; border-radius: 10px;">
                                    <th class="text-start ps-4">ID Pesanan</th>
                                    <th>Waktu</th>
                                    <th>Total Pembayaran</th>
                                    <th>Status Pesanan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $statuses = [
                                        'Pending' => 'bg-warning text-dark',
                                        'Diterima' => 'bg-success text-white',
                                        'Ditolak' => 'bg-danger text-white',
                                        'Dikemas' => 'bg-primary text-white',
                                        'Dikirim' => 'bg-info text-white',
                                        'Selesai' => 'bg-primary text-white'
                                    ];
                                @endphp

                                @foreach ($pesanans as $pesanan)
                                    @php
                                        $badgeClass = $statuses[$pesanan->status] ?? 'bg-secondary text-white';
                                    @endphp
                                        <tr style="background-color: #FFE5E5; border-radius: 10px;">
                                            <td class="text-start ps-4">
                                                <a href="{{ route('admin.pesanan.show', $pesanan->id) }}" class="text-decoration-none text-dark">
                                                    <i class="bi bi-file-earmark-text-fill me-2 text-primary"></i>
                                                    <strong>{{ $pesanan->nama }}</strong><br>
                                                    <span>{{ $pesanan->order_id }}</span>
                                                </a>
                                            </td>
                                            <td>{{ $pesanan->created_at->format('d-m-Y') }}<br>{{ $pesanan->created_at->format('H:i') }} WIB</td>
                                            <td>Rp{{ number_format($pesanan->total_harga, 0, ',', '.') }}</td>
                                            <td>
                                                <span class="badge {{ $badgeClass }}" style="font-size: 0.9rem; padding: 0.5em 1em; border-radius: 10px;">
                                                    {{ $pesanan->status }}
                                                </span>
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