@extends('admin')

@section('content')
<div class="laporan-container">
    

    {{-- Filter dan Info --}}
    <div class="laporan-controls">
        <div class="controls-left">
            <div class="filter-box">
                <form method="GET" action="{{ route('admin.laporan') }}">
                    <label for="kasir" class="filter-label">Pilih Kasir:</label>
                    <select name="kasir" id="kasir" class="filter-select" onchange="this.form.submit()">
                        @foreach($kasirs as $id => $nama)
                            <option value="{{ $id }}" {{ $id == $selectedKasir ? 'selected' : '' }}>
                                {{ $nama }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>

            <div class="search-box">
                <input type="text" id="searchTransaction" placeholder="Cari invoice/menu..." class="search-input">
                <i class="search-icon">🔍</i>
            </div>
        </div>

        <div class="controls-right">
            <button class="btn btn-export" onclick="exportToPDF()">📄 Export PDF</button>
            <button class="btn btn-print" onclick="window.print()">🖨️ Print</button>
        </div>
    </div>

    {{-- Info Kasir --}}
    <div class="kasir-info-card">
        <div class="info-row">
            <div class="info-item">
                <span class="info-label">Nama Kasir:</span>
                <span class="info-value">{{ $laporan['nama'] }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Jam Kerja:</span>
                <span class="info-value">{{ $laporan['jam_kerja'] }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Jumlah Transaksi:</span>
                <span class="info-value badge-count">{{ $laporan['jumlah_transaksi'] }}</span>
            </div>
        </div>
    </div>

    {{-- Tabel Laporan --}}
    <div class="table-wrapper">
        <table class="laporan-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Invoice</th>
                    <th>Menu</th>
                    <th>Metode Pembayaran</th>
                    <th>Total</th>
                    <th>Waktu Transaksi</th>
                </tr>
            </thead>
            <tbody id="laporanTableBody">
                @foreach($laporan['transaksi'] as $i => $trx)
                    <tr>
                        <td>{{ $i+1 }}</td>
                        <td class="invoice-cell">{{ $trx['invoice'] }}</td>
                        <td class="menu-cell">{{ $trx['menu'] }}</td>
                        <td>
                            <span class="payment-badge payment-{{ strtolower($trx['metode']) }}">
                                {{ $trx['metode'] }}
                            </span>
                        </td>
                        <td class="total-cell">{{ $trx['total'] }}</td>
                        <td class="time-cell">{{ $trx['waktu'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Summary --}}
    <div class="summary-card">
        <div class="summary-row">
            <div class="summary-item">
                <span class="summary-label">Total Pendapatan:</span>
                <span class="summary-value total-revenue">
                    Rp{{ number_format(array_sum(array_map(function($trx) { 
                        return (int) str_replace(['Rp', '.', ' '], '', $trx['total']); 
                    }, $laporan['transaksi'])), 0, ',', '.') }}
                </span>
            </div>
            <div class="summary-item">
                <span class="summary-label">Rata-rata per Transaksi:</span>
                <span class="summary-value">
                    Rp{{ $laporan['jumlah_transaksi'] > 0 ? 
                        number_format(array_sum(array_map(function($trx) { 
                            return (int) str_replace(['Rp', '.', ' '], '', $trx['total']); 
                        }, $laporan['transaksi'])) / $laporan['jumlah_transaksi'], 0, ',', '.') 
                        : '0' }}
                </span>
            </div>
        </div>
    </div>

    {{-- Pagination --}}
    <div class="pagination-wrapper">
        <div class="pagination-info">
            <span>Menampilkan <span id="startItem">1</span> - <span id="endItem">10</span> dari <span id="totalItems">{{ count($laporan['transaksi']) }}</span> transaksi</span>
        </div>
        <div class="pagination-controls">
            <button class="pagination-btn" id="prevPage" disabled>Previous</button>
            <div class="pagination-numbers" id="paginationNumbers"></div>
            <button class="pagination-btn" id="nextPage">Next</button>
        </div>
    </div>
</div>

{{-- CSS --}}
<link rel="stylesheet" href="{{ asset('css/laporan.css') }}">

{{-- JavaScript --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchTransaction');
    const tableBody = document.getElementById('laporanTableBody');
    const rows = Array.from(tableBody.querySelectorAll('tr'));
    
    let filteredRows = [...rows];
    let currentPage = 1;
    const itemsPerPage = 10;

    function filterTable() {
        const searchTerm = searchInput.value.toLowerCase();

        filteredRows = rows.filter(row => {
            const invoice = row.cells[1].textContent.toLowerCase();
            const menu = row.cells[2].textContent.toLowerCase();

            return invoice.includes(searchTerm) || menu.includes(searchTerm);
        });

        currentPage = 1;
        updateTable();
        updatePagination();
    }

    function updateTable() {
        // Hide all rows
        rows.forEach(row => row.style.display = 'none');

        // Show filtered rows for current page
        const startIndex = (currentPage - 1) * itemsPerPage;
        const endIndex = startIndex + itemsPerPage;
        const currentRows = filteredRows.slice(startIndex, endIndex);

        currentRows.forEach((row, index) => {
            row.style.display = '';
            // Update numbering
            row.cells[0].textContent = startIndex + index + 1;
        });

        // Update pagination info
        const totalItems = filteredRows.length;
        const startItem = totalItems > 0 ? startIndex + 1 : 0;
        const endItem = Math.min(endIndex, totalItems);
        
        document.getElementById('startItem').textContent = startItem;
        document.getElementById('endItem').textContent = endItem;
        document.getElementById('totalItems').textContent = totalItems;
    }

    function updatePagination() {
        const totalPages = Math.ceil(filteredRows.length / itemsPerPage);
        const paginationNumbers = document.getElementById('paginationNumbers');
        const prevBtn = document.getElementById('prevPage');
        const nextBtn = document.getElementById('nextPage');

        // Clear pagination numbers
        paginationNumbers.innerHTML = '';

        // Create page numbers
        for (let i = 1; i <= totalPages; i++) {
            const pageBtn = document.createElement('button');
            pageBtn.className = 'pagination-number';
            pageBtn.textContent = i;
            pageBtn.onclick = () => {
                currentPage = i;
                updateTable();
                updatePagination();
            };
            
            if (i === currentPage) {
                pageBtn.classList.add('active');
            }
            
            paginationNumbers.appendChild(pageBtn);
        }

        // Update prev/next buttons
        prevBtn.disabled = currentPage === 1;
        nextBtn.disabled = currentPage === totalPages || totalPages === 0;

        prevBtn.onclick = () => {
            if (currentPage > 1) {
                currentPage--;
                updateTable();
                updatePagination();
            }
        };

        nextBtn.onclick = () => {
            if (currentPage < totalPages) {
                currentPage++;
                updateTable();
                updatePagination();
            }
        };
    }

    // Event listeners
    searchInput.addEventListener('input', filterTable);

    // Initialize
    updateTable();
    updatePagination();
});

function exportToPDF() {
    alert('Fitur export PDF akan segera tersedia');
}
</script>
@endsection