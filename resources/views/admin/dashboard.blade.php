@extends('admin.layouts.main')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 p-0">
            @include('admin.sidebar')
        </div>

        <!-- Main content -->
        <div class="col-md-9 col-lg-10 p-4">
            <h3 class="fw-bold mb-4">Dashboard</h3>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 mb-5">
                <!-- Barang Paling Laku -->
                <div class="col">
                    <div class="card border-primary shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title fw-bold">Barang Paling Laku</h5>
                            @foreach ($topBarangKeluar as $item)
                                <p class="card-text fs-">{{ $item->barang->nama }} - {{ $item->total_keluar }} kali</p>
                            @endforeach
                        </div>
                    </div>
                </div>
                <!-- Barang Stok Kurang -->
                <div class="col">
                    <div class="card border-success shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title fw-bold">Barang dengan stok kurang dari 10</h5>
                            @if ($stokHampirHabis->isEmpty())
                                <p>Tidak ada barang dengan stok rendah.</p>
                            @else
                                @foreach ($stokHampirHabis as $barang)
                                    <p class="card-text fs-6">{{ $barang->nama }} - stok: {{ $barang->stok }}</p>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                <!-- Barang Kedaluwarsa -->
                <div class="col">
                    <div class="card border-danger shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title fw-bold">Barang yang mau kedaluwarsa</h5>
                            @if ($barangKadaluarsa->isEmpty())
                                <p>Tidak ada barang yang kadaluarsa bulan ini.</p>
                            @else
                                @foreach ($barangKadaluarsa as $barang)
                                    <p class="card-text fs-6">{{ $barang->nama_barang }} - {{ \Carbon\Carbon::parse($barang->kedaluwarsa)->format('d M Y') }} - Stok Sisa: {{ $barang->stok_sisa }}</p>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="container mt-4">
                {{-- Filter Waktu --}}
                <form method="GET" action="{{ route('admin.dashboard') }}" class="row align-items-end g-3 mb-4">
                    <div class="col-md-4">
                        <label for="filter" class="form-label">Filter Waktu</label>
                        <select class="form-select" name="filter" id="filter">
                            <option value="today" {{ request('filter') == 'today' ? 'selected' : '' }}>Hari Ini</option>
                            <option value="month" {{ request('filter') == 'month' ? 'selected' : '' }}>Bulan Ini</option>
                            <option value="all" {{ request('filter') == 'all' ? 'selected' : '' }}>Semua Waktu</option>
                            <option value="custom" {{ request('filter') == 'custom' ? 'selected' : '' }}>Pilih Bulan</option>
                        </select>
                    </div>
                    <div class="col-md-4" id="bulanInput" style="display: {{ request('filter') == 'custom' ? 'block' : 'none' }}">
                        <label for="waktu" class="form-label">Pilih Bulan</label>
                        <input type="month" name="waktu" id="waktu" class="form-control"
                            value="{{ request('waktu', \Carbon\Carbon::now()->format('Y-m')) }}">
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-primary">Terapkan</button>
                    </div>
                </form>

                {{-- Statistik Kartu --}}
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 mb-5">
                    <div class="col">
                        <div class="card border-primary shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">Jumlah Pesanan {{ $labelWaktu }}</h5>
                                <p class="card-text fs-4 fw-bold">{{ $jumlahPesanan }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card border-success shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">Jumlah Barang Masuk {{ $labelWaktu }}</h5>
                                <p class="card-text fs-4 fw-bold">{{ $jumlahBarangMasuk }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card border-danger shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">Jumlah Barang Keluar {{ $labelWaktu }}</h5>
                                <p class="card-text fs-4 fw-bold">{{ $jumlahBarangKeluar }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card border-warning shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">Keuntungan Hari Ini {{ $labelWaktu }}</h5>
                                <p class="card-text fs-5 fw-bold text-success">Rp{{ number_format($jumlahKeuntungan, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Charts --}}
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="card shadow">
                            <div class="card-header bg-primary text-white">Line Chart: Jumlah Pesanan {{ $labelWaktu }}</div>
                            <div class="card-body">
                                <canvas id="pesananChart"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="card shadow">
                            <div class="card-header bg-success text-white">Line Chart: Keuntungan {{ $labelWaktu }}</div>
                            <div class="card-body">
                                <canvas id="keuntunganChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- <div class="card-custom mb-4">
                <h5>Statistik Penjualan</h5>
                <p>22/04/2023</p>
                <div class="row">
                    <div class="col-md-3">
                        <div class="bg-white p-3 rounded mb-3 text-center shadow-sm">
                            <div class="fs-4 fw-bold">400.000</div>
                            <div>Total Keuntungan</div>
                        </div>
                        <div class="bg-white p-3 rounded text-center shadow-sm">
                            <div class="fs-4 fw-bold">30</div>
                            <div>Barang Terjual</div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <canvas id="salesChart" height="120"></canvas>
                    </div>
                </div>
            </div> -->

            <div class="row">
                <!-- <div class="col-md-6">
                    <div class="card-custom">
                        <h5>Best Seller!</h5>
                        <ol class="ps-3">
                            <li>Pampers M (68 Pcs)</li>
                            <li>Pampers M (68 Pcs)</li>
                            <li>Pampers M (68 Pcs)</li>
                        </ol>
                    </div>
                </div> -->

                <!-- <div class="col-md-6">
                    <div class="card-custom">
                        <h5>Stok Terbanyak!</h5>
                        <ol class="ps-3">
                            <li>Pampers M (68 Pcs)</li>
                            <li>Pampers M (68 Pcs)</li>
                            <li>Pampers M (68 Pcs)</li>
                        </ol>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/date-fns"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns"></script>
    <script>
        // Filter
        function toggleBulanInput() {
            const filter = document.getElementById('filter').value;
            const bulanInput = document.getElementById('bulanInput');
            bulanInput.style.display = (filter === 'custom') ? 'block' : 'none';
        }

        document.addEventListener('DOMContentLoaded', function () {
            toggleBulanInput();
            document.getElementById('filter').addEventListener('change', toggleBulanInput);
        });

        // Chart Format
        const numberFormatter = new Intl.NumberFormat('id-ID');
        const labelFormatter = (value, context) => {
            const isBulan = "{{ $filter }}" === "all";
            if (isBulan) {
                // Format label: "2024-03" → "Mar 2024"
                const [year, month] = value.split("-");
                return new Date(year, month - 1).toLocaleString('id-ID', { month: 'short', year: 'numeric' });
            } else {
                // Format label: "2024-03-15" → "15 Mar"
                return new Date(value).toLocaleDateString('id-ID', { day: '2-digit', month: 'short' });
            }
        };
        // Line Chart Pesanan
        const pesananChart = new Chart(document.getElementById('pesananChart'), {
            type: 'line',
            data: {
                labels: {!! json_encode($pesananChart->pluck('label')) !!},
                datasets: [{
                    label: 'Jumlah Pesanan',
                    data: {!! json_encode($pesananChart->pluck('total')) !!},
                    borderColor: 'rgba(54, 162, 235, 0.9)',
                    backgroundColor: 'rgba(54, 162, 235, 0.3)',
                    tension: 0.3,
                    fill: true,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                scales: {
                    x: {
                        type: 'time',
                        time: {
                            unit: "{{ $filter === 'all' ? 'month' : 'day' }}", // otomatis: per bulan jika 'all', per hari jika lainnya
                            tooltipFormat: "{{ $filter === 'all' ? 'MMMM yyyy' : 'dd MMM yyyy' }}",
                            displayFormats: {
                                day: 'dd MMM',
                                month: 'MMM yyyy'
                            }
                        },
                        ticks: {
                            source: 'auto'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function (value) {
                                return Number.isInteger(value) ? value : '';
                            }
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            title: (tooltipItems) => {
                                return labelFormatter(tooltipItems[0].label);
                            },
                            label: (tooltipItem) => {
                                return `${tooltipItem.dataset.label}: ${tooltipItem.raw}`;
                            }
                        }
                    }
                }
            }
        });

        // Line Chart Keuntungan
        const keuntunganChart = new Chart(document.getElementById('keuntunganChart'), {
            type: 'line',
            data: {
                labels: {!! json_encode($keuntunganChart->pluck('label')) !!},
                datasets: [{
                    label: 'Total Keuntungan',
                    data: {!! json_encode($keuntunganChart->pluck('total')) !!},
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    tension: 0.3,
                    fill: true,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                scales: {
                    x: {
                        type: 'time',
                        time: {
                            unit: "{{ $filter === 'all' ? 'month' : 'day' }}",
                            tooltipFormat: "{{ $filter === 'all' ? 'MMMM yyyy' : 'dd MMM yyyy' }}",
                            displayFormats: {
                                day: 'dd MMM',
                                month: 'MMM yyyy'
                            }
                        },
                        ticks: {
                            source: 'auto'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function (value) {
                                return 'Rp' + numberFormatter.format(value);
                            }
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            title: (tooltipItems) => {
                                return labelFormatter(tooltipItems[0].label);
                            },
                            label: (tooltipItem) => {
                                return `${tooltipItem.dataset.label}: Rp${numberFormatter.format(tooltipItem.raw)}`;
                            }
                        }
                    }
                }
            }
        });
    </script>
@endsection