<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Comic+Neue:wght@700&display=swap" rel="stylesheet">
    <title>Toko Susu Bahagia - Ecommerce</title>
    @include('include.style')
    <style>
        html {
            scroll-behavior: smooth;
        }

        .active-filter {
            background-color: #7EBC5B !important;
            /* biru */
            color: white !important;
            border-color: #7EBC5B !important;
        }

        body {
            font-family: 'Comic Neue', cursive;
            background: linear-gradient(to bottom, #ffe5ec, #ffffff);
            color: #1a1a1a;
        }

        .cloud-bg {
            background-image: url('/assets/clouds.svg');
            background-repeat: no-repeat;
            background-size: cover;
        }

        .title-shadow {
            text-shadow: 2px 2px #aaa;
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
                                            <h2 class="fwEbold position-relative mb-xl-7 mb-lg-5">
                                                Toko Susu Bahagia
                                                <span class="text-break d-block"></span>
                                            </h2>
                                            <p class="mb-xl-15 mb-lg-10">
                                                Tumbuh Sehat dengan Susu Terbaik!<br>Dukung pertumbuhan si kecil dan kesehatan
                    keluarga dengan susu segar penuh nutrisi.
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
            <section class="py-5">
                <div class="container text-center">
                    <h2 class="fw-bold text-primary mb-4 title-shadow">Tentang Toko Susu Bahagia</h2>
                    <div class="row justify-content-center align-items-center">
                        <div class="col-md-6">
                            <img src="{{ asset('assets/images/tokotsb.png') }}" alt="Foto Toko"
                                class="img-fluid rounded shadow">
                        </div>
                        <div class="col-md-6 text-start">
                            <p>Toko Susu Bahagia terletak di Cibarusah Mutiara Bekasi Jaya Blok F7/22, Sindang Mulya.
                                Toko ini telah berdiri sejak tahun 2017 dan menjadi pilihan utama bagi para orang tua
                                yang mencari perlengkapan bayi dengan kualitas terbaik.</p>
                            <p>Di Toko Susu Bahagia, tersedia berbagai kebutuhan bayi seperti susu formula, popok
                                (pampers), serta perlengkapan bayi lainnya yang membantu memenuhi kebutuhan si kecil
                                dengan nyaman dan praktis. Dengan pelayanan yang ramah dan harga yang terjangkau, Toko
                                Susu Bahagia selalu berkomitmen untuk memberikan yang terbaik bagi pelanggan.</p>
                            <p>Kunjungi kami dan temukan produk terbaik untuk buah hati Anda!</p>
                        </div>
                    </div>
                </div>
            </section>
    </body>

    @include('checkout.tentang')
    <!-- Scripts -->
    <script src="js/common_scripts.min.js"></script>
    <script src="js/main.js"></script>
    @include('include.script')
</body>
@include('include.footer')

</html>
