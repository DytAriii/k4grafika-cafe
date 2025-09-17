@extends('admin')
@push('styles')
<style>
/* batasi ukuran untuk grafik menu terlaris */
.chart-card--small {
    max-width: 380px; /* ubah sesuai kebutuhan */
    margin: 0 auto;
}
.chart-card--small canvas {
    width: 100% !important;
    /* height: 320px !important;  tinggi tetap agar Chart.js menggambar sesuai 
    max-height: 420px; */
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Grafik Harian (Dummy)
        const dailyEl = document.getElementById('dailyChart');
        if (dailyEl) {
            const ctxDaily = dailyEl.getContext('2d');
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
        }

        // Grafik Bulanan (Dummy)
        const monthlyEl = document.getElementById('monthlyChart');
        if (monthlyEl) {
            const ctxMonthly = monthlyEl.getContext('2d');
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
        }

        // Grafik Menu Terlaris (Dummy)
        const topEl = document.getElementById('topMenuChart');
        if (topEl) {
            const ctxTop = topEl.getContext('2d');
            new Chart(ctxTop, {
                type: 'doughnut',
                data: {
                    labels: ['Nasi Goreng', 'Mie Goreng', 'Kopi Tubruk', 'Es Teh', 'Pisang Goreng'],
                    datasets: [{
                        data: [45, 25, 15, 10, 5],
                        backgroundColor: [
                            '#a94d28',
                            '#e07a5f',
                            '#f2cc8f',
                            '#6a994e',
                            '#2b2d42'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'right'
                        }
                    }
                }
            });
        }

        // Grafik Dine in vs Take Away (Dummy)
        const dineTakeAwayEl = document.getElementById('dineTakeAwayChart');
        if (dineTakeAwayEl) {
            const ctxDineTakeAway = dineTakeAwayEl.getContext('2d');
            new Chart(ctxDineTakeAway, {
                type: 'pie',
                data: {
                    labels: ['Dine In', 'Take Away'],
                    datasets: [{
                        data: [70, 30],
                        backgroundColor: ['#6a994e', '#f2cc8f']
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'right'
                        }
                    }
                }
            });
        }
    });
</script>
            
@endpush

{{-- Panggil file CSS --}}

<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
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

    <div class="charts-row">
        <div class="chart-card">
            <h3>Grafik Menu Terlaris</h3>
            <canvas id="topMenuChart"></canvas>
        </div>

        <div class="chart-card">
            <h3>Grafik Rasio Dine in/Take Away</h3>
            <canvas id="dineTakeAwayChart"></canvas>
        </div>
    </div>
</div>
@endsection