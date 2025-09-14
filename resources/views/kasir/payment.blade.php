@extends('layouts.app')

@section('content')
<style>
    :root {
        --primary: #A74C29;
        --primary-light: #f4e8e2;
        --light: #f5f6f8;
        --dark: #2c3e50;
        --success: #28a745;
        --danger: #dc3545;
    }

    body { background: var(--light); font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }

    .page-container {
        padding: 10px 20px;
        max-width: 1200px;
        margin: 0 auto;
    }

    .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 30px; }
    @media (max-width: 992px) { .grid { grid-template-columns: 1fr; } }

    /* Card */
    .card {
        background: #fff;
        border-radius: 18px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.08);
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }
    .card-header {
        padding: 20px 24px;
        font-weight: 700;
        font-size: 1.25rem;
        color: var(--dark);
        border-bottom: 1px solid #eef;
    }
    .card-header .header-text {
        color: var(--primary); /* Teks judul berwarna */
    }
    .card-body { padding: 24px; flex-grow: 1; }

    /* Nota (Order Summary) */
    .nota-info {
        display: flex;
        flex-direction: column;
        gap: 8px;
        padding-bottom: 15px;
        border-bottom: 1px solid #eee;
        margin-bottom: 15px;
    }
    .nota-info p {
        margin: 0;
        font-size: 1rem;
        color: var(--dark);
    }
    .nota-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .nota-list li {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 0;
        font-size: 0.95rem;
        color: var(--dark);
        border-bottom: 1px dashed #ddd;
    }
    .nota-list li:last-child { border-bottom: none; }
    .nota-list li small { color: #888; margin-left: 5px; }
    .nota-total-wrap {
        margin-top: 20px;
        text-align: right;
    }
    .nota-total {
        font-size: 1.3rem;
        font-weight: 600;
        color: var(--primary);
        display: inline-block;
        padding: 8px 15px;
        background-color: var(--primary-light);
        border-radius: 8px;
    }

    /* Payment Tabs */
    .payment-tabs {
        display: flex;
        gap: 12px;
        margin-bottom: 25px;
    }
    .payment-tabs button {
        flex: 1;
        padding: 10px;
        border: none;
        border-radius: 8px;
        background: #eef;
        font-weight: 600;
        cursor: pointer;
        transition: 0.3s ease;
        color: var(--dark);
        font-size: 1rem;
    }
    .payment-tabs button.active {
        background: var(--primary);
        color: #fff;
        box-shadow: 0 4px 10px rgba(167, 76, 41, 0.2);
    }
    .payment-tabs button:not(.active):hover {
        background: #e0e0e0;
    }

    /* Cash Method */
    #cash-method, #qris-method {
        min-height: 400px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .display-area {
        background: #f8f8f8;
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 20px;
    }
    #cash-display, #change-display {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 8px;
    }
    #cash-display { color: var(--dark); }
    #change-display { color: var(--success); }

    .grid-buttons {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px; /* Jarak lebih kecil */
        margin-bottom: 20px;
    }
    .grid-buttons .btn {
        font-size: 1.2rem; /* Ukuran font lebih kecil */
        font-weight: bold;
        padding: 16px; /* Padding lebih kecil */
        border-radius: 10px;
        background: #fff;
        border: 1px solid #e0e0e0;
        color: var(--dark);
        transition: 0.2s;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }
    .grid-buttons .btn:hover {
        background: #f1f1f1;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    .grid-buttons .btn-danger { background: var(--danger); color: #fff; border: none; }
    .grid-buttons .btn-danger:hover { background: #c82333; }

    /* General Buttons */
    .btn {
        cursor: pointer;
        transition: 0.2s;
        border: none;
    }
    .btn-primary {
        border: none;
        background: var(--primary);
        color: #fff;
        border-radius: 8px;
        padding: 10px;
        width: 100%;
        font-size: 1rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .btn-primary:hover { opacity: 0.9; }

    /* QRIS Method */
    #qris-method img {
        max-width: 250px;
        width: 100%;
        border-radius: 10px;
        margin: 25px 0;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    #qris-method p strong {
        font-size: 1.2rem;
        color: var(--primary);
    }
</style>

<div class="page-container">
    <div class="grid">
        {{-- Nota --}}
        <div class="card">
            <div class="card-header">
                <span class="header-text">Ringkasan Pesanan</span>
            </div>
            <div class="card-body">
                <div class="nota-info">
                    <p><strong>Pelanggan:</strong> {{ $payment['nama_customer'] ?? 'Umum' }}</p>
                    <p><strong>Tipe:</strong> {{ ucfirst($payment['order_type']) }}</p>
                </div>

                <ul class="nota-list">
                    @foreach($payment['cart'] as $id => $item)
                        <li>
                            <span>{{ $item['nama'] }} <small>x{{ $item['qty'] }}</small></span>
                            <span>Rp{{ number_format($item['harga'] * $item['qty'],0,',','.') }}</span>
                        </li>
                    @endforeach
                </ul>
                <div class="nota-total-wrap">
                    <span class="nota-total">Total: Rp{{ number_format($payment['total'],0,',','.') }}</span>
                </div>
            </div>
        </div>
        
        {{-- Pembayaran --}}
        <div class="card">
            <div class="card-header">
                <span class="header-text">Metode Pembayaran</span>
            </div>
            <div class="card-body">
                <div class="payment-tabs">
                    <button type="button" id="tab-cash" class="active" onclick="showCash()">Cash</button>
                    <button type="button" id="tab-qris" onclick="showQris()">QRIS</button>
                </div>

                {{-- Cash --}}
                <div id="cash-method" style="display:block;">
                    <div>
                        <div class="display-area">
                            <div id="cash-display">Cash: Rp0</div>
                            <div id="change-display">Kembali: Rp0</div>
                        </div>

                        <div class="grid-buttons">
                            @foreach(['1','2','3','4','5','6','7','8','9','00','0','C'] as $b)
                                <button type="button" class="btn {{ $b === 'C' ? 'btn-danger' : '' }}"
                                        onclick="{{ $b === 'C' ? 'clearCash()' : "appendCash('$b')" }}">
                                    {{ $b }}
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <form id="confirm-cash-form" action="{{ route('kasir.payment.process') }}" method="POST">
                        @csrf
                        <input type="hidden" name="metode" value="cash">
                        <input type="hidden" name="bayar" id="input-bayar" value="0">
                       <button type="button" onclick="validateCash()" class="btn-primary">
                            Konfirmasi Pembayaran (Cash)
                        </button>
                    </form>
                </div>

                {{-- QRIS --}}
                <div id="qris-method" style="display:none; text-align:center;">
                    <div>
                        <p>Scan QRIS berikut untuk menyelesaikan pembayaran:</p>
                        <img src="{{ asset('images/qris-cafe.png') }}" alt="QRIS">
                        <p><strong>Total Bayar: Rp{{ number_format($payment['total'],0,',','.') }}</strong></p>
                    </div>

                    <form id="confirm-qris-form" action="{{ route('kasir.payment.process') }}" method="POST">
                        @csrf
                        <input type="hidden" name="metode" value="qris">
                        <button type="submit" class="btn-primary">
                            Konfirmasi Pembayaran (QRIS)
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let cash = 0;
    const total = {{ $payment['total'] }};

    function appendCash(num){
        cash = parseInt(String(cash) + num);
        updateDisplay();
    }
    function clearCash(){
        cash = 0;
        updateDisplay();
    }
    function updateDisplay(){
        document.getElementById('cash-display').textContent = 'Cash: Rp' + cash.toLocaleString('id-ID');
        let change = cash - total;
        document.getElementById('change-display').textContent = 'Kembali: Rp' + (change >= 0 ? change.toLocaleString('id-ID') : 0);
        document.getElementById('input-bayar').value = cash;
    }

    function showCash(){
        document.getElementById('cash-method').style.display = 'flex';
        document.getElementById('qris-method').style.display = 'none';
        document.getElementById('tab-cash').classList.add('active');
        document.getElementById('tab-qris').classList.remove('active');
    }
    function showQris(){
        document.getElementById('qris-method').style.display = 'flex';
        document.getElementById('cash-method').style.display = 'none';
        document.getElementById('tab-qris').classList.add('active');
        document.getElementById('tab-cash').classList.remove('active');
    }

    function validateCash(){
        if(cash <= 0) return alert("Masukkan nominal pembayaran terlebih dahulu.");
        if(cash < total) return alert("Nominal pembayaran kurang dari total.");
        document.getElementById('confirm-cash-form').submit();
    }

    updateDisplay();
</script>
@endsection