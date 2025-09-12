@extends('layouts.app')

@section('content')
<style>
    /* ===== THEME COLORS ===== */
    :root {
        --primary: #A74C29; /* utama */
        --primary-dark: #7a341d;
        --light: #f8f5f2;
        --dark: #2c2c2c;
        --danger: #dc3545;
        --success: #28a745;
    }

    /* Hide element */
    .d-none { display: none !important; }

    /* Full page container */
    .page-container { width: 100%; padding: 15px; }

    /* Grid layout */
    .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    .col { width: 100%; }

    @media (max-width: 992px) {
        .grid { grid-template-columns: 1fr; }
    }

    /* Card style */
    .card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.08);
        overflow: hidden;
    }
    .card-header {
        padding: 12px 16px;
        font-weight: bold;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: var(--primary);
        color: #fff;
    }
    .card-body { padding: 16px; }

    /* Nota list */
    .list {
        list-style: none;
        padding: 0;
        margin: 0 0 15px 0;
        border: 1px solid #eee;
        border-radius: 8px;
        overflow: hidden;
    }
    .list-item {
        display: flex;
        justify-content: space-between;
        padding: 10px 12px;
        border-bottom: 1px solid #eee;
        font-size: 15px;
    }
    .list-item:last-child { border-bottom: none; }
    .total {
        border-top: 2px solid #ddd;
        padding-top: 10px;
        font-weight: bold;
        font-size: 18px;
        text-align: right;
        color: var(--primary);
    }

    /* Buttons */
    .btn {
        padding: 10px;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        cursor: pointer;
        margin: 3px;
        transition: 0.2s;
    }
    .btn:hover { opacity: 0.9; }
    .btn-light { background: #f1f1f1; }
    .btn-dark { background: var(--dark); color: #fff; }
    .btn-danger { background: var(--danger); color: #fff; }
    .btn-primary, .btn-success {
        background: var(--primary);
        color: #fff;
        width: 100%;
    }

    /* Grid tombol kalkulator */
    .grid-buttons {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 8px;
        margin-top: 10px;
    }
    .grid-buttons .btn {
        font-size: 18px;
        font-weight: bold;
        padding: 14px;
    }

    /* Helpers */
    .text-muted { color: #888; }
    .text-danger { color: var(--danger); }
    .text-success { color: var(--success); }
    .text-primary { color: var(--primary); }
    .fw-bold { font-weight: bold; }
    .text-center { text-align: center; }
</style>
<div class="page-container">
  <div class="grid">
    {{-- Nota ringkasan (kiri) --}}
    <div class="col">
      <div class="card">
        <div class="card-header">Nota (Sementara)</div>
        <div class="card-body">
          <h5>No.order (sementara)</h5>
          <p><strong>Pelanggan:</strong> {{ $payment['nama_customer'] }}</p>
          <p><strong>Tipe:</strong> {{ $payment['order_type'] }}</p>

          <ul class="list">
            @foreach($payment['cart'] as $id => $item)
              <li class="list-item">
                <span>{{ $item['nama'] }} <small class="text-muted">x{{ $item['qty'] }}</small></span>
                <span>Rp{{ number_format($item['harga'] * $item['qty'],0,',','.') }}</span>
              </li>
            @endforeach
          </ul>

          <div class="total">Total: Rp{{ number_format($payment['total'],0,',','.') }}</div>
        </div>
      </div>
    </div>

    {{-- Payment (kanan) --}}
    <div class="col">
      <div class="card">
        <div class="card-header">
          Pembayaran
          <div>
            <button class="btn btn-light" onclick="showCash()">Cash</button>
            <button class="btn btn-light" onclick="showQris()">QRIS</button>
          </div>
        </div>

        <div class="card-body">
          {{-- CASH --}}
          <div id="cash-method">
            <div id="cash-display">Cash: Rp0</div>
            <div id="change-display">Kembali: Rp0</div>

            <div class="grid-buttons mt-2">
              @foreach(['1','2','3','4','5','6','7','8','9','00','0','C'] as $b)
                <button type="button" class="btn {{ $b === 'C' ? 'btn-danger' : 'btn-dark' }}"
                        onclick="{{ $b === 'C' ? 'clearCash()' : "appendCash('$b')" }}">
                  {{ $b }}
                </button>
              @endforeach
            </div>

            <form id="confirm-cash-form" action="{{ route('kasir.payment.process') }}" method="POST" class="mt-3">
  @csrf
  <input type="hidden" name="metode" value="cash">
  <input type="hidden" name="bayar" id="input-bayar" value="0">
  <button type="button" onclick="validateCash()" class="btn btn-primary">Confirm Payment (Cash)</button>
</form>
          </div>

          {{-- QRIS --}}
          <div id="qris-method" class="d-none">
            <p>Scan QRIS di bawah</p>
            <img src="{{ asset('images/qris-cafe.png') }}" style="max-width:220px;">
            <form id="confirm-qris-form" action="{{ route('kasir.payment.process') }}" method="POST" class="mt-3">
              @csrf
              <input type="hidden" name="metode" value="qris">
              <button type="submit" class="btn btn-primary">Confirm Payment (QRIS)</button>
            </form>
          </div>

        </div>
      </div>
    </div>

  </div>
</div>

<script>
let cash = 0;
const total = {{ $payment['total'] }};

function appendCash(num){
  // bentuk string agar '00' bekerja
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
  document.getElementById('cash-method').classList.remove('d-none');
  document.getElementById('qris-method').classList.add('d-none');
}
function showQris(){
  document.getElementById('qris-method').classList.remove('d-none');
  document.getElementById('cash-method').classList.add('d-none');
}

function validateCash(){
  if(cash <= 0){
    alert("Masukkan nominal pembayaran terlebih dahulu.");
    return;
  }
  if(cash < total){
    alert("Nominal pembayaran tidak boleh kurang dari total.");
    return;
  }
  document.getElementById('confirm-cash-form').submit();
}

// inisialisasi
updateDisplay();
</script>
@endsection
