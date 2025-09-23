@extends('layouts.app')

@section('content')
<style>
  .payment-container {
    gap: 20px;
    box-sizing: border-box;
}
  /* === Payment Page Styles === */
  .nota-info {
    display: flex;
    flex-direction: column;
  }
  .nota-list { 
    list-style: none; 
    padding: 0; 
    margin: 0; 
  }
  .nota-list li {
    display: flex;
    justify-content: space-between;
    padding: 5px 0;
  }
  
  .nota-total-wrap { 
    margin-top: 15px; 
    text-align: right; 
  }
  .nota-total {
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--primary);
    padding: 8px 14px;
    background: var(--primary-light);
    border-radius: var(--radius);
    display: inline-block;
  }

.nota-separator {
  border: none;
  border-top: 1px dashed #A74C29; /* langsung kasih warna di border-top */
  margin: 10px 0;
}

  /* Tabs */
  .payment-tabs { display: flex; gap: 10px; margin-bottom: 16px; }
  .tab-btn { flex: 1; }
  .tab-btn.active {
    background: var(--primary);
    color: #fff;
    box-shadow: var(--shadow);
  }

  /* Display Cash */
  .display-area {
    background: var(--secondary);
    padding: 12px;
    border-radius: var(--radius);
    margin-bottom: 15px;
  }
  #cash-display, #change-display { font-size: 1rem; font-weight: 600; }

  /* Grid Numpad */
  .grid-buttons {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 10px;
  }
  .grid-buttons .btn {
    font-size: 1rem;
    font-weight: 600;
    height: 60px;       /* ukuran standar */
    border-radius: var(--radius);
  }

  /* QRIS */
  .qris-img {
    max-width: 220px;
    border-radius: var(--radius);
    margin: 20px 0;
    box-shadow: var(--shadow);
  }

  /* Layout Grid */
/* Layout Grid */
.grid {
  display: flex;
  gap: 20px;
  align-items: stretch; /* biar semua card sejajar */
}

/* Card */
.grid > .card {
  flex: 1;
  display: flex;
  flex-direction: column;
}

/* Payment method isi ikut penuh */
.payment-method {
  display: none;
  flex-direction: column;
  gap: 15px;
  flex: 1;      /* isi memanjang */
  height: 100%; /* biar tingginya ikut card */
}

.payment-method.show {
  display: flex;
}

</style>

<div class="payment-container">
  <div class="grid">
    {{-- Nota --}}
    <div class="card">
      <h2 class="mb-2">Ringkasan Pesanan</h2>
      <div class="nota-info">
        <p><strong>Pelanggan:</strong> {{ $payment['nama_customer'] ?? 'Umum' }}</p>
@if(!empty($payment['catatan']))
  <p><strong>Catatan:</strong> {{ $payment['catatan'] }}</p>
@endif
      </div>
        <hr class="nota-separator">

      <ul class="nota-list">
        @foreach($payment['cart'] as $id => $item)
          <li>
            <span>{{ $item['nama'] }} <small>x{{ $item['qty'] }}</small></span>
            <span>Rp{{ number_format($item['harga'] * $item['qty'],0,',','.') }}</span>
          </li>
        @endforeach
      </ul>
      <hr class="nota-separator">
      <div class="nota-total-wrap">
        <span class="nota-total">Total: Rp{{ number_format($payment['total'],0,',','.') }}</span>
      </div>
    </div>
    
    {{-- Pembayaran --}}
    <div class="card">
      <h2 class="mb-2">Metode Pembayaran</h2>

      {{-- Tabs --}}
      <div class="payment-tabs">
        <button type="button" id="tab-cash" 
                class="btn btn-secondary tab-btn active" 
                onclick="showCash()">Cash</button>
        <button type="button" id="tab-qris" 
                class="btn btn-secondary tab-btn" 
                onclick="showQris()">QRIS</button>
      </div>

      {{-- Cash --}}
      <div id="cash-method" class="payment-method show">
        <div>
          <div class="display-area">
            <div id="cash-display">Cash: Rp0</div>
            <div id="change-display" style="color: var(--success);">Kembali: Rp0</div>
          </div>

          <div class="grid-buttons">
            @foreach(['1','2','3','4','5','6','7','8','9','00','0','C'] as $b)
              <button type="button" 
                class="btn {{ $b === 'C' ? 'btn-danger' : 'btn-light' }}"
                onclick="{{ $b === 'C' ? 'clearCash()' : "appendCash('$b')" }}">
                {{ $b }}
              </button>
            @endforeach
          </div>
        </div>

        <form id="confirm-cash-form" action="{{ route('kasir.payment.process') }}" method="POST" class="mt-2">
          @csrf
          <input type="hidden" name="metode" value="cash">
          <input type="hidden" name="bayar" id="input-bayar" value="0">
          <button type="button" onclick="validateCash()" class="btn btn-primary w-100">
            Konfirmasi Pembayaran (Cash)
          </button>
        </form>
      </div>

      {{-- QRIS --}}
      <div id="qris-method" class="payment-method">
        <div class="text-center" style="margin-top:auto; margin-bottom:auto;">
          <p>Scan QRIS berikut untuk menyelesaikan pembayaran:</p>
          <img src="{{ asset('images/qris-cafe.png') }}" alt="QRIS" class="qris-img">
          <p><strong>Total Bayar: Rp{{ number_format($payment['total'],0,',','.') }}</strong></p>
        </div>

        <form id="confirm-qris-form" action="{{ route('kasir.payment.process') }}" method="POST" class="mt-2">
          @csrf
          <input type="hidden" name="metode" value="qris">
          <button type="submit" class="btn btn-primary w-100">
            Konfirmasi Pembayaran (QRIS)
          </button>
        </form>
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
        document.getElementById('cash-method').classList.add('show');
        document.getElementById('qris-method').classList.remove('show');
        document.getElementById('tab-cash').classList.add('active');
        document.getElementById('tab-qris').classList.remove('active');
    }
    function showQris(){
        document.getElementById('qris-method').classList.add('show');
        document.getElementById('cash-method').classList.remove('show');
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
