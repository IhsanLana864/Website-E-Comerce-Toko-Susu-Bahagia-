<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Form</title>
    <!-- Notify -->
    @notifyCss
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    @include('content.style')
    @include('content.pembayaran')
</head>
<body>
<div class="keranjang-header">
<h1>Pesanan Saya</h1>
<div class="clouds"></div>
</div>
    <div class="container py-5">
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

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('checkout.cart') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row g-4">
            <!-- LEFT FORM -->
            <div class="col-md-6">
                <div class="form-container">
                    <div class="mb-3">
                        <label class="form-label">Nama :</label>
                        <input type="text" class="form-control" name="nama" placeholder="nama" required>
                    </div>
                    <!-- <div class="mb-3">
                        <label class="form-label">No Whatsapp :</label>
                        <input type="tel" class="form-control" name="no_telepon" placeholder="08xxxxxxxxxx" pattern="[0-9]" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')" minlength="10" maxlength="13" required>
                    </div> -->
                    <div class="mb-3">
                        <label class="form-label">No Whatsapp :</label>
                        <input type="number" class="form-control" name="no_telepon" placeholder="08xxxxxxxxxx" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat :</label>
                        <input list="alamatList" type="text" class="form-control" id="alamatInput" placeholder="Tulis alamat" required>
                        <datalist id="alamatList"></datalist>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Detail Alamat (Opsional) :</label>
                        <input type="text" class="form-control" placeholder="Detail alamat" id="alamatDetail">
                    </div>
                    <!-- hidden alamat -->
                    <div class="mb-3">
                        <input type="hidden" class="form-control" id="alamatFinal" name="alamat">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Pilih Lokasi di Peta</label>
                        <div id="map" style="height: 300px;"></div>
                        <input type="hidden" id="latitude" name="latitude">
                        <input type="hidden" id="longitude" name="longitude">
                    </div>
                    <h6 class="fw-bold">Detail Pesanan</h6>
                    @foreach ($cart as $id => $item)
                    <div class="order-item d-flex align-items-center">
                        <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}" class="me-3">
                        <div class="flex-grow-1">{{ $item['name'] }}</div>
                        <div>Rp<span id="total-{{ $id }}">{{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</span></div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- RIGHT FORM -->
            <div class="col-md-6">
                <div class="form-container">
                    <h6 class="fw-bold">Pengiriman :</h6>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="pengiriman" id="internal" value="internal" onclick="toggleInput()" checked>
                        <label class="form-check-label" for="internal">
                            Internal (Cikarang)
                        </label>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="radio" name="pengiriman" id="external" value="eksternal" onclick="toggleInput()">
                        <label class="form-check-label" for="external">
                            External (Luar Cikarang)
                        </label>
                    </div>
                    <div class="mb-3" id="extraInput" style="display: none;">
                        <label class="form-label">Ekspedisi :</label>
                        <select class="form-select" name="ekspedisi" id="ekspedisiSelect">
                            <option disabled selected value="">Pilih Ekspedisi</option>
                            <option value="JNE">JNE</option>
                            <option value="JNT">JNT</option>
                        </select>
                    </div>
                    <h6 class="fw-bold">No Rekening Pembayaran</h6>
                    <div class="summary-box mb-3">
                        <div class="d-flex justify-content-between">
                            <div>BCA</div>
                            <div>123456</div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <div>BRI</div>
                            <div>654321</div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Bukti Pembayaran</label>
                        <input type="file" class="form-control" name="bukti" required>
                    </div>
                    <h6 class="fw-bold">Ringkasan Pesanan</h6>
                    <div class="summary-box mb-3">
                        <div class="d-flex justify-content-between">
                            <div>Sub Total</div>
                            <div id="total-harga">Rp 0</div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <div>Pengiriman</div>
                            <div id="harga-kirim">Rp 0</div>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between fw-bold">
                            <div>TOTAL</div>
                            <div id="grand-total">Rp 0</div>
                            <input type="hidden" class="form-control" id="grand-total-hidden" name="total_harga">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Kirim</button>
                </div>
            </div>
        </div>
        </form>
    </div>
    <!-- SCRIPT -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        let typingTimer;
        const delay = 500; // 0.5 detik

        let map = L.map('map', {
            maxBounds: [
                [-11.0, 94.0], // batas bawah-kiri Indonesia
                [6.1, 141.0]   // batas atas-kanan Indonesia
            ],
            maxBoundsViscosity: 1.0,
            minZoom: 5,
            maxZoom: 18
        }).setView([-6.2834, 107.1641], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        let marker = L.marker([-6.2834, 107.1641], {draggable:true}).addTo(map);

        function reverseGeocode(lat, lon) {
            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}`)
            .then(response => response.json())
            .then(data => {
                if(data.address) {
                    const displayAddress = data.display_name;
                    document.getElementById('alamatInput').value = displayAddress; // Set value, bukan innerHTML
                    updateAlamatFinal(); // Update hidden input
                }
            });
        }

        document.getElementById('alamatInput').addEventListener('input', function () {
            clearTimeout(typingTimer);
            const query = this.value;

            if (query.length < 3) return;

            typingTimer = setTimeout(() => {
                fetch(`https://nominatim.openstreetmap.org/search?countrycodes=ID&format=json&q=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        const datalist = document.getElementById('alamatList');
                        datalist.innerHTML = '';

                        data.slice(0, 5).forEach(place => {
                            const option = document.createElement('option');
                            option.value = place.display_name;
                            datalist.appendChild(option);
                        });
                    });
            }, delay);
        });

        document.getElementById('alamatInput').addEventListener('change', function () {
            const selectedAddress = this.value;

            if (selectedAddress.length < 3) return;

            // Cari ulang koordinat berdasarkan alamat yang dipilih
            fetch(`https://nominatim.openstreetmap.org/search?countrycodes=ID&format=json&q=${encodeURIComponent(selectedAddress)}`)
                .then(response => response.json())
                .then(data => {
                    if (data && data.length > 0) {
                        const lat = data[0].lat;
                        const lon = data[0].lon;

                        // Pindahkan view ke lokasi yang dipilih
                        map.flyTo([lat, lon], 16);
                        marker.setLatLng([lat, lon]);

                        // Update input koordinat
                        document.getElementById('latitude').value = lat;
                        document.getElementById('longitude').value = lon;
                        reverseGeocode(lat,lon); //update address
                    }
                });
        });

        marker.on('dragend', function (e) {
            let lat = marker.getLatLng().lat;
            let lon = marker.getLatLng().lng;

            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lon;

            reverseGeocode(lat, lon);
        });

        // Internal Eksternal
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
                $("span[id^='total-']").each(function () {
                    let nilai = $(this).text().replace(/[^0-9]/g, '');
                    totalHarga += parseInt(nilai);
                });
                $("#total-harga").text("Rp " + totalHarga.toLocaleString("id-ID"));

                let pengiriman = $("input[name='pengiriman']:checked").val();
                let ongkir = (pengiriman === "eksternal") ? 10000 : 0;
                $("#harga-kirim").text("Rp " + ongkir.toLocaleString("id-ID"));

                let grandTotal = totalHarga + ongkir;
                $("#grand-total").text("Rp" + grandTotal.toLocaleString("id-ID"));

                $("#grand-total-hidden").val(grandTotal);
            }

            toggleInput();
            updateTotalHarga();

            $("input[name='pengiriman']").on('change', function () {
                toggleInput();
                updateTotalHarga();
            });

            //Alamat
            function updateAlamatFinal() {
                const alamatInput = $("#alamatInput").val();
                const alamatDetail = $("#alamatDetail").val();

                const gabungan = alamatDetail ? `${alamatDetail}, ${alamatInput}` : alamatInput;
                $("#alamatFinal").val(gabungan);
            }

            $("#alamatInput, #alamatDetail").on("input", function () {
                updateAlamatFinal();
            });

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function (position) {
                    const lat = position.coords.latitude;
                    const lon = position.coords.longitude;

                    map.setView([lat, lon], 15);
                    marker.setLatLng([lat, lon]);

                    document.getElementById('latitude').value = lat;
                    document.getElementById('longitude').value = lon;

                    reverseGeocode(lat, lon);
                }, function (error) {
                    console.warn("Geolocation error:", error.message);
                });
            }

            // Set nilai awal latlng
            document.getElementById('latitude').value = marker.getLatLng().lat;
            document.getElementById('longitude').value = marker.getLatLng().lng;
            reverseGeocode(marker.getLatLng().lat, marker.getLatLng().lng);
        });
    </script>
    <x-notify::notify />
    @notifyJs
</body>

</html>
