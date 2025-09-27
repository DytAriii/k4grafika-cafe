@extends('layouts.app')

@section('content')
<style>
body, table, input, select, button {
  font-family: 'Poppins', sans-serif;
  font-size: 14px;
  color: #333;
}

th {
  font-weight: 600; /* bold hanya judul tabel */
}

td {
  font-weight: 400;
}

.text-bold {
  font-weight: 600;
}

/* Samakan tinggi input */
input[type="date"], input[type="text"], select {
  height: 40px;
  font-size: 14px;
  padding: 8px 12px;
  border: 1px solid #ccc;
  border-radius: 8px;
  outline: none;
}

/* Container Filter (Card) */
.filter-box {
  display: flex;
  flex-wrap: wrap;
  gap: 16px;
  align-items: flex-end;
  padding: 16px 20px;
  border: 1px solid #ddd;
  border-radius: 12px;
  background: #fff;
  margin-bottom: 20px;
  box-shadow: 0 2px 6px rgba(0,0,0,0.05);
}

.filter-box div {
  display: flex;
  flex-direction: column;
  min-width: 180px;
  flex: 1;
}

/* Khusus search box: horizontal */
.filter-box .search-box {
  flex-direction: row;
}

/* Label */
.filter-box label {
  font-size: 0.85rem;
  font-weight: 600;
  margin-bottom: 6px;
  color: #444;
}

/* === Dropdown Filter Metode Pembayaran === */
.filter-box select {
  appearance: none;
  -webkit-appearance: none;
  -moz-appearance: none;

  background-color: #fff;
  border: 1px solid #ccc;
  border-radius: 8px;
  height: 40px;
  padding: 8px 38px 8px 12px;
  font-size: 14px;
  color: #333;
  cursor: pointer;
  transition: all 0.2s ease;

  /* custom arrow pakai svg */
  background-image: url("data:image/svg+xml;utf8,<svg fill='%23a74c29' height='20' viewBox='0 0 24 24' width='20' xmlns='http://www.w3.org/2000/svg'><path d='M7 10l5 5 5-5z'/></svg>");
  background-repeat: no-repeat;
  background-position: right 12px center;
  background-size: 18px 18px;
}

.filter-box select:hover {
  border-color: #a74c29;
  box-shadow: 0 0 6px rgba(167, 76, 41, 0.2);
}

.filter-box select:focus {
  border-color: #a74c29;
  outline: none;
  box-shadow: 0 0 6px rgba(167, 76, 41, 0.4);
}

