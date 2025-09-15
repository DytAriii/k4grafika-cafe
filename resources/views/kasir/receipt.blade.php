@extends('layouts.print')
@section('content')
<style>
@media print {
  @page { size: 80mm auto; margin: 3mm; }
  body { font-family: monospace; font-size: 12px; }
}
.receipt { width: 280px; margin: 0 auto; }
.title { text-align:center; font-size:14px; font-weight:bold; }
.subtitle { text-align:center; font-size:12px; margin-bottom:6px; }
.line { border-bottom:1px dashed #000; margin:6px 0; }
.row { display:flex; justify-content:space-between; }
</style>

<div class="receipt">
  <div class="title">☕ Café K4Grafika</div>
  <div class="subtitle">Jl. Tanimbar No.22, Kasin | 0821-3375-3312</div>
  <div class="line"></div>

  <div><strong>Invoice:</strong> {{ $transaksi->invoice }}</div>
  <div><strong>Tanggal:</strong> {{ $transaksi->created_at->format('d/m/Y H:i') }}</div>
  <div><strong>Kasir:</strong> {{ session('users_username') }}</div>
  <div><strong>Customer:</strong> {{ $transaksi->nama_customer ?? '-' }}</div>
  <div class="line"></div>

  {{-- Daftar item --}}
  @foreach($transaksi->details as $d)
    <div class="row">
      <div>{{ $d->menu->nama }} x{{ $d->jumlah }}</div>
      <div>Rp{{ number_format($d->subtotal,0,',','.') }}</div>
    </div>
  @endforeach

  <div class="line"></div>
<div class="row">
  <div><strong>Total</strong></div>
  <div><strong>Rp{{ number_format($transaksi->total,0,',','.') }}</strong></div>
</div>

@if($transaksi->metode_pembayaran == 'cash')
  <div class="row"><div>Bayar</div><div>Rp{{ number_format($transaksi->bayar,0,',','.') }}</div></div>
  <div class="row"><div>Kembali</div><div>Rp{{ number_format($transaksi->kembali,0,',','.') }}</div></div>
@else
  <div class="row"><div>Pembayaran</div><div>Non-Cash</div></div>
@endif

  <div class="line"></div>
  <div class="subtitle">🙏 Terima kasih telah berkunjung 🙏</div>
</div>

<script>
  window.onload = function(){
    window.print();
    setTimeout(function(){
      window.location.href = "{{ route('kasir.order') }}";
    }, 800);
  }
</script>
@endsection
