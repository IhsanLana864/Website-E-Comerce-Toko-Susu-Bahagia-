<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Penjualan</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border:1px solid #000;
            padding: 5px;
            text-align: left;
        }
        h2 {
            text-align: center;
        }
    </style>
</head>
<body>
    <h2>Laporan Penjualan</h2>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pelanggan</th>
                <th>Total</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($penjualans as $key => $penjualan)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $penjualan->nama }}</td>
                <td>Rp{{ number_format($penjualan->total_harga, 0, ',', '.') }}</td>
                <td>{{ $penjualan->created_at->format('d-m-Y') }}</td>
            </tr>
            @endforeach
            <tr>
                <td colspan="2" style="text-align: right; font-weight: bold;">Total</td>
                <td colspan="2" style="font-weight: bold;">
                    Rp{{ number_format($penjualans->sum('total_harga'), 0, ',', '.') }}
                </td>
            </tr>
        </tbody>
    </table>
</body>
</html>
