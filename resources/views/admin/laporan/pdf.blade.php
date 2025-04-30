<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Penjualan</title>
    <style>
        .headerLap{
            text-align: center;
        }
        .alamatLap{
            font-size: 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th{
            text-align: center;
        }
        .biruCell {
            border-top:1px solid #000;
            border-bottom:1px solid #000;
            background-color: #C9DAF8;
        }
        th, td {
            padding: 5px;
        }
    </style>
</head>
<body>
    <div class="headerLap">
        <img src="{{ public_path('assets/images/logo new.png') }}" style="height: 40px; display: block; margin: 0 auto;">
        <p class="alamatLap">Ruko E7 No: 22, Jl. Mutiara Bekasi Jaya, Sindangmulya, Kec. Cibarusah, Kabupaten Bekasi, Jawa Barat 17340</p>
        <hr>
        <h4>LAPORAN PENJUALAN</h4>
    </div>
    @if($tanggal_awal && $tanggal_akhir)
        <p><strong>Periode:</strong> {{ \Carbon\Carbon::parse($tanggal_awal)->format('d-m-Y') }} s/d {{ \Carbon\Carbon::parse($tanggal_akhir)->format('d-m-Y') }}</p>
    @else
        <p><strong>Periode:</strong> Semua Tanggal</p>
    @endif

    <table style="padding: 5px;">
        <thead class="biruCell">
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
            @foreach ($penjualans as $key => $penjualan)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $penjualan->barang->nama }}</td>
                <td>{{ $penjualan->tanggal }}</td>
                <td>{{ $penjualan->jam }}</td>
                <td>{{ $penjualan->penjual }}</td>
                <td>{{ $penjualan->jumlah }}</td>
                <td>Rp{{ number_format($penjualan->harga_satuan, 0, ',', '.') }}</td>
            </tr>
            @endforeach
            <tr class="biruCell">
                <td colspan="5" style="text-align: right; font-weight: bold;">Total</td>
                <td style="font-weight: bold;">
                    {{ $penjualans->sum('jumlah') }}
                </td>
                <td style="font-weight: bold;">
                    Rp{{ number_format($penjualans->sum('harga_satuan'), 0, ',', '.') }}
                </td>
            </tr>
        </tbody>
    </table>
    <p><strong>Dicetak pada:</strong> {{ \Carbon\Carbon::now()->format('d-m-Y H:i') }}</p>
</body>
</html>
