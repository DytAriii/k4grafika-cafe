@extends('layouts.print')
@section('content')

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

  <script>
    window.onload = function(){
      window.print();
      setTimeout(function(){
        window.location.href = "{{ route('kasir.order') }}";
      }, 800);
    }
  </script>

@endsection
