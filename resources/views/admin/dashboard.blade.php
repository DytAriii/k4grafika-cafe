@extends('admin')

@push('styles')

<style>
/* ====================== WARNA ======================= */
:root {
    --primary-50: #fdf6f2;
    --primary-100: #f9e5db;
    --primary-200: #f3ccb8;
    --primary-300: #e9a98a;
    --primary-400: #dd7f5c;
    --primary-500: #d15e36;
    --primary-600: #a74c29;
    --primary-700: #8a3d23;
    --primary-800: #723322;
    --primary-900: #612c1f;

    --neutral-50: #f9fafb;
    --neutral-100: #f3f4f6;
    --neutral-200: #e5e7eb;
    --neutral-300: #d1d5db;
    --neutral-400: #9ca3af;
    --neutral-500: #6b7280;
    --neutral-600: #4b5563;
    --neutral-700: #374151;
    --neutral-800: #1f2937;
    --neutral-900: #111827;

    --success: #10b981;
    --warning: #f59e0b;
    --danger: #ef4444;
    --info: #3b82f6;
}

body {
    background-color: var(--neutral-50);
    font-family: 'Poppins', 'Inter', 'Segoe UI', sans-serif;
}

.dashboard-container {
    max-width: 100%;
    margin: 0 auto;
    padding: 35px 0 0 0; 
}

/* ====================== TYPOGRAPHY SYSTEM ======================= */
/* 
  Font Size System:
  - H1: 28px (Judul utama)
  - H2: 20px (Judul section)
  - H3: 16px (Subjudul card)
  - Body Large: 14px (Teks utama)
  - Body: 13px (Teks biasa)
  - Body Small: 12px (Teks kecil)
  - Body XSmall: 11px (Teks sangat kecil)
*/

/* ====================== STAT CARD - 4 KOTAK SEJAJAR FULL WIDTH ======================= */
.stats-row {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 15px;
    padding-bottom: 25px;
}

.stat-card {
    background: white;
    padding: 15px;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    border-left: 4px solid var(--primary-600);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    min-height: 110px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.stat-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.08);
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    width: 50px;
    height: 50px;
    background: var(--primary-50);
    border-radius: 0 0 0 50px;
    z-index: 0;
}

.stat-card h3 {
    font-size: 12px; /* Body Small */
    font-weight: 600;
    color: var(--neutral-600);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 8px;
    z-index: 1;
    position: relative;
}

.stat-value {
    font-size: 20px; /* Konsisten untuk semua stat value */
    font-weight: 700;
    color: var(--neutral-900);
    margin: 0;
    z-index: 1;
    position: relative;
}

.stat-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    background: var(--primary-600);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 8px;
    font-size: 16px;
    z-index: 1;
    position: relative;
}

