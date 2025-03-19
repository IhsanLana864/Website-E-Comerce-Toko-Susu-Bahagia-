<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Susu Bahagia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .sidebar {
            height: 100vh;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #f8f9fa;
            padding-top: 20px;
        }
        .content {
            margin-left: 260px;
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h4 class="text-center">Admin Panel</h4>
        <ul class="nav flex-column">
            <li class="nav-item"><a class="nav-link" href="/admin">Dashboard</a></li>
            <div class="dropdown">
                <li class="nav-item dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Data Master
                </li>
                <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{ route('admin.kategoris.index') }}">Data Kategori</a></li>
                    <li><a class="dropdown-item" href="{{ route('admin.barangs.index') }}">Data Barang</a></li>
                    <li><a class="dropdown-item" href="{{ route('admin.masuk.index') }}">Barang Masuk</a></li>
                    <li><a class="dropdown-item" href="{{ route('admin.keluar.index') }}">Barang Keluar</a></li>
                </ul>
            </div>
            <li class="nav-item"><a class="nav-link" href="#">Laporan</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('admin.pesanan.index') }}">Pesanan</a></li>
        </ul>
    </div>
    
    <div class="content">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>