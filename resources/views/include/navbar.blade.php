<header id="header" class="pt-lg-5 pt-md-3 pt-2 position-absolute w-100">
    <div class="container-fluid px-xl-5 px-lg-4 px-md-3 px-2">
        <nav class="navbar navbar-expand-lg navbar-light p-0">
            {{-- Logo --}}
            <a class="navbar-brand" href="{{ route('index') }}">
                <img src="{{ asset('assets/images/logo new.png') }}" alt="Logo" class="img-fluid" style="height: 40px;">
            </a>

            {{-- Toggle button --}}
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            {{-- Navbar content --}}
            <div class="collapse navbar-collapse justify-content-between" id="navbarNavDropdown">
                {{-- Tengah --}}
                <ul class="navbar-nav mx-auto text-uppercase text-center" style="font-weight: 700 !important; letter-spacing: 0.5px !important;">

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('index') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('about') }}">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('tracking') }}">Tracking</a>
                    </li>
                </ul>

                {{-- Kanan (Search & Cart) --}}
                <ul class="navbar-nav d-flex align-items-center">
                    <li class="nav-item me-2">
                        <input type="text" id="navbarSearchInput" placeholder="Cari produk..."
                            style="border-radius: 10px; border: 1px solid #ccc; padding: 6px 10px;">
                    </li>
                    <li class="nav-item">
                        <a class="nav-link position-relative icon-cart" href="{{ route('cart') }}">
                            <i class="bi bi-cart-fill text-primary" style="color: #003366 !important;"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill text-white"
                                    style="background-color: #003366;">
                                {{ count(session('cart', [])) }}
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</header>
