@extends('layouts.app')

@section('content')
<style>
    .riwayat-container {
        padding: 20px;
        font-family: Arial, sans-serif;
    }

    .title {
        font-size: 1.4rem;
        margin-bottom: 20px;
        border-left: 5px solid #4A90E2;
        padding-left: 10px;
        color: #333;
    }

    .card {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        padding: 15px;
    }

    .custom-table {
        width: 100%;
        border-collapse: collapse;
    }

    .custom-table thead {
        background: #f5f7fa;
    }

    .custom-table th, .custom-table td {
        padding: 10px 12px;
        text-align: left;
        font-size: 0.9rem;
        border-bottom: 1px solid #e0e0e0;
    }

    .custom-table tbody tr:hover {
        background: #f9fbfd;
    }

    .fw-bold { font-weight: bold; }
    .text-success { color: #28a745; font-weight: bold; }

    .badge {
        padding: 3px 8px;
        border-radius: 4px;
        font-size: 0.8rem;
        font-weight: bold;
    }

    .badge.cash { background: #28a745; color: #fff; }
    .badge.qris { background: #17a2b8; color: #fff; }
    .badge.takeaway { background: #ffc107; color: #000; }
    .badge.dinein { background: #6f42c1; color: #fff; }

    .btn-detail {
        padding: 5px 10px;
        background: #4A90E2;
        color: #fff;
        border: none;
        border-radius: 6px;
        font-size: 0.8rem;
        cursor: pointer;
        transition: 0.2s;
    }

    .btn-detail:hover {
        background: #357ABD;
    }

    .detail-row { display: none; }
    .detail-box {
        padding: 15px;
        border-radius: 6px;
        background: #fdfdfd;
        border: 1px solid #e6e6e6;
    }

    .detail-box h4 {
        margin: 0 0 10px 0;
        font-size: 1rem;
        color: #4A90E2;
    }

    .detail-box ul { margin: 0; padding: 0; list-style: none; }
    .detail-box li {
        display: flex;
        justify-content: space-between;
        padding: 5px 0;
        border-bottom: 1px dashed #ddd;
        font-size: 0.9rem;
    }
    .detail-box li:last-child { border-bottom: none; }

    .muted { color: #888; font-size: 0.85rem; margin-left: 5px; }
    .price { font-weight: bold; color: #28a745; }
</style>

<div class="riwayat-container">
    <h3 class="title">
        &#128340; Riwayat Transaksi
    </h3>

    <div class="card">
        <table class="custom-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Invoice</th>
                    <th>Customer</th>
                    <th>Tipe Pesanan</th>
                    <th>Metode</th>
                    <th>Total</th>
                    <th>Waktu</th>
                    <th>Detail</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaksis as $i => $trx)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td><span class="fw-bold">{{ $trx->invoice }}</span></td>
                    <td>{{ $trx->nama_customer ?? 'Umum' }}</td>
                    <td>
                        <span class="badge {{ $trx->order_type == 'takeaway' ? 'takeaway' : 'dinein' }}">
                            {{ ucfirst($trx->order_type) }}
                        </span>
                    </td>
                    <td>
                        <span class="badge {{ $trx->metode_pembayaran == 'cash' ? 'cash' : 'qris' }}">
                            {{ strtoupper($trx->metode_pembayaran) }}
                        </span>
                    </td>
                    <td class="text-success">Rp{{ number_format($trx->total,0,',','.') }}</td>
                    <td>{{ $trx->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <button class="btn-detail" onclick="toggleDetail({{ $trx->id }})">
                            Lihat
                        </button>
                    </td>
                </tr>
                <tr id="detail{{ $trx->id }}" class="detail-row">
                    <td colspan="8">
                        <div class="detail-box">
                            <h4>Detail Pesanan</h4>
                            <ul>
                                @foreach($trx->details as $detail)
                                    <li>
                                        {{ $detail->menu->nama }} 
                                        <span class="muted">x {{ $detail->jumlah }}</span>
                                        <span class="price">Rp{{ number_format($detail->subtotal,0,',','.') }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    function toggleDetail(id) {
        const row = document.getElementById('detail' + id);
        row.style.display = (row.style.display === "table-row") ? "none" : "table-row";
    }
</script>
@endsection
