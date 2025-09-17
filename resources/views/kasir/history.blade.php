@extends('layouts.app')

@section('content')
<style>
  /* Samakan tinggi input */
input[type="date"], input[type="text"], select {
  height: 40px; /* sama dengan padding input global */
}

/* Label status */
.label-text {
  font-size: 0.85rem;
  font-weight: 600;
  text-transform: capitalize;
}
.label-takeaway { color: var(--warning); }
.label-dinein   { color: #2563eb; }
.label-cash     { color: var(--success); }
.label-qris     { color: var(--danger); }

/* Utilitas */
.text-bold { font-weight: 600; }

/* Judul Halaman */
.page-title {
  text-align: center;
  font-size: 1.6rem;
  font-weight: 700;
  margin-bottom: 24px;
  color: #a74c29;
}

/* Container Filter (Card) */
.filter-box {
  display: flex;
  gap: 20px;
  flex-wrap: wrap;
  padding: 16px 20px;
  border: 1px solid #ddd;
  border-radius: 12px;
  background: #fff;
  margin-bottom: 20px;
  box-shadow: 0 2px 6px rgba(0,0,0,0.05);
  align-items: flex-end;
}

/* Elemen Filter */
.filter-box div {
  display: flex;
  flex-direction: column;
  min-width: 180px;
  flex: 1;
}

/* Label */
.filter-box label {
  font-size: 0.85rem;
  font-weight: 600;
  margin-bottom: 6px;
  color: #444;
}

/* === Dropdown Custom Style === */
.filter-box select {
  appearance: none;
  -webkit-appearance: none;
  -moz-appearance: none;
  
  width: 100%;
  padding: 8px 12px;
  font-size: 14px;
  border: 1px solid #ccc;
  border-radius: 8px;
  background-color: #fff;
  color: #333;
  cursor: pointer;
  transition: all 0.2s ease;

  /* custom arrow pakai svg */
  background-image: url("data:image/svg+xml;utf8,<svg fill='%23a74c29' height='24' viewBox='0 0 24 24' width='24' xmlns='http://www.w3.org/2000/svg'><path d='M7 10l5 5 5-5z'/></svg>");
  background-repeat: no-repeat;
  background-position: right 12px center;
  background-size: 18px 18px;
  padding-right: 38px;
}
.filter-box select:hover {
  border-color: #a74c29;
  box-shadow: 0 0 4px rgba(167, 76, 41, 0.2);
}
.filter-box select:focus {
  outline: none;
  border-color: #a74c29;
  box-shadow: 0 0 5px rgba(167, 76, 41, 0.4);
}
.filter-box select option {
  padding: 6px 12px;
}
.filter-box select option:checked {
  background: #a74c29;
  color: #fff;
}

/* Search Box */
.search-box {
  min-width: 220px;
  flex: 1.2;
}
.search-wrapper {
  position: relative;
}
.search-wrapper input {
  width: 100%;
  border: 1px solid #ccc;
  border-radius: 8px;
  outline: none;
  font-size: 0.9rem;
  padding: 8px 8px 8px 34px;
  background-color: #fdfdfd;
}
.search-wrapper input:focus {
  border-color: #a74c29;
  box-shadow: 0 0 0 2px rgba(167, 76, 41, 0.15);
}
.search-wrapper i {
  position: absolute;
  left: 10px;
  top: 50%;
  transform: translateY(-50%);
  color: #888;
  font-size: 0.9rem;
}

/* Tombol Terapkan */
.filter-box button {
  background: #a74c29;
  border: none;
  color: #fff;
  font-weight: 600;
  padding: 10px 14px;
  border-radius: 8px;
  cursor: pointer;
  transition: background 0.2s ease;
}
.filter-box button:hover {
  background: #8c3f22;
}

/* Label teks status */
.label-text {
  font-size: 0.85rem;
  font-weight: 600;
  text-transform: capitalize;
}
.label-takeaway { color: #d97706; }
.label-dinein { color: #2563eb; }
.label-cash { color: #059669; }
.label-qris { color: #dc2626; }

/* Tombol Aksi */
.btn-action-outline {
  font-size: 0.85rem;
  padding: 6px 12px;
  margin-right: 4px;
  border-radius: 6px;
  border: 1px solid;
  background: transparent;
  cursor: pointer;
  transition: all 0.2s;
}
.btn-detail { color: #2563eb; border-color: #93c5fd; }
.btn-detail:hover { background: #eff6ff; }
.btn-print { color: #059669; border-color: #6ee7b7; }
.btn-print:hover { background: #ecfdf5; }

/* Pagination */
.pagination-wrapper {
  display: flex;
  justify-content: center;
  margin-top: 20px;
}
.pagination-wrapper .pagination {
  display: flex;
  gap: 6px;
}
.pagination-wrapper .page-link {
  padding: 6px 12px;
  border-radius: 6px;
  border: 1px solid #ddd;
  background: #fff;
  color: #333;
  font-size: 0.85rem;
  transition: all 0.2s;
}
.pagination-wrapper .page-link:hover {
  background: #f1f1f1;
  border-color: #ccc;
}
.pagination-wrapper .active .page-link {
  background: #a74c29;
  border-color: #a74c29;
  color: #fff;
  font-weight: 600;
}
</style>
<div class="page-app-container">
  <h1 class="page-title">Riwayat Transaksi</h1>

  <!-- Filter + Search -->
  <form id="filter-form" class="filter-box card" method="GET" action="{{ route('kasir.history') }}">
    <!-- Search -->
    <div class="search-box">
      <label for="filter-search">Pencarian</label>
      <div class="search-wrapper">
        <i class="fa fa-search"></i>
        <input type="text" id="filter-search" name="search"
               placeholder="Cari Invoice / Customer"
               value="{{ request('search') }}">
      </div>
    </div>

    <!-- Filter Tanggal -->
    <div>
      <label for="filter-date">Tanggal Transaksi</label>
      <input type="date" id="filter-date" name="date" value="{{ request('date') }}">
    </div>

    <!-- Filter Metode -->
    <div>
      <label for="filter-metode">Metode Pembayaran</label>
      <select id="filter-metode" name="metode">
        <option value="">Semua</option>
        <option value="cash" {{ request('metode')=='cash' ? 'selected' : '' }}>Cash</option>
        <option value="qris" {{ request('metode')=='qris' ? 'selected' : '' }}>Qris</option>
      </select>
    </div>

    <!-- Filter Jenis Pesanan -->
    <div>
      <label for="filter-order">Jenis Pesanan</label>
      <select id="filter-order" name="order">
        <option value="">Semua</option>
        <option value="dine_in" {{ request('order')=='dine_in' ? 'selected' : '' }}>Dine In</option>
        <option value="take_away" {{ request('order')=='take_away' ? 'selected' : '' }}>Takeaway</option>
      </select>
    </div>

    <div>
      <button type="submit" class="btn btn-primary w-100">Terapkan</button>
    </div>
  </form>

  <!-- Tabel Transaksi -->
  <div class="card">
    <table>
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
      <tbody>
        @foreach($transaksis as $trx)
        <tr>
          <td>{{ $loop->iteration + ($transaksis->currentPage()-1)*$transaksis->perPage() }}</td>
          <td class="text-bold">{{ $trx->invoice }}</td>
          <td>{{ $trx->nama_customer ?? 'Umum' }}</td>
          <td>
            <span class="label-text {{ $trx->order_type == 'take_away' ? 'label-takeaway' : 'label-dinein' }}">
              {{ ucwords(str_replace('_',' ',$trx->order_type)) }}
            </span>
          </td>
          <td>
            <span class="label-text {{ $trx->metode_pembayaran == 'cash' ? 'label-cash' : 'label-qris' }}">
              {{ ucfirst($trx->metode_pembayaran) }}
            </span>
          </td>
          <td class="text-bold">Rp{{ number_format($trx->total,0,',','.') }}</td>
          <td>{{ $trx->created_at->format('d/m/Y H:i') }}</td>
          <td>
            <button class="btn-action-outline btn-detail" onclick="toggleDetail({{ $trx->id }})">Detail</button>
            <button class="btn-action-outline btn-print" onclick="printNota({{ $trx->id }})">Print</button>
          </td>
        </tr>
        <tr id="detail{{ $trx->id }}" style="display:none;">
          <td colspan="8">
            <div class="card">
              <h4>Detail Pesanan</h4>
              <ul>
                @foreach($trx->details as $detail)
                  <li>
                    {{ $detail->menu->nama }}
                    <span class="text-muted">x {{ $detail->jumlah }}</span>
                    <span class="text-success">Rp{{ number_format($detail->subtotal,0,',','.') }}</span>
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

  <!-- Pagination -->
  <div class="pagination-wrapper">
    {{ $transaksis->appends(request()->query())->links() }}
  </div>
</div>

<script>
function toggleDetail(id) {
  const row = document.getElementById('detail' + id);
  row.style.display = (row.style.display === "table-row") ? "none" : "table-row";
}
function printNota(id) {
  window.open(`/kasir/print/${id}`, '_blank');
}
</script>
@endsection
