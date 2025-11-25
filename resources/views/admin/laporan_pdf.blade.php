<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Kasir - {{ $laporan['nama'] }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #333;
            padding-bottom: 15px;
        }
        
        .header h1 {
            font-size: 24px;
            margin-bottom: 5px;
            color: #2c3e50;
        }
        
        .header p {
            font-size: 14px;
            color: #7f8c8d;
        }
        
        .info-section {
            margin-bottom: 25px;
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
        }
        
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }
        
        .info-label {
            font-weight: bold;
            color: #555;
        }
        
        .info-value {
            color: #333;
        }
        
        .summary-section {
            display: flex;
            justify-content: space-around;
            margin-bottom: 25px;
            gap: 15px;
        }
        
        .summary-box {
            flex: 1;
            background: #3498db;
            color: white;
            padding: 15px;
            border-radius: 5px;
            text-align: center;
        }
        
        .summary-box.revenue {
            background: #27ae60;
        }
        
        .summary-box.average {
            background: #e67e22;
        }
        
        .summary-label {
            font-size: 11px;
            margin-bottom: 5px;
            opacity: 0.9;
        }
        
        .summary-value {
            font-size: 18px;
            font-weight: bold;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        thead {
            background: #34495e;
            color: white;
        }
        
        th {
            padding: 12px 8px;
            text-align: left;
            font-weight: bold;
            font-size: 11px;
        }
        
        td {
            padding: 10px 8px;
            border-bottom: 1px solid #ddd;
            font-size: 11px;
        }
        
        tbody tr:nth-child(even) {
            background: #f8f9fa;
        }
        
        tbody tr:hover {
            background: #e8f4f8;
        }
        
        .payment-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: bold;
        }
        
        .payment-cash {
            background: #d4edda;
            color: #155724;
        }
        
        .payment-qris {
            background: #cce5ff;
            color: #004085;
        }
        
        .payment-debit {
            background: #fff3cd;
            color: #856404;
        }
        
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #7f8c8d;
            border-top: 1px solid #ddd;
            padding-top: 15px;
        }
        
        .text-right {
            text-align: right;
        }
        
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
    {{-- Header --}}
    <div class="header">
        <h1>LAPORAN TRANSAKSI KASIR</h1>
        <p>Sistem Kasir Cafe K4 Grafika</p>
    </div>

    {{-- Info Kasir --}}
    <div class="info-section">
        <div class="info-row">
            <span class="info-label">Nama Kasir:</span>
            <span class="info-value">{{ $laporan['nama'] }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Periode:</span>
            <span class="info-value">{{ $laporan['periode'] }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Tanggal Cetak:</span>
            <span class="info-value">{{ $laporan['tanggal_cetak'] }}</span>
        </div>
    </div>

    {{-- Summary --}}
    <div class="summary-section">
        <div class="summary-box">
            <div class="summary-label">Jumlah Transaksi</div>
            <div class="summary-value">{{ $laporan['jumlah_transaksi'] }}</div>
        </div>
        <div class="summary-box revenue">
            <div class="summary-label">Total Pendapatan</div>
            <div class="summary-value">Rp{{ number_format($laporan['total_pendapatan'], 0, ',', '.') }}</div>
        </div>
        <div class="summary-box average">
            <div class="summary-label">Rata-rata per Transaksi</div>
            <div class="summary-value">Rp{{ number_format($laporan['rata_rata'], 0, ',', '.') }}</div>
        </div>
    </div>

    {{-- Tabel Transaksi --}}
    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 15%;">Invoice</th>
                <th style="width: 35%;">Menu</th>
                <th style="width: 12%;">Metode</th>
                <th style="width: 15%;" class="text-right">Total</th>
                <th style="width: 18%;">Waktu</th>
            </tr>
        </thead>
        <tbody>
            @forelse($laporan['transaksi'] as $i => $trx)
                <tr>
                    <td class="text-center">{{ $i + 1 }}</td>
                    <td>{{ $trx['invoice'] }}</td>
                    <td>{{ $trx['menu'] }}</td>
                    <td>
                        <span class="payment-badge payment-{{ strtolower($trx['metode']) }}">
                            {{ $trx['metode'] }}
                        </span>
                    </td>
                    <td class="text-right">Rp{{ number_format($trx['total'], 0, ',', '.') }}</td>
                    <td>{{ $trx['waktu'] }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada transaksi</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>
