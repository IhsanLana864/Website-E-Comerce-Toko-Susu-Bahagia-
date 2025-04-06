@extends('admin.layouts.main')

@section('content')
<div class="container">
    <h2 class="mb-4">Laporan Penjualan</h2>

    <form method="GET" action="{{ route('laporan.index') }}" class="row g-3 mb-3">
        <div class="col-md-3">
            <label for="tanggal" class="form-label">Filter Tanggal</label>
            <input type="date" name="tanggal" class="form-control" value="{{ request('tanggal') }}">
        </div>
        <div class="col-md-3">
            <label for="bulan" class="form-label">Filter Bulan</label>
            <select name="bulan" class="form-select">
                <option value="">-- Pilih Bulan --</option>
                @foreach (range(1, 12) as $bln)
                <option value="{{ $bln }}" {{ request('bulan') == $bln ? 'selected' : '' }}>
                    {{ \Carbon\Carbon::create()->month($bln)->translatedFormat('F') }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3 d-flex align-items-end">
            <button class="btn btn-primary" type="submit">Filter</button>
        </div>
        <div class="col-md-3 d-flex align-items-end justify-content-end">
            <a href="{{ route('laporan.exportPDF', request()->query()) }}" class="btn btn-danger">Export PDF</a>
        </div>
    </form>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pelanggan</th>
                <th>Total</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($penjualans as $key => $penjualan)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $penjualan->nama }}</td>
                <td>Rp{{ number_format($penjualan->total_harga, 0, ',', '.') }}</td>
                <td>{{ $penjualan->created_at->format('d-m-Y') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center">Tidak ada data</td>
            </tr>
            @endforelse
            <tr>
                <td colspan="2" class="text-end fw-bold">Total</td>
                <td colspan="2" class="fw-bold">
                    Rp{{ number_format($penjualans->sum('total_harga'), 0, ',', '.') }}
                </td>
            </tr>
        </tbody>
    </table>
</div>
@endsection