/* Warna ikon berbeda untuk setiap card */
.stat-card:nth-child(1) .stat-icon { 
    background: linear-gradient(135deg, var(--primary-600), var(--primary-500)); 
}
.stat-card:nth-child(2) .stat-icon { 
    background: linear-gradient(135deg, var(--info), #2563eb); 
}
.stat-card:nth-child(3) .stat-icon { 
    background: linear-gradient(135deg, var(--success), #059669); 
}
.stat-card:nth-child(4) .stat-icon { 
    background: linear-gradient(135deg, var(--warning), #d97706); 
}

/* ====================== MAIN CONTENT LAYOUT ======================= */
.main-content {
    display: flex;
    gap: 20px;
}

.left-charts {
    flex: 2;
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.right-sidebar {
    flex: 1;
    display: flex;
    flex-direction: column;
}

/* Grafik Penjualan 7 Hari - FULL WIDTH */
.chart-full-width {
    background: white;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    transition: all 0.3s ease;
}

.chart-full-width:hover {
    box-shadow: 0 6px 20px rgba(0,0,0,0.08);
}

.chart-full-width h3 {
    font-size: 16px; /* H3 */
    margin-bottom: 15px;
    color: var(--neutral-800);
    display: flex;
    align-items: center;
    gap: 10px;
    font-weight: 600;
}

.chart-full-width h3 i {
    color: var(--primary-600);
    background: var(--primary-50);
    width: 32px;
    height: 32px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
}

.full-chart-container {
    height: 300px;
    position: relative;
}

/* Two Charts Row - Grafik Pendapatan & Menu Terlaris */
.two-charts-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

.chart-card {
    background: white;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    transition: all 0.3s ease;
}

.chart-card:hover {
    box-shadow: 0 6px 20px rgba(0,0,0,0.08);
}

.chart-card h3 {
    font-size: 16px; /* H3 - Sama dengan chart lain */
    margin-bottom: 15px;
    color: var(--neutral-800);
    display: flex;
    align-items: center;
    gap: 10px;
    font-weight: 600;
}

.chart-card h3 i {
    color: var(--primary-600);
    background: var(--primary-50);
    width: 32px;
    height: 32px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
}

.chart-container {
    height: 250px;
    position: relative;
}

/* ====================== RIGHT SIDEBAR ======================= */
.sidebar-box {
    background: white;
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    margin-bottom: 20px;
    transition: all 0.3s ease;
}

.sidebar-box:hover {
    box-shadow: 0 6px 20px rgba(0,0,0,0.08);
}

.sidebar-box h3 {
    font-size: 16px; /* H3 - Sama dengan chart */
    margin-bottom: 15px;
    color: var(--neutral-800);
    display: flex;
    align-items: center;
    gap: 10px;
    font-weight: 600;
}

.sidebar-box h3 i {
    color: var(--primary-600);
    background: var(--primary-50);
    width: 32px;
    height: 32px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
}

/* Quick Action Single */
.quick-action-single {
    display: flex;
    justify-content: center;
}

.quick-action-btn {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 15px 20px;
    background: linear-gradient(135deg, var(--primary-500), var(--primary-600));
    color: white;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.3s ease;
    width: 100%;
    text-align: left;
    font-family: 'Poppins', sans-serif;
    text-decoration: none;
}

.quick-action-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(167, 76, 41, 0.3);
    background: linear-gradient(135deg, var(--primary-600), var(--primary-700));
}

.quick-action-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    background: rgba(255, 255, 255, 0.2);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    flex-shrink: 0;
}

.quick-action-text {
    font-size: 14px; /* Body Large */
    font-weight: 600;
    flex: 1;
}

.quick-action-arrow {
    font-size: 14px;
    opacity: 0.8;
}

/* Kalender */
.calendar-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 12px;
    padding-bottom: 10px;
    border-bottom: 1px solid var(--neutral-200);
}

.calendar-header .month-year {
    font-weight: 600;
    color: var(--neutral-800);
    font-size: 14px; /* Body Large */
}

.calendar-nav {
    display: flex;
    gap: 6px;
}

.calendar-nav button {
    background: var(--neutral-100);
    border: none;
    width: 28px;
    height: 28px;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    color: var(--neutral-600);
    transition: all 0.2s;
    font-size: 10px;
}

.calendar-nav button:hover {
    background: var(--primary-100);
    color: var(--primary-600);
}

.calendar-box table {
    width: 100%;
    text-align: center;
    font-size: 12px; /* Body Small - disamakan */
    border-collapse: collapse;
}

.calendar-box th {
    padding: 6px 0;
    color: var(--primary-600);
    font-weight: 600;
    font-size: 11px; /* Body XSmall */
}

.calendar-box td {
    padding: 6px 0;
    border-radius: 6px;
    transition: all 0.2s;
    cursor: pointer;
    font-size: 12px; /* Body Small - disamakan */
}

.calendar-box td:hover:not(.calendar-today) {
    background: var(--primary-50);
}

.calendar-today {
    background: var(--primary-600);
    color: white;
    font-weight: 700;
}

.calendar-other-month {
    color: var(--neutral-400);
}

/* Activity Log */
.activity-item {
    padding: 12px 0;
    border-bottom: 1px solid var(--neutral-200);
    display: flex;
    align-items: flex-start;
    gap: 10px;
}

.activity-item:last-child {
    border-bottom: none;
    padding-bottom: 0;
}

.activity-item:first-child {
    padding-top: 0;
}

.activity-icon {
    width: 28px;
    height: 28px;
    border-radius: 7px;
    background: var(--primary-50);
    color: var(--primary-600);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    flex-shrink: 0;
    margin-top: 1px;
}

.activity-content {
    flex: 1;
}

.activity-content p {
    margin: 0 0 3px 0;
    color: var(--neutral-800);
    font-size: 13px; /* Body - disamakan */
    line-height: 1.3;
    font-weight: 400;
}

.activity-time {
    font-size: 11px; /* Body XSmall - disamakan */
    color: var(--neutral-500);
    font-weight: 500;
}

/* ====================== RESPONSIVE ======================= */
@media (max-width: 1200px) {
    .stats-row {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .main-content {
        grid-template-columns: 1fr;
        gap: 15px;
    }
    
    .two-charts-row {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 768px) {
    .dashboard-container {
        padding: 15px;
    }
    
    .stats-row {
        grid-template-columns: 1fr;
        gap: 12px;
    }
    
    .chart-full-width, .chart-card, .sidebar-box {
        padding: 16px;
    }
    
    .full-chart-container {
        height: 250px;
    }
    
    .chart-container {
        height: 200px;
    }
    
    /* Adjust font sizes for mobile */
    .stat-value {
        font-size: 18px;
    }
    
    .chart-full-width h3,
    .chart-card h3,
    .sidebar-box h3 {
        font-size: 15px;
    }
}

@media (max-width: 480px) {
    .stat-value {
        font-size: 18px;
    }
    
    .quick-action-text {
        font-size: 13px;
    }
    
    .activity-content p {
        font-size: 12px;
    }
    
    .calendar-box table {
        font-size: 11px;
    }
    
    .calendar-box td {
        font-size: 11px;
    }
}
/* Batas tinggi log activity */
.activity-log-wrapper {
    max-height: 250px;   /* Sesuaikan tinggi */
    overflow-y: auto;
    padding-right: 5px; 
}

/* Scrollbar halus */
.activity-log-wrapper::-webkit-scrollbar {
    width: 6px;
}

.activity-log-wrapper::-webkit-scrollbar-thumb {
    background: var(--primary-300);
    border-radius: 10px;
}

.activity-log-wrapper::-webkit-scrollbar-track {
    background: var(--neutral-100);
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
/* ===========================================
   CHART JS
   =========================================== */

// Data bulan fix
const allMonths = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
const monthlySalesData = {!! json_encode($monthlySales) !!};

function mapMonthlyData(backendData) {
    const monthlyData = new Array(12).fill(0);
    backendData.forEach(item => {
        monthlyData[item.bulan - 1] = item.total;
    });
    return monthlyData;
}

// Grafik 7 Hari - FULL WIDTH
new Chart(document.getElementById('dailyChart'), {
    type: 'line',
    data: {
        labels: {!! json_encode($sevenDays->pluck('tanggal')) !!},
        datasets: [{
            label: "Pendapatan",
            data: {!! json_encode($sevenDays->pluck('total')) !!},
            borderWidth: 3,
            borderColor: '#A74C29',
            backgroundColor: 'rgba(167,76,41,0.1)',
            fill: true,
            tension: 0.4,
            pointBackgroundColor: '#A74C29',
            pointBorderColor: '#fff',
            pointBorderWidth: 2,
            pointRadius: 4,
            pointHoverRadius: 6
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { 
            legend: { 
                display: false 
            },
            tooltip: {
                backgroundColor: 'rgba(255,255,255,0.95)',
                titleColor: '#1f2937',
                bodyColor: '#4b5563',
                borderColor: '#e5e7eb',
                borderWidth: 1,
                cornerRadius: 8,
                displayColors: false,
                callbacks: {
                    label: function(context) {
                        return 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                    }
                }
            }
        },
        scales: { 
            y: { 
                beginAtZero: true,
                grid: {
                    color: 'rgba(0,0,0,0.05)'
                },
                ticks: {
                    callback: function(value) {
                        return 'Rp ' + value.toLocaleString('id-ID');
                    }
                }
            },
            x: {
                grid: {
                    color: 'rgba(0,0,0,0.05)'
                }
            }
        }
    }
});

// Grafik Bulanan
new Chart(document.getElementById('monthlyChart'), {
    type: 'bar',
    data: {
        labels: allMonths,
        datasets: [{
            data: mapMonthlyData(monthlySalesData),
            backgroundColor: '#A74C29',
            borderRadius: 6,
            borderSkipped: false,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { 
            legend: { 
                display: false 
            },
            tooltip: {
                backgroundColor: 'rgba(255,255,255,0.95)',
                titleColor: '#1f2937',
                bodyColor: '#4b5563',
                borderColor: '#e5e7eb',
                borderWidth: 1,
                cornerRadius: 8,
                displayColors: false,
                callbacks: {
                    label: function(context) {
                        return 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                    }
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: {
                    color: 'rgba(0,0,0,0.05)'
                },
                ticks: {
                    callback: function(value) {
                        return 'Rp ' + value.toLocaleString('id-ID');
                    }
                }
            },
            x: {
                grid: {
                    display: false
                }
            }
        }
    }
});

// Menu Terlaris
new Chart(document.getElementById('topMenuChart'), {
    type: 'doughnut',
    data: {
        labels: {!! json_encode($topMenu->pluck('nama')) !!},
        datasets: [{
            data: {!! json_encode($topMenu->pluck('total')) !!},
            backgroundColor: ['#A74C29','#D15E36','#DD7F5C','#E9A98A','#F3CCB8'],
            borderWidth: 0,
            spacing: 2
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { 
            legend: { 
                position: 'bottom',
                labels: {
                    padding: 15,
                    usePointStyle: true,
                    pointStyle: 'circle'
                }
            },
            tooltip: {
                backgroundColor: 'rgba(255,255,255,0.95)',
                titleColor: '#1f2937',
                bodyColor: '#4b5563',
                borderColor: '#e5e7eb',
                borderWidth: 1,
                cornerRadius: 8
            }
        },
        cutout: '60%'
    }
});

/* ===========================================
   KALENDER DINAMIS (REAL WORKING)
=========================================== */

let currentDate = new Date(); // default: hari ini

function renderCalendar(date) {
    const year = date.getFullYear();
    const month = date.getMonth();

    const monthNames = [
        "Januari","Februari","Maret","April","Mei","Juni",
        "Juli","Agustus","September","Oktober","November","Desember"
    ];

    // Update teks bulan
    document.getElementById("monthYear").textContent =
        monthNames[month] + " " + year;

    const firstDay = new Date(year, month, 1).getDay(); 
    const daysInMonth = new Date(year, month + 1, 0).getDate();

    const prevMonthDays = new Date(year, month, 0).getDate();

    let calendarHTML = "";
    let dayCount = 1;
    let nextMonthDay = 1;

    // Baris maksimal kalender selalu 6
    for (let i = 0; i < 6; i++) {
        calendarHTML += "<tr>";

        for (let j = 0; j < 7; j++) {
            const cellIndex = i * 7 + j;

            // Tanggal bulan sebelumnya
            if (cellIndex < firstDay) {
                const prevDay = prevMonthDays - (firstDay - cellIndex) + 1;
                calendarHTML += `
                    <td class="calendar-other-month">${prevDay}</td>
                `;
            }
            // Tanggal bulan sekarang
            else if (dayCount <= daysInMonth) {
                const isToday =
                    dayCount === new Date().getDate() &&
                    month === new Date().getMonth() &&
                    year === new Date().getFullYear();

                calendarHTML += `
                    <td class="${isToday ? "calendar-today" : ""}"
                        data-date="${year}-${String(month+1).padStart(2,'0')}-${String(dayCount).padStart(2,'0')}">
                        ${dayCount}
                    </td>
                `;
                dayCount++;
            }
            // Tanggal bulan berikutnya
            else {
                calendarHTML += `
                    <td class="calendar-other-month">${nextMonthDay}</td>
                `;
                nextMonthDay++;
            }
        }

        calendarHTML += "</tr>";
    }

    document.getElementById("calendarBody").innerHTML = calendarHTML;

    bindCalendarClickEvents();
}

// Navigasi bulan
document.getElementById("prevMonth").addEventListener("click", () => {
    currentDate.setMonth(currentDate.getMonth() - 1);
    renderCalendar(currentDate);
});

document.getElementById("nextMonth").addEventListener("click", () => {
    currentDate.setMonth(currentDate.getMonth() + 1);
    renderCalendar(currentDate);
});

// Klik tanggal
function bindCalendarClickEvents() {
    document.querySelectorAll("#calendarBody td[data-date]").forEach(cell => {
        cell.addEventListener("click", function() {
            const selectedDate = this.getAttribute("data-date");

            // ======= PANGGIL AJAX REFRESH DASHBOARD =======
            loadDashboardByDate(selectedDate);

            // Highlight tanggal yang dipilih
            document.querySelectorAll("#calendarBody td").forEach(td => {
                td.classList.remove("calendar-today");
            });
            this.classList.add("calendar-today");
        });
    });
}

renderCalendar(currentDate);

function loadDashboardByDate(selectedDate) {
    fetch(`/dashboard/filter?date=${selectedDate}`)
        .then(res => res.json())
        .then(data => {
            document.getElementById('stat-income').innerText = "Rp " + data.income;
            document.getElementById('stat-transactions').innerText = data.transactions + " transaksi";
            document.getElementById('stat-active-menu').innerText = data.activeMenu;
            document.getElementById('stat-top-menu').innerText = data.topMenu + " (" + data.topMenuTotal + ")";
                        updateLogs(data.logs);
        })
        .catch(err => console.error(err));
}
function updateLogs(logs) {
    let html = "";

    if (logs.length === 0) {
        html = `<p class="text-muted">Tidak ada aktivitas.</p>`;
    } else {
        logs.forEach(log => {
            html += `
                <div class="activity-item">
                    <div class="activity-icon">
                        <i class="fas fa-info"></i>
                    </div>
                    <div class="activity-content">
                        <p><strong>${log.activity}</strong> — ${log.username ?? ''} ${log.description}</p>
                        <div class="activity-time">${new Date(log.created_at).toLocaleString('id-ID')}</div>
                    </div>
                </div>
            `;
        });
    }

    document.getElementById("activityLog").innerHTML = html;
}
</script>
@endpush

@section('content')
<div class="dashboard-container">

    <!-- 4 KOTAK STATISTIK - SEJAJAR DI ATAS -->
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-wallet"></i></div>
            <h3>Total Pendapatan</h3>
            <div class="stat-value" id="stat-income">Rp {{ number_format($todayIncome,0,',','.') }}</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-shopping-cart"></i></div>
            <h3>Transaksi Hari Ini</h3>
            <div class="stat-value" id="stat-transactions">{{ $todayTransactions }}</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-utensils"></i></div>
            <h3>Menu Terlaris</h3>
            <div class="stat-value" id="stat-top-menu">{{ $topMenuToday->nama ?? '-' }}</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-clipboard-list"></i></div>
            <h3>Menu Aktif</h3>
            <div class="stat-value" id="stat-active-menu">{{ $activeMenu }}</div>
        </div>
    </div>

    <!-- MAIN CONTENT - GRAFIK & SIDEBAR -->
    <div class="main-content">

        <!-- ========== LEFT SIDE - GRAFIK ========== -->
        <div class="left-charts">

            <!-- GRAFIK PENJUALAN 7 HARI - FULL WIDTH -->
            <div class="chart-full-width">
                <h3><i class="fas fa-chart-line"></i> Penjualan 7 Hari Terakhir</h3>
                <div class="full-chart-container"><canvas id="dailyChart"></canvas></div>
            </div>

            <!-- TWO CHARTS ROW - GRAFIK PENDAPATAN & MENU TERLARIS -->
            <div class="two-charts-row">
                <!-- GRAFIK PENDAPATAN -->
                <div class="chart-card">
                    <h3><i class="fas fa-chart-bar"></i> Pendapatan {{ date('Y') }}</h3>
                    <div class="chart-container"><canvas id="monthlyChart"></canvas></div>
                </div>

                <!-- GRAFIK MENU TERLARIS -->
                <div class="chart-card">
                    <h3><i class="fas fa-chart-pie"></i> Menu Terlaris</h3>
                    <div class="chart-container"><canvas id="topMenuChart"></canvas></div>
                </div>
            </div>

        </div>

        <!-- ========== RIGHT SIDE - QUICK ACTIONS, KALENDER & LOG AKTIVITAS ========== -->
        <div>
<div class="right-sidebar">
            <div class="sidebar-box">
    <div class="quick-action-single">
        <a href="{{ route('admin.laporan') }}" class="quick-action-btn">
            <div class="quick-action-icon">
                <i class="fas fa-file-alt"></i>
            </div>
            <div class="quick-action-text">Lihat Laporan Lengkap</div>
            <i class="fas fa-arrow-right quick-action-arrow"></i>
        </a>
    </div>
</div>

            <!-- KALENDER -->
            <div class="sidebar-box calendar-box">
                <div class="calendar-box">
    <div class="calendar-header">
        <span id="monthYear" class="month-year"></span>

        <div class="calendar-nav">
            <button id="prevMonth">&lt;</button>
            <button id="nextMonth">&gt;</button>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Min</th>
                <th>Sen</th>
                <th>Sel</th>
                <th>Rab</th>
                <th>Kam</th>
                <th>Jum</th>
                <th>Sab</th>
            </tr>
        </thead>
        <tbody id="calendarBody"></tbody>
    </table>
</div>

            </div>

            <!-- ACTIVITY LOG -->
            <div class="sidebar-box">
    <h3><i class="fa-solid fa-clock"></i> Activity Log</h3>

    <div class="activity-log-wrapper" id="activityLog">
        @forelse ($logs as $log)
            <div class="activity-item">
                <div class="activity-icon">
                    <i class="fas fa-info"></i>
                </div>
                <div class="activity-content">
                    <p><strong>{{ $log->activity }}</strong> — 
                       {{ $log->user->username ?? 'User' }} {{ $log->description }}
                    </p>
                    <div class="activity-time">{{ $log->created_at->diffForHumans() }}</div>
                </div>
            </div>
        @empty
            <p class="text-muted">Tidak ada aktivitas.</p>
        @endforelse
    </div>
</div>
</div>
    </div>
</div>
</div>
</div>
@endsection