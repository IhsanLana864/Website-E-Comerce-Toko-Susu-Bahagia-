@extends('layouts.main')

@section('content')

    <div class="container mt-5">
        <h2>Keranjang Belanja</h2>
        
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="row gap-2">
            <div class="col border p-2">
                <form action="{{ route('checkout.cart') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" class="form-control" name="nama" placeholder="nama" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Nomor Telepon</label>
                        <input type="number" class="form-control" name="no_telepon" placeholder="08xx" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Pengiriman</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="pengiriman" id="internal" value="internal" onclick="toggleInput()" checked>
                            <label class="form-check-label" for="internal">
                                Internal (Cikarang)
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="pengiriman" id="eksternal" value="eksternal" onclick="toggleInput()">
                            <label class="form-check-label" for="eksternal">
                                Eksternal (Luar Cikarang)
                            </label>
                        </div>
                    </div>

                    <!-- Input tambahan yang hanya muncul jika memilih "Internal (Cikarang)" -->
                    <div class="mb-3" id="extraInput" style="display: none;">
                        <label class="form-label">Ekspedisi</label>
                        <select class="form-select" name="ekspedisi" id="ekspedisiSelect">
                            <option disabled selected value="">Pilih Ekspedisi</option>
                            <option value="JNE">JNE</option>
                            <option value="JNT">JNT</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <input type="text" class="form-control" name="alamat" placeholder="Jalan xxx" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Bukti Pembayaran</label>
                        <input type="file" class="form-control" name="bukti" required>
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
    function toggleInput() {
        let pengiriman = document.querySelector('input[name="pengiriman"]:checked').value;
        let extraInput = document.getElementById('extraInput');
        let ekspedisiSelect = document.getElementById('ekspedisiSelect');

        if (pengiriman === "eksternal") {
            extraInput.style.display = "block";
            ekspedisiSelect.required = true;
        } else {
            extraInput.style.display = "none";
            ekspedisiSelect.required = false;
        }
    }

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
        toggleInput();
        updateTotalHarga();
    });
</script>
@endsection
