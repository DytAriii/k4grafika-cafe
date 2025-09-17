@extends('layouts.app')

@section('content')
<style>
    .riwayat-container {
        padding: 10px 20px;
        max-width: 1200px;
        margin: 0 auto;
    }

    .title {
        font-size: 1.5rem;
        margin-bottom: 20px;
        margin-top: 0px;
        border-left: 6px solid #A74C29;
        padding-left: 12px;
        color: #333;
        font-weight: bold;
    }

    /* Box Filter */
    .filter-box {
        display: flex;
        gap: 15px;
        margin-bottom: 20px;
        align-items: flex-end;
        background: #fff7f4;
        padding: 15px;
        border: 1px solid #e5d3cc;
        border-radius: 10px;
    }

    .filter-box label {
        font-size: 0.9rem;
        font-weight: bold;
        color: #444;
    }

    .filter-box select, 
    .filter-box input {
        padding: 8px 12px;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 0.9rem;
        width: 180px;
    }

    .btn-filter {
        background: #A74C29;
        color: #fff;
        padding: 8px 16px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 0.9rem;
        font-weight: bold;
        transition: 0.2s;
    }
    .btn-filter:hover {
        background: #8b3f23;
    }

    /* Card */
    .card {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        padding: 20px;
    }

    .custom-table {
        width: 100%;
        border-collapse: collapse;
    }

    .custom-table thead {
        background: #A74C29;
        color: #fff;
    }

    .custom-table th, .custom-table td {
        padding: 12px 14px;
        text-align: left;
        font-size: 0.9rem;
        border-bottom: 1px solid #e0e0e0;
    }

    .custom-table tbody tr:hover {
        background: #fdf6f2;
    }

    .fw-bold { font-weight: bold; }
    .text-success { color: #28a745; font-weight: bold; }

    .badge {
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 0.8rem;
        font-weight: bold;
    }

    .badge.cash { background: #28a745; color: #fff; }
    .badge.qris { background: #17a2b8; color: #fff; }
    .badge.takeaway { background: #ffc107; color: #000; }
    .badge.dinein { background: #6f42c1; color: #fff; }

    .btn-detail, .btn-print {
        padding: 6px 12px;
        border: none;
        border-radius: 6px;
        font-size: 0.8rem;
        cursor: pointer;
        transition: 0.2s;
        margin-right: 5px;
    }

    .btn-detail { background: #A74C29; color: #fff; }
    .btn-detail:hover { background: #8b3f23; }

    .btn-print { background: #28a745; color: #fff; }
    .btn-print:hover { background: #1f7a34; }

    .detail-row { display: none; }
    .detail-box {
        padding: 15px;
        border-radius: 6px;
        background: #fdfaf8;
        border: 1px solid #e6e6e6;
    }

    .detail-box h4 {
        margin: 0 0 12px 0;
        font-size: 1rem;
        color: #A74C29;
        font-weight: bold;
    }

    .detail-box ul { margin: 0; padding: 0; list-style: none; }
    .detail-box li {
        display: flex;
        justify-content: space-between;
        padding: 6px 0;
        border-bottom: 1px dashed #ddd;
        font-size: 0.9rem;
    }
    .detail-box li:last-child { border-bottom: none; }

    .muted { color: #888; font-size: 0.85rem; margin-left: 5px; }
    .price { font-weight: bold; color: #28a745; }
</style>

<div class="riwayat-container">
    <h1 class="title">Riwayat Transaksi</h1>

    <!-- Filter -->
    <div class="filter-box">
        <div>
            <label for="filter-date">Tanggal Transaksi</label><br>
            <input type="date" id="filter-date" value="{{ request('date') }}">
        </div>

        <div>
            <label for="filter-metode">Metode Pembayaran</label><br>
            <select id="filter-metode">
                <option value="">Semua</option>
                <option value="cash" {{ request('metode')=='cash' ? 'selected' : '' }}>Cash</option>
                <option value="qris" {{ request('metode')=='qris' ? 'selected' : '' }}>QRIS</option>
            </select>
        </div>

        <div>
            <label for="filter-order">Jenis Pesanan</label><br>
            <select id="filter-order">
                <option value="">Semua</option>
                <option value="dinein" {{ request('order')=='dinein' ? 'selected' : '' }}>Dine In</option>
                <option value="takeaway" {{ request('order')=='takeaway' ? 'selected' : '' }}>Takeaway</option>
            </select>
        </div>

        <div>
            <button type="button" class="btn-filter" onclick="applyFilter()">Terapkan Filter</button>
        </div>
    </div>

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
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="trxTable">
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
                        <button class="btn-detail" onclick="toggleDetail({{ $trx->id }})">Detail</button>
                        <button class="btn-print" onclick="printNota({{ $trx->id }})">Print</button>
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
        if(row) {
            row.style.display = (row.style.display === "table-row") ? "none" : "table-row";
        }
    }

    function printNota(id) {
        window.open(`/kasir/print/${id}`, '_blank'); 
    }

    function applyFilter() {
        const date = document.getElementById('filter-date').value;
        const metode = document.getElementById('filter-metode').value;
        const order = document.getElementById('filter-order').value;

        let params = [];
        if(date) params.push(`date=${date}`);
        if(metode) params.push(`metode=${metode}`);
        if(order) params.push(`order=${order}`);

        let url = '/kasir/history';
        if(params.length) url += '?' + params.join('&');
        window.location.href = url;
    }
</script>
@endsection
