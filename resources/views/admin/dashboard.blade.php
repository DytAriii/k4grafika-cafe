@extends('admin')

@section('content')
<div class="dashboard-container">
    <h1 class="dashboard-title">Dashboard</h1>

    <!-- Bagian Statistik -->
    <div class="stats-row">
        <div class="stat-card">
            <h3>Total Transaksi Hari Ini</h3>
            <p class="stat-value">125</p>
        </div>

        <div class="stat-card">
            <h3>Total Pendapatan</h3>
            <p class="stat-value">Rp 350.000</p>
        </div>

        <div class="stat-card">
            <h3>Menu Terlaris</h3>
            <p class="stat-value">Nasi Goreng</p>
        </div>

        <div class="stat-card">
            <h3>Jumlah Kasir Aktif</h3>
            <p class="stat-value">5</p>
        </div>

        <div class="stat-card">
            <h3>Menu Aktif</h3>
            <p class="stat-value">15</p>
        </div>
    </div>

    <!-- Bagian Grafik -->
    <div class="charts-row">
        <div class="chart-card">
            <h3>Grafik Penjualan Harian</h3>
            <canvas id="dailyChart"></canvas>
        </div>

        <div class="chart-card">
            <h3>Grafik Penjualan Bulanan</h3>
            <canvas id="monthlyChart"></canvas>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Grafik Harian (Dummy)
    const ctxDaily = document.getElementById('dailyChart');
    new Chart(ctxDaily, {
        type: 'line',
        data: {
            labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
            datasets: [{
                label: 'Penjualan',
                data: [12, 19, 8, 15, 22, 30, 18],
                borderColor: '#a94d28',
                backgroundColor: 'rgba(169, 77, 40, 0.2)',
                fill: true,
                tension: 0.3
            }]
        }
    });

    // Grafik Bulanan (Dummy)
    const ctxMonthly = document.getElementById('monthlyChart');
    new Chart(ctxMonthly, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul'],
            datasets: [{
                label: 'Pendapatan',
                data: [500000, 700000, 650000, 800000, 900000, 750000, 1000000],
                backgroundColor: '#215c3c'
            }]
        }
    });
</script>
@endpush

{{-- Panggil file CSS --}}

<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">