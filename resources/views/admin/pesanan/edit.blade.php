@extends('admin.layouts.main')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 col-lg-2 p-0">
                @include('admin.sidebar')
            </div>
            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 py-4 ps-md-4 ps-lg-5">
                <h2>Edit Pesanan</h2>
                <h5 class="fw-bold mb-4" style="color: #14213D;">{{ $pesanan->order_id }}</h5>
                <div class="row">
                    <form action="{{ route('admin.pesanan.update', $pesanan->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')
                        <!-- Kolom Kiri -->
                        <div class="col-md-8">
                            <!-- Data Pembeli -->
                            <div class="mb-3" style="background-color: #FFECEC; border-radius: 10px; padding: 20px;">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Nama :</label>
                                    <input type="text" class="form-control" value="{{ $pesanan->nama }}" readonly name="nama"
                                        style="border-radius: 6px;">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">No Whatsapp :</label>
                                    <input type="text" class="form-control" value="{{ $pesanan->no_telepon }}" readonly
                                        style="border-radius: 6px;">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Alamat :</label>
                                    <textarea class="form-control" style="border-radius: 6px;" rows="2" readonly>{{ $pesanan->alamat }}</textarea>
                                </div>

                                <!-- Detail Pesanan -->
                                <div class="mt-4">
                                    <h6 class="fw-bold mb-3">Detail Pesanan</h6>
                                    @foreach ($pesanan->detailPesanan as $detail)
                                        <div class="d-flex align-items-center justify-content-between mb-2 p-2"
                                            style="background-color: #D9EDFF; border-radius: 8px;">
                                            <div class="d-flex align-items-center">
                                                <img src="{{ asset('storage/' . $detail->barang->gambar) }}" alt="Produk" width="50"
                                                    class="me-3 rounded">
                                                <span class="fw-semibold">{{ $detail->barang->nama }}</span>
                                            </div>
                                            <span class="fw-semibold">Rp{{ number_format($detail->harga * $detail->jumlah, 0, ',', '.') }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Status Pesanan -->
                            <div class="mt-4 mb-3" style="background-color: #FFECEC; border-radius: 10px; padding: 20px;">
                                <h6 class="fw-bold mb-3">Status Pesanan</h6>
                                <div class="d-flex flex-wrap gap-2">
                                    <select class="form-select" name="status" required>
                                        <option disabled selected value="{{ $pesanan->status }}">{{ $pesanan->status }}</option>
                                        <option value="Pending">Pending</option>
                                        <option value="Diterima">Diterima</option>
                                        <option value="Ditolak">Ditolak</option>
                                        <option value="Dikemas">Dikemas</option>
                                        <option value="Dikirim">Dikirim</option>
                                    </select>
                                    <!-- @foreach (['Pending', 'Diterima', 'Ditolak', 'Dikemas', 'Dikirim', 'Selesai'] as $status)
                                        <button class="btn btn-outline-primary btn-sm"
                                            style="border-radius: 10px;">{{ $status }}</button>
                                    @endforeach -->
                                </div>
                            </div>

                            <!-- Tombol Simpan -->
                            <div class="text-start mt-3">
                                <button class="btn text-white px-4" type="submit"
                                    style="background-color: #14213D; border-radius: 6px;">Simpan</button>
                            </div>
                        </div>

                        <!-- Kolom Kanan -->
                        <div class="col-md-4">
                            <div class="mb-3" style="background-color: #FFECEC; border-radius: 10px; padding: 20px;">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Pengiriman :</label><br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="pengiriman" id="internal" checked
                                            value="internal">
                                            <label class="form-check-label" value="{{ $pesanan->ekspedisi }}">{{ $pesanan->ekspedisi }}</label>
                                        <!-- <label class="form-check-label" for="internal">Internal (Cikarang)</label> -->
                                    </div>
                                    <!-- <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="pengiriman" id="eksternal"
                                            value="eksternal">
                                        <label class="form-check-label" for="eksternal">External (Luar Cikarang)</label>
                                    </div> -->
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Ekspedisi :</label>
                                    <input type="text" class="form-control" value="{{ $pesanan->ekspedisi }}" readonly
                                        style="border-radius: 6px;">
                                </div>

                                <!-- <div class="mb-3">
                                    <label class="form-label fw-semibold">No Rekening Pembayaran :</label>
                                    <input type="text" class="form-control" placeholder="Masukkan no rekening"
                                        style="border-radius: 6px;">
                                </div> -->

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Bukti Pembayaran :</label>
                                    <div class="bg-white p-2 rounded">
                                        <img src="{{ asset('storage/' . $pesanan->bukti) }}" alt="Bukti Pembayaran" class="img-fluid"
                                            style="max-width: 100%; border-radius: 8px;">
                                    </div>
                                </div>

                                <!-- Ringkasan -->
                                <div class="mt-4">
                                    <h6 class="fw-bold mb-2">Ringkasan Pesanan</h6>
                                    <div class="d-flex justify-content-between">
                                        <span>Sub Total</span>
                                        <span id="subTotal" data-subtotal="{{ $pesanan->total_harga }}">Rp{{ number_format($pesanan->total_harga, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span>Pengiriman</span>
                                        <span id="biayaEkspedisi"></span>
                                    </div>
                                    <hr>
                                    <div class="d-flex justify-content-between fw-bold">
                                        <span>Total</span>
                                        <span id="grandTotal"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

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
@endsection