/* Option saat dipilih */
.filter-box select option:checked {
  background: #a74c29;
  color: #fff;
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

/* Wrapper pagination */
.pagination-wrapper nav {
  display: flex;
  justify-content: center;
  margin-top: 20px;
}

.pagination-wrapper nav ul {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 6px;
  list-style: none;
  padding: 0;
  margin: 20px 0;
}

.pagination-wrapper nav ul li {
  margin: 0;
  padding: 0;
}

.pagination-wrapper nav ul li a,
.pagination-wrapper nav ul li span {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 36px;
  height: 36px;
  border: 1px solid #ddd;
  border-radius: 6px;
  font-size: 0.9rem;
  text-decoration: none;
  color: #333;
  transition: all 0.2s;
}

.pagination-wrapper nav ul li span[aria-current="page"] {
  background: #a74c29;
  color: #fff;
  font-weight: bold;
  border-color: #a74c29;
}

.pagination-wrapper nav ul li a:hover {
  background: #f0f0f0;
  border-color: #999;
}

/* Disabled */
.pagination-wrapper nav ul li span[aria-disabled="true"] {
  background: #f8f9fa;
  color: #aaa;
  cursor: not-allowed;
}

.pagination-wrapper nav svg {
  width: 16px;
  height: 16px;
}

/* --- Perbaikan Search Box --- */
.search-box {
  display: flex;
  align-items: center;
  width: 100%;
  max-width: 280px; /* opsional */
}

.search-box input {
  flex: 1;
  height: 40px;
  border: 1px solid #ccc;
  border-right: none;
  border-radius: 8px 0 0 8px;
  padding: 0 12px;
  outline: none;
  font-size: 14px;
}

.search-box button {
  width: 40px;
  height: 40px;
  border: 1px solid #a74c29;
  border-radius: 0 8px 8px 0;
  background: #a74c29;
  color: #fff;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: background 0.2s ease;
}

.search-box button:hover {
  background: #8c3f22;
}

.search-box i {
  font-size: 14px;
}

</style>

<div class="history-container">

<form id="filter-form" class="filter-box" method="GET" action="{{ route('kasir.history') }}">
  <div>
  <label>Cari</label>
  <div class="search-box">
    <input type="text" 
           name="search" 
           placeholder="Cari invoice / pelanggan"
           value="{{ request('search') }}">
    <button type="submit">
      <i class="fa fa-search"></i>
    </button>
  </div>
</div>

  <div>
    <label>Tanggal</label>
    <input type="date" name="date" value="{{ request('date') }}">
  </div>

  <div>
    <label>Metode</label>
    <select name="metode">
  <option value="">Semua</option>
  <option value="cash" {{ request('metode') == 'cash' ? 'selected' : '' }}>Cash</option>
  <option value="qris" {{ request('metode') == 'qris' ? 'selected' : '' }}>QRIS</option>
</select>
  </div>

  <div style="min-width:120px;">
    <button type="submit">Terapkan</button>
  </div>
</form>

  <!-- Tabel Transaksi -->
  <div class="card">
<table id="history-table">
      <thead>
        <tr>
          <th>No</th>
          <th>Invoice</th>
          <th>Pelanggan</th>
          <th>Metode</th>
          <th>Total</th>
          <th>Waktu</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
  @foreach($transaksis as $trx)
  <tr class="trx-row">
    <td>{{ $loop->iteration + ($transaksis->currentPage()-1)*$transaksis->perPage() }}</td>
    <td class="text-bold">{{ $trx->invoice }}</td>
    <td>{{ $trx->nama_customer ?? 'Umum' }}</td>
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
  <tr id="detail{{ $trx->id }}" class="trx-detail" style="display:none;">
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
        @if($trx->catatan)
          <p><strong>Catatan:</strong> {{ $trx->catatan }}</p>
        @endif
      </div>
    </td>
  </tr>
  @endforeach
</tbody>
    </table>
  </div>

  <!-- Pagination -->
  <div class="pagination-wrapper">
        {{ $transaksis->appends(request()->query())->links('vendor.pagination.custom') }}
    </div>
</div>

<script>
function toggleDetail(id) {
  const row = document.getElementById('detail' + id);
  row.style.display = (row.style.display === "table-row") ? "none" : "table-row";
}
function printNota(id) {
window.location.href = '/kasir/print/' + id;
}
// Live search di history
document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.querySelector('input[name="search"]');
    const trxRows = document.querySelectorAll("#history-table tbody tr.trx-row");

    function applySearch() {
        const q = (searchInput.value || "").trim().toLowerCase();

        trxRows.forEach(row => {
            const invoice = (row.querySelector("td:nth-child(2)")?.innerText || "").toLowerCase();
            const customer = (row.querySelector("td:nth-child(3)")?.innerText || "").toLowerCase();
            const metode = (row.querySelector("td:nth-child(4)")?.innerText || "").toLowerCase();
            const total = (row.querySelector("td:nth-child(5)")?.innerText || "").toLowerCase();

            const match = invoice.includes(q) || customer.includes(q) || metode.includes(q) || total.includes(q);

            row.style.display = match ? "" : "none";

            // ikut sembunyikan detailnya
            const detailRow = row.nextElementSibling;
            if (detailRow && detailRow.classList.contains("trx-detail")) {
                if (!match) {
                    detailRow.style.display = "none"; // pastikan tertutup kalau induknya hidden
                }
            }
        });
    }

    if (searchInput) {
        searchInput.addEventListener("input", applySearch);
    }
});
</script>
@endsection