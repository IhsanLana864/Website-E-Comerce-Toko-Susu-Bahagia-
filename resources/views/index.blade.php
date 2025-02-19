@extends('layouts.main')

@section('content')
    <h1 class="text-center my-4">Selamat Datang di Susu Bahagia</h1>
    <p class="text-center">Silakan pilih menu di atas untuk menjelajahi toko kami.</p>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4 mb-4">
                <button type="button" class="btn btn-secondary filter-btn" data-kategori="all">Semua Produk</button>
            @php $kategoriUnik = $barangs->pluck('kategori.kategori')->unique(); @endphp
            @foreach ($kategoriUnik as $kategori)
                <button type="button" class="btn btn-secondary filter-btn" data-kategori="{{ $kategori }}">{{ $kategori }}</button>
            @endforeach
            </div>
        </div>
        <div id="produk-container" class="row justify-content-center">
        @foreach ($barangs as $barang)
            <div class="col-md-4 mb-4">
                <div class="card shadow-lg border-0 rounded">
                    <img src="{{ asset('storage/' . $barang->gambar) }}" class="card-img-top" alt="{{ $barang->nama }}" style="height: 200px;width: 100%;object-fit: contain;">
                    <div class="card-body text-center">
                        <h5 class="card-title">{{ $barang->nama }}</h5>
                        <p class="card-title">{{ $barang->satuan }}</p>
                        <p class="card-title">Rp{{ number_format($barang->harga, 0, ',', '.') }}</p>
                        <p class="card-title">{{ $barang->stok }}</p>
                        @if ($barang->stok > 0)
                            <a href="#" class="btn btn-primary add-to-cart" data-id="{{ $barang->id }}" data-stok="{{ $barang->stok }}">Beli Sekarang</a>
                        @else
                            <button class="btn btn-secondary" disabled>Stok Habis</button>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".filter-btn").click(function() {
                let kategori = $(this).data("kategori");

                $.ajax({
                    url: "{{ route('index') }}",  // Pastikan sesuai dengan route yang telah diperbaiki
                    type: "GET",
                    data: { kategori: kategori },
                    success: function(response) {
                        let html = "";
                        $.each(response, function(index, barang) {
                            html += `
                                <div class="col-md-4 mb-4 produk-item">
                                    <div class="card shadow-lg border-0 rounded">
                                        <img src="/storage/${barang.gambar}" class="card-img-top" alt="${barang.nama}" style="height: 200px;width: 100%;object-fit: contain;">
                                        <div class="card-body text-center">
                                            <h5 class="card-title">${barang.nama}</h5>
                                            <p class="card-title">${barang.satuan}</p>
                                            <p class="card-title">Rp${barang.harga.toLocaleString('id-ID')}</p>
                                            <p class="card-title">Stok: ${barang.stok}</p>
                                            <a href="#" class="btn btn-primary add-to-cart" data-id="{{ $barang->id }}" data-stok="{{ $barang->stok }}">Beli Sekarang</a>
                                        </div>
                                    </div>
                                </div>`;
                        });

                        if (response.length === 0) {
                            html = `<div class="col-12 text-center"><p class="text-muted">Produk tidak ditemukan.</p></div>`;
                        }

                        $("#produk-container").html(html);
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            });

            $(".add-to-cart").click(function(e) {
                e.preventDefault();
                let barangId = $(this).data("id");
                let stok = $(this).data("stok");

                if (stok <= 0) {
                    alert("Stok barang habis, tidak bisa ditambahkan ke keranjang!");
                    return;
                }

                $.ajax({
                    url: "{{ route('add.to.cart') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        barang_id: barangId
                    },
                    success: function(response) {
                        alert(response.success);
                        window.location.href = "{{ route('cart') }}";
                    },
                    error: function(xhr) {
                        alert(xhr.responseJSON.error);
                    }
                });
            });
        });
    </script>
@endsection