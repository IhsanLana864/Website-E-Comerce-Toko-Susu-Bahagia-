<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Toko Susu Bahagia - Ecommerce</title>
    <!-- Notify -->
    @notifyCss
    @include('include.style')
    <style>
        html{
            scroll-behavior: smooth;
        }

        .active-filter {
            background-color: #7EBC5B !important; /* biru */
            color: white !important;
            border-color: #7EBC5B !important;
        }
    </style>
</head>
<body>
    <div id="pageWrapper">
        @include('include.navbar')
        <main>
            <section class="introBlock position-relative">
                <div class="slick-fade">
                    <div>
                        <div class="align w-100 d-flex align-items-center bgCover"
                            style="background-image: url('{{ asset('assets/images/Background1.png') }}')">
                            <!-- holder -->
                            <div class="container position-relative holder pt-xl-10 pt-0">
                                <!-- py-12 pt-lg-30 pb-lg-25 -->
                                <div class="row">
                                    <div class="col-12 col-xl-7">
                                        <div class="txtwrap pr-lg-10">
                                            <span
                                                class="title d-block text-uppercase fwEbold position-relative pl-2 mb-lg-5 mb-sm-3 mb-1">Selamat
                                                Datang di
                                            </span>
                                            <h2 class="fwEbold position-relative mb-xl-7 mb-lg-5">
                                                Website Toko Susu Bahagia
                                                <span class="text-break d-block"></span>
                                            </h2>
                                            <p class="mb-xl-15 mb-lg-10">
                                                Tumbuh Sehat dengan Susu Terbaik!Dukung pertumbuhan si
                                                kecil dan kesehatan keluarga dengan susu segar penuh
                                                nutrisi.
                                            </p>
                                            <a href="#tes1"
                                                class="btn btnTheme btnShop fwEbold text-white md-round py-2 px-3 py-md-3 px-md-4">Toko <i class="fas fa-arrow-right ml-2"></i></a>
                                        </div>
                                    </div>
                                    <div class="imgHolder">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- featureSec -->
            <section class="featureSec container-fluid overflow-hidden pt-xl-12 pt-lg-10 pt-md-80 pt-5 pb-xl-10 pb-lg-4 pb-md-2 px-xl-14 px-lg-7">
                <!-- mainHeader -->
                <header class="col-12 mainHeader mb-7 text-center">
                    <h1 class="headingIV playfair fwEblod mb-4" id="tes1">
                        Yukkk Mom, lengkapi kebutuhan harian si Kecil!
                    </h1>
                    <span class="d-flex justify-content-center headerBorder d-block mb-md-5 mb-3 ">
                        <img src="{{ asset('assets/images/lineborder.png') }}" alt="Header Border" class="img-fluid img-bdr" />
                    </span>
                    <p>
                        Toko Susu Bahagia menghadirkan susu segar berkualitas dan produk
                        bayi terbaik untuk mendukung kesehatan keluarga Anda.
                    </p>

                    <!-- Filter Kategori -->
                    <div class="row justify-content-center">
                        <div class="col-md-4 mb-4">
                            <button type="button" class="btn btn-secondary filter-btn" data-kategori="all">Semua Produk</button>
                            <!-- @php $kategoriUnik = $barangs->pluck('kategori.kategori')->unique(); @endphp -->
                            @foreach ($allKategori as $kategori)
                                <button type="button" class="btn btn-secondary filter-btn" data-kategori="{{ $kategori->kategori }}">{{ $kategori->kategori }}</button>
                            @endforeach
                        </div>
                    </div>
                </header>
                <!-- Produk Container -->
                <div id="produk-container" class="col-12 p-0 overflow-hidden d-flex flex-wrap">
                    @include('partials.barang-list')
                </div>
            </section>
        </main>
            @include('include.footer')
    </div>
    <!-- include jQuery library -->
    @include('include.script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Search
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('navbarSearchInput');
            const produkContainer = document.getElementById('produk-container');

            searchInput.addEventListener('keypress', function (e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    const keyword = this.value.trim();

                    if (keyword.length > 0) {
                        fetch(`/search?query=${encodeURIComponent(keyword)}`)
                            .then(response => response.json())
                            .then(data => {
                                renderSearchResult(data, keyword);
                                document.getElementById('tes1')?.scrollIntoView({ behavior: 'smooth' });
                            });
                    }
                }
            });

            // Render hasil pencarian produk
            function renderSearchResult(barangs, keyword) {
                let html = '';

                barangs.forEach(barang => {
                    let tombolBeli = barang.stok > 0
                        ? `<a href="#" class="add-to-cart icon-cart d-block" data-id="${barang.id}" data-stok="${barang.stok}"></a>`
                        : `<button class="icon-cart d-block" disabled></button>`;

                    html += `
                    <div class="featureCol px-3 mb-6">
                        <div class="border">
                            <div class="imgHolder position-relative w-100 overflow-hidden">
                                <img src="/storage/${barang.gambar}" alt="${barang.nama}" class="img-fluid w-100" />
                                <ul class="list-unstyled postHoverLinskList d-flex justify-content-center m-0">
                                    <li class="mr-2 overflow-hidden">${tombolBeli}</li>
                                    <li class="mr-2 overflow-hidden">
                                        <a href="javascript:void(0);" class="icon-eye d-block"></a>
                                    </li>
                                </ul>
                            </div>
                            <div class="text-center py-xl-5 py-sm-4 py-2 px-xl-2 px-1">
                                <span class="title d-block mb-2">${highlight(barang.nama, keyword)}</span>
                                <span class="price d-block fwEbold">Rp${parseInt(barang.harga).toLocaleString('id-ID')}</span>
                                <p class="card-title">${barang.satuan}</p>
                                <p class="card-title">Stok: ${barang.stok}</p>
                            </div>
                        </div>
                    </div>`;
                });

                if (barangs.length === 0) {
                    html = `<div class="col-12 text-center"><p class="text-muted">Produk tidak ditemukan.</p></div>`;
                }

                produkContainer.innerHTML = html;
            }

            function highlight(text, keyword) {
                const regex = new RegExp(`(${keyword})`, 'gi');
                return text.replace(regex, `<span class="fw-bold" style="color:#7EBC5B;">$1</span>`);
            }
        });

        // Filter Kategori
        $(document).ready(function() {
            $(".filter-btn").click(function() {
                $(".filter-btn").removeClass("active-filter"); // hilangkan aktif di semua tombol
                $(this).addClass("active-filter"); // kasih aktif di tombol yang diklik

                let kategori = $(this).data("kategori");
                fetchBarang(1, kategori);
            });

            $(".filter-btn").click(function() {
                let kategori = $(this).data("kategori");

                $.ajax({
                    url: "{{ route('index') }}",
                    type: "GET",
                    data: { kategori: kategori },
                    success: function(response) {
                        let html = "";
                        $.each(response, function(index, barang) {
                            let tombolBeli = barang.stok > 0
                                ? `<a href="#" class="add-to-cart icon-cart d-block" data-id="${barang.id}" data-stok="${barang.stok}"></a>`
                                : `<button class="icon-cart d-block" disabled></button>`;

                            html += `
                                <div class="featureCol px-3 mb-6">
                                    <div class="border">
                                        <div class="imgHolder position-relative w-100 overflow-hidden">
                                            <img src="/storage/${barang.gambar}" alt="${barang.nama}"
                                                class="img-fluid w-100" />

                                            <ul class="list-unstyled postHoverLinskList d-flex justify-content-center m-0">
                                                <li class="mr-2 overflow-hidden">${tombolBeli}</li>
                                                <li class="mr-2 overflow-hidden">
                                                    <a href="javascript:void(0);" class="icon-eye d-block"></a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="text-center py-xl-5 py-sm-4 py-2 px-xl-2 px-1">
                                            <span class="title d-block mb-2">${barang.nama}</span>
                                            <span class="price d-block fwEbold">Rp${barang.harga.toLocaleString('id-ID')}</span>
                                            <p class="card-title">${barang.satuan}</p>
                                            <p class="card-title">Stok: ${barang.stok}</p>

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

            $(document).on("click", ".add-to-cart", function(e) {
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

        // Pagination & Filter AJAX
        $(document).on("click", ".pagination a", function (e) {
            e.preventDefault();
            let page = $(this).attr("href").split("page=")[1];
            fetchBarang(page);
        });

        $(".filter-btn").click(function () {
            let kategori = $(this).data("kategori");
            fetchBarang(1, kategori);
        });

        function fetchBarang(page = 1, kategori = null, keyword = null) {
            let url = `/page?page=${page}`;

            if (kategori) url += `&kategori=${kategori}`;
            if (keyword) url += `&query=${keyword}`;

            $.ajax({
                url: url,
                type: 'GET',
                success: function (data) {
                    $("#produk-container").html(data);
                    document.getElementById('tes1')?.scrollIntoView({ behavior: 'smooth' });
                },
                error: function (xhr) {
                    console.log(xhr.responseText);
                }
            });
        }
    </script>
    <x-notify::notify />
    @notifyJs
</body>
</html>
