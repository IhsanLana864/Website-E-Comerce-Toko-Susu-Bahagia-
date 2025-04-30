<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Toko Susu Bahagia - Ecommerce</title>
    @include('include.style')
    <meta charset="UTF-8">
    <title>Checkout Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Protest+Riot&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    @include('content.form')
    {{-- @include('checkout.stylecheckout') --}}
</head>
<body>
    <!-- Notifikasi -->
    <!-- @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif -->

    {{-- <div id="pageWrapper"> --}}
        @include('include.navbar')
        <div class="keranjang-header">
            <img src="{{ asset('assets/images/keranjang-icon.png') }}" alt="Keranjang">
            <h1>Lacak pesanan</h1>
            <div class="clouds"></div>
        </div>
            <div class="container">
                @include('checkout.lacakpesanan')

                @if(session('pesanan'))
                    @php $pesanan = session('pesanan'); @endphp
                    <div class="row justify-content-center">
                    <!-- Include about content -->
                        <!-- Detail Pesanan Kiri -->
                        <div class="col-md-6 form-container">
                            <div class="mb-3">
                                <label class="form-label">Nama :</label>
                                <input type="text" class="form-control" value="{{ $pesanan['nama'] }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">No Whatsapp :</label>
                                <input type="text" class="form-control" value="{{ $pesanan['no_telepon'] }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Alamat :</label>
                                <textarea class="form-control" readonly>{{ $pesanan['alamat'] }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label class="fw-bold">Detail Pesanan</label>
                                @foreach ($pesanan['detail_pesanan'] as $detail)
                                    <div class="order-item d-flex align-items-center">
                                        
                                        <div class="flex-grow-1">{{ $detail['barang']['nama'] }} ({{ $detail['jumlah'] }}Pcs)</div>
                                        <div>Rp{{ number_format($detail['harga'] * $detail['jumlah'], 0, ',', '.') }}</div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Detail Pesanan Kanan -->
                        <div class="col-md-4 form-container">
                            <div class="mb-3">
                                <label class="fw-bold">Pengiriman :</label><br>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" checked>
                                    <label class="form-check-label">{{ $pesanan['ekspedisi'] }}</label>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="fw-bold">Status Pembayaran :</label><br>
                                <span class="badge bg-success status-badge">Dibayar</span>
                            </div>

                            <div class="mb-3">
                                <label class="fw-bold">Status Pesanan :</label><br>
                                <span class="badge bg-primary status-badge">{{ $pesanan['status'] }}</span>
                            </div>

                            <div class="mb-3">
                                <label for="resi" class="form-label">No Resi :</label>
                                <input type="text" class="form-control" id="resi" value="{{ $pesanan['order_id'] }}" readonly>
                            </div>

                            <div class="order-summary">
                                <p class="mb-1">Sub Total: <span class="float-end" id="subTotal" data-subtotal="{{ $pesanan['total_harga'] }}">Rp{{ number_format($pesanan['total_harga'], 0, ',', '.') }}</span></p>
                                <p class="mb-1">Pengiriman: <span class="float-end" id="biayaEkspedisi"></span></p>
                                <hr>
                                <p class="fw-bold">TOTAL: <span class="float-end" id="grandTotal"></span></p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        <!-- Back to top button -->
        <div id="toTop"></div>
    </div>

    <!-- Scripts -->
    <script src="js/common_scripts.min.js"></script>
    <script src="js/main.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ekspedisiLabel = document.querySelector('.form-check-label');
            const biayaEkspedisiElem = document.getElementById('biayaEkspedisi');
            const grandTotalElem = document.getElementById('grandTotal');
            const subTotalElem = document.getElementById('subTotal');

            if (!ekspedisiLabel || !biayaEkspedisiElem || !grandTotalElem || !subTotalElem) return;

            const ekspedisi = ekspedisiLabel.textContent.trim().toLowerCase();
            const subTotal = parseInt(subTotalElem.getAttribute('data-subtotal')) || 0;

            // Cek apakah ekspedisi internal
            const biayaEkspedisi = ekspedisi === 'internal' ? 0 : 10000;

            // Tampilkan biaya ekspedisi
            biayaEkspedisiElem.textContent = 'Rp' + biayaEkspedisi.toLocaleString('id-ID');

            // Hitung grand total
            const grandTotal = subTotal + biayaEkspedisi;
            grandTotalElem.textContent = 'Rp' + grandTotal.toLocaleString('id-ID');
        });
    </script>
    @include('include.script')
</body>
    @include('include.blank')
</html>
