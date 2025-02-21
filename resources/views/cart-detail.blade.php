@extends('layouts.main')

@section('content')
    <div class="container mt-5">
        <h2>Keranjang Belanja</h2>
        <div class="row gap-2">
            <div class="col border p-2">
                <form action="" method="POST" enctype="multipart/form-data">
                @csrf
                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" class="form-control" name="nama" placeholder="nama" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Nomor Telepon</label>
                        <input type="number" class="form-control" name="harga" placeholder="17000" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <input type="text" class="form-control" name="satuan" placeholder="Kg" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Bukti Pembayaran</label>
                        <input type="file" class="form-control" name="gambar" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
            <div class="col border">
                NOMOR REKENING
            </div>
        </div>
        <div class="row border mt-2">
            <table class="table">
                <thead>
                    <tr>
                        <th>Gambar</th>
                        <th>Nama Barang</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cart as $id => $item)
                        <tr>
                            <td><img src="{{ asset('storage/' . $item['image']) }}" width="50" alt="{{ $item['name'] }}"></td>
                            <td>{{ $item['name'] }}</td>
                            <td>Rp{{ number_format($item['price'], 0, ',', '.') }}</td>
                            <td><span class="mx-2 quantity" id="quantity-{{ $id }}">{{ $item['quantity'] }}</span></td>
                            <td>Rp<span id="total-{{ $id }}">{{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</span></td>
                        </tr>
                    @endforeach
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>Total Harga</td>
                            <td id="total-harga"></td>
                        </tr>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            function updateTotalHarga() {
                let totalHarga = 0;
                $("tbody tr").each(function () {
                    let totalItem = $(this).find("span[id^='total-']").text().replace(/[^0-9]/g, '');
                    if (totalItem) {
                        totalHarga += parseInt(totalItem);
                    }
                });
                $("#total-harga").text("Rp" + totalHarga.toLocaleString("id-ID"));
            }
            
            updateTotalHarga();
        });
    </script>
@endsection
