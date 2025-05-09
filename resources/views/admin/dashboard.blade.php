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
                <div class="col-xxl-4">
                    <div class="card stretch stretch-full">
                        <div class="card-header">
                            <h5 class="card-title">Barang Paling Laku</h5>
                        </div>
                        <div class="card-body custom-card-action">
                            @foreach ($topBarangKeluar as $item)
                                <div class="hstack justify-content-between border border-dashed rounded-3 p-3 mb-3">
                                    <div class="hstack">
                                        <!-- <div>
                                            <img src="{{ asset('storage/' . $item->barang->gambar) }}" alt="" style="width:20%" />
                                        </div> -->
                                        <div>
                                            <a>{{ $item->barang->nama }}</a>
                                            <div class="fs-11 text-muted">{{ $item->total_keluar }} kali</div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <!-- Barang Stok Kurang -->
                <div class="col-xxl-4">
                    <div class="card stretch stretch-full">
                        <div class="card-header">
                            <h5 class="card-title">Barang dengan stok kurang dari 3</h5>
                        </div>
                        <div class="card-body custom-card-action">
                            @if ($stokHampirHabis->isEmpty())
                                <p>Tidak ada barang dengan stok rendah.</p>
                            @else
                                @foreach ($stokHampirHabis as $barang)
                                    <div class="hstack justify-content-between border border-dashed rounded-3 p-3 mb-3">
                                        <div class="hstack">
                                            <div>
                                                <a>{{ $barang->nama }}</a>
                                                <div class="fs-11 text-muted">stok: {{ $barang->stok }}</div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                <!-- Barang Kedaluwarsa -->
                <div class="col-xxl-4">
                    <div class="card stretch stretch-full">
                        <div class="card-header">
                            <h5 class="card-title">Barang mendekati kedaluwarsa</h5>
                        </div>
                        <div class="card-body custom-card-action">
                            @if ($barangKadaluarsa->isEmpty())
                                <p>Tidak ada barang yang kadaluarsa bulan ini.</p>
                            @else
                                @foreach ($barangKadaluarsa as $barang)
                                    <div class="hstack justify-content-between border border-dashed rounded-3 p-3 mb-3">
                                        <div class="hstack">
                                            <div>
                                                <a>{{ $barang->nama_barang }}</a>
                                                <div class="fs-11 text-muted">{{ \Carbon\Carbon::parse($barang->kedaluwarsa)->format('d M Y') }} - Stok Sisa: {{ $barang->stok_sisa }}</div>
                                            </div>
                                        </div>
                                    </div>
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
                    <div class="col-xxl-3 col-md-6">
                        <div class="p-3 border border-dashed rounded">
                            <div class="fs-12 text-muted mb-1">Jumlah Pesanan {{ $labelWaktu }}</div>
                            <h6 class="fw-bold text-dark">{{ $jumlahPesanan }}</h6>
                        </div>
                    </div>

                    <div class="col-xxl-3 col-md-6">
                        <div class="p-3 border border-dashed rounded">
                            <div class="fs-12 text-muted mb-1">Jumlah Barang Masuk {{ $labelWaktu }}</div>
                            <h6 class="fw-bold text-dark">{{ $jumlahBarangMasuk }}</h6>
                        </div>
                    </div>

                    <div class="col-xxl-3 col-md-6">
                        <div class="p-3 border border-dashed rounded">
                            <div class="fs-12 text-muted mb-1">Jumlah Barang Keluar {{ $labelWaktu }}</div>
                            <h6 class="fw-bold text-dark">{{ $jumlahBarangKeluar }}</h6>
                        </div>
                    </div>

                    <div class="col-xxl-3 col-md-6">
                        <div class="p-3 border border-dashed rounded">
                            <div class="fs-12 text-muted mb-1">Keuntungan {{ $labelWaktu }}</div>
                            <h6 class="fw-bold text-dark">Rp {{ number_format($jumlahKeuntungan, 0, ',', '.') }}</h6>
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


    //     $(document).ready(function () {
    //     new ApexCharts(document.querySelector("#payment-records-chart"), {
    //         chart: { height: 380, width: "100%", stacked: !1, toolbar: { show: !1 } },
    //         stroke: { width: [1, 2, 3], curve: "smooth", lineCap: "round" },
    //         plotOptions: { bar: { endingShape: "rounded", columnWidth: "30%" } },
    //         colors: ["#3454d1", "#a2acc7", "#E1E3EA"],
    //         series: [
    //             { name: "Payment Rejected", type: "bar", data: [23, 11, 22, 27, 13, 22, 37, 21, 44, 22, 30, 21] },
    //             { name: "Payment Completed", type: "line", data: [44, 55, 41, 67, 22, 43, 21, 41, 56, 27, 43, 41] },
    //             { name: "Awaiting Payment", type: "bar", data: [44, 55, 41, 67, 22, 43, 21, 41, 56, 27, 43, 56] },
    //         ],
    //         fill: {
    //             opacity: [0.85, 0.25, 1, 1],
    //             gradient: {
    //                 inverseColors: !1,
    //                 shade: "light",
    //                 type: "vertical",
    //                 opacityFrom: 0.5,
    //                 opacityTo: 0.1,
    //                 stops: [0, 100, 100, 100],
    //             },
    //         },
    //         markers: { size: 0 },
    //         xaxis: {
    //             categories: [
    //                 "JAN/23",
    //                 "FEB/23",
    //                 "MAR/23",
    //                 "APR/23",
    //                 "MAY/23",
    //                 "JUN/23",
    //                 "JUL/23",
    //                 "AUG/23",
    //                 "SEP/23",
    //                 "OCT/23",
    //                 "NOV/23",
    //                 "DEC/23",
    //             ],
    //             axisBorder: { show: !1 },
    //             axisTicks: { show: !1 },
    //             labels: { style: { fontSize: "10px", colors: "#A0ACBB" } },
    //         },
    //         yaxis: {
    //             labels: {
    //                 formatter: function (e) {
    //                     return +e + "K";
    //                 },
    //                 offsetX: -5,
    //                 offsetY: 0,
    //                 style: { color: "#A0ACBB" },
    //             },
    //         },
    //         grid: {
    //             xaxis: { lines: { show: !1 } },
    //             yaxis: { lines: { show: !1 } },
    //         },
    //         dataLabels: { enabled: !1 },
    //         tooltip: {
    //             y: {
    //                 formatter: function (e) {
    //                     return +e + "K";
    //                 },
    //             },
    //             style: { fontSize: "12px", fontFamily: "Inter" },
    //         },
    //         legend: {
    //             show: !1,
    //             labels: { fontSize: "12px", colors: "#A0ACBB", fontFamily: "Inter" },
    //             fontSize: "12px",
    //             fontFamily: "Inter",
    //         },
    //     }).render();
    // }),
    </script>
@endsection