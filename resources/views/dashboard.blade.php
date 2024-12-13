@extends('layouts.app')

@section('title', 'SIMTEK | Dashboard')

@section('content')

    <h1 class="mt-4">Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">Stok Obat</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <h4>{{ $stokObat }}</h4>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning text-white mb-4">
                <div class="card-body">Stok Alat Kesehatan</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <h4>{{ $stokAlatKesehatan }}</h4>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">Pembelian Minggu Ini</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <h4>Rp {{ number_format($pembelianMingguIni, 0, ',', '.') }}</h4>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-danger text-white mb-4">
                <div class="card-body">Penjualan Minggu Ini</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <h4>Rp {{ number_format($penjualanMingguIni, 0, ',', '.') }}</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-area me-1"></i>
                    Transaksi 7 Hari Terakhir
                </div>
                <div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas></div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-bar me-1"></i>
                    Transaksi Per Bulan
                </div>
                <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>

        // Area Chart Example
        var ctxA = document.getElementById('myAreaChart').getContext('2d');
        var myAreaChart = new Chart(ctxA, {
            type: 'line',
            data: {
                labels: {!! json_encode($labels) !!}, // Labels dari controller
                datasets: [{
                    label: 'Pembelian',
                    data: {!! json_encode($pembelianData) !!}, // Data pembelian dari controller
                    backgroundColor: 'rgba(75, 192, 192, 0.2)', // Warna background
                    borderColor: 'rgba(75, 192, 192, 1)', // Warna border
                    borderWidth: 1,
                    fill: true // Mengisi area di bawah garis
                }, {
                    label: 'Penjualan',
                    data: {!! json_encode($penjualanData) !!}, // Data penjualan dari controller
                    backgroundColor: 'rgba(255, 99, 132, 0.2)', // Warna background
                    borderColor: 'rgba(255, 99, 132, 1)', // Warna border
                    borderWidth: 1,
                    fill: true // Mengisi area di bawah garis
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true // Memastikan sumbu Y dimulai dari nol
                    }
                },
                legend: {
                    display: true // Menampilkan legend
                }
            }
        });


        // Bar Chart
        var ctxB = document.getElementById('myBarChart').getContext('2d');
        var myBarChart = new Chart(ctxB, {
            type: 'bar',
            data: {
                labels: {!! json_encode($labelsBulan) !!},
                datasets: [{
                    label: 'Pembelian',
                    data: {!! json_encode($totalPembelianData) !!},
                    backgroundColor: 'rgba(75, 192, 192, 0.5)',
                }, {
                    label: 'Penjualan',
                    data: {!! json_encode($totalPenjualanData) !!},
                    backgroundColor: 'rgba(255, 99, 132, 0.5)',
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

@endsection
