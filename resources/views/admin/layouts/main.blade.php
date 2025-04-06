<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Susu Bahagia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
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
        .navbar {
            position: fixed;
            top: 0;
            left: 250px;
            right: 0;
            z-index: 1030;
        }
        .dropdown-toggle::after {
            display: none;
        }
        .nav-link {
            cursor: pointer;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-light bg-light shadow-sm px-3">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">Admin Panel</span>
            <div>
                <a href="#" class="nav-link position-relative" data-bs-toggle="modal" data-bs-target="#notifModal">
                    <i class="bi bi-bell fs-4"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        {{ $jumlah_notif ?? 0 }}
                    </span>
                </a>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar">
        <h4 class="text-center"></h4>
        <ul class="nav flex-column">
            <li class="nav-item"><a class="nav-link" href="/admin">Dashboard</a></li>
            <li class="nav-item">
                <a class="nav-link dropdown-toggle" id="dataMasterDropdown" role="button" data-bs-toggle="dropdown">
                    Data Master
                </a>
                <ul class="dropdown-menu" aria-labelledby="dataMasterDropdown">
                    <li><a class="dropdown-item" href="{{ route('admin.kategoris.index') }}">Data Kategori</a></li>
                    <li><a class="dropdown-item" href="{{ route('admin.barangs.index') }}">Data Barang</a></li>
                    <li><a class="dropdown-item" href="{{ route('admin.masuk.index') }}">Barang Masuk</a></li>
                    <li><a class="dropdown-item" href="{{ route('admin.keluar.index') }}">Barang Keluar</a></li>
                </ul>
            </li>
            <li class="nav-item"><a class="nav-link" href="{{ route('laporan.index') }}">Laporan</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('admin.pesanan.index') }}">Pesanan</a></li>
        </ul>
    </div>

    <!-- Content -->
    <div class="content" style="margin-top: 56px;">
        @yield('content')
    </div>

    <!-- Modal Notifikasi -->
    <div class="modal fade" id="notifModal" tabindex="-1" aria-labelledby="notifModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="notifModalLabel">Notifikasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <ul class="list-group">
                        @forelse ($notifikasis as $notif)
                            @php
                                // Menentukan URL tujuan berdasarkan jenis notifikasi
                                $url = '#';
                                if (str_contains($notif->jenis, 'Pesanan')) {
                                    $url = route('admin.pesanan.show', $notif->pesanan_id);
                                } elseif (str_contains($notif->jenis, 'Kedaluwarsa')) {
                                    $url = route('admin.masuk.show', $notif->barang_masuk_id);
                                }
                            @endphp
                            <li class="list-group-item {{ $notif->dibaca ? '' : 'bg-light' }}">
                                <a href="#" class="notif-item text-decoration-none text-dark" data-id="{{ $notif->id }}" data-href="{{ $url }}">
                                    {{ $notif->pesan }}
                                </a>
                                <br>
                                <small class="text-muted">{{ $notif->created_at->diffForHumans() }}</small>
                            </li>
                        @empty
                            <li class="list-group-item text-muted">Tidak ada notifikasi</li>
                        @endforelse
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll(".modal-body .list-group-item a").forEach(item => {
                item.addEventListener("click", function (event) {
                    event.preventDefault(); // Mencegah navigasi langsung

                    let notifId = this.getAttribute("data-id");
                    let url = this.getAttribute("data-href");

                    if (notifId && url && url !== "#") {
                        fetch(`/notifikasi/${notifId}/read`, {
                            method: "POST",
                            headers: {
                                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                                "Content-Type": "application/json",
                            },
                            body: JSON.stringify({})
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                window.location.href = url; // Arahkan ke halaman tujuan
                            }
                        })
                        .catch(error => console.error("Error:", error));
                    }
                });
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
