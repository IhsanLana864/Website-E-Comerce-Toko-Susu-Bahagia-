<!DOCTYPE html>
<html lang="en">
<head>
    <!-- set the encoding of your site -->
    <meta charset="utf-8" />
    <!-- set the compatibility of your site -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- responsive meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- page title -->
    <title>Toko Susu Bahagia - Ecommerce</title>
    <!-- include styles -->
    @include('include.style')
    {{-- @include('checkout.stylecheckout') --}}
</head>
<body>
    <div id="pageWrapper">
        <!-- pageHeader -->
        @include('include.navbar')
        <main>
            <section class="introBlock position-relative">
                <div class="slick-fade">
                    <div>
                        <div class="align w-100 d-flex align-items-center bgCover"
                            style="background-image: url('{{ asset('assets/images/Background1.png') }}')">
                            <div class="container position-relative holder pt-xl-10 pt-0">
                                <div class="row">
                                    <div class="col-12 pt-lg-23 pt-md-15 pt-sm-10 pt-6 text-center">
                                        <h1 class="headingIV fwEbold playfair mb-4">About Us</h1>
                                        <ul class="list-unstyled breadCrumbs d-flex justify-content-center">
                                            <li class="mr-2"><a href="{{ route('index') }}">Home</a></li>
                                            <li class="mr-2">/</li>
                                            <li class="active">About</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Include about content -->
            @include('checkout.tentang')
        </main>
        <!-- Back to top button -->
        <div id="toTop"></div>
    </div>
    <!-- Scripts -->
    <script src="js/common_scripts.min.js"></script>
    <script src="js/main.js"></script>
    @include('include.script')
</body>
@include('include.footer')
</html>
