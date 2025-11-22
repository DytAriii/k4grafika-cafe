@extends('admin')

@section('content')
    <div class="laporan-container">
        {{-- Filter dengan Kategori dan Search --}}
        <div class="filter-container">
            <div class="category-container">
                <ul class="category-list">
                    <li><button class="category-btn active" data-period="today">Hari Ini</button></li>
                    <li><button class="category-btn" data-period="week">Minggu Ini</button></li>
                    <li><button class="category-btn" data-period="month">Bulan Ini</button></li>
                    <li><button class="category-btn" data-period="all">Semua</button></li>
                </ul>
            </div>
            <div class="search-container-inline">
                <form class="search-form" id="searchForm">
                    <input type="text" id="searchTransaction" placeholder="Cari invoice/menu..."
                        class="search-input-inline">
                    <button type="submit" class="search-btn-inline">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
        </div>

        {{-- Filter Kasir dan Tombol Aksi --}}
        <div class="laporan-controls">
            <div class="controls">
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

                    <div class="info-item">
                        <span class="info-label">Nama Kasir : </span>
                        <span class="info-value">{{ $laporan['nama'] }}</span>
                    </div>

                    <div class="info-item">
                        <span class="info-label">Jumlah Transaksi:</span>
                        <span class="info-value">{{ $laporan['jumlah_transaksi'] }}</span>
                    </div>

                    <div class="summary-item">
                        <span class="summary-label">Total Pendapatan:</span>
                        <span class="summary-value total-revenue">
                            Rp{{ number_format($laporan['total_pendapatan'], 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="summary-item">
                        <span class="summary-label">Rata-rata per Transaksi:</span>
                        <span class="summary-value">
                            Rp{{ number_format($laporan['rata_rata'], 0, ',', '.') }}
                        </span>
                    </div>

                    <button class="btn btn-export" onclick="exportToPDF()">Export PDF</button>
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
                            <td>{{ $i + 1 }}</td>
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

        {{-- Pagination --}}
        <div class="pagination-wrapper">
            <div class="pagination-info">
                <span>Menampilkan <span id="startItem">1</span> - <span id="endItem">10</span> dari <span
                        id="totalItems">{{ count($laporan['transaksi']) }}</span> transaksi</span>
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
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('searchTransaction');
            const tableBody = document.getElementById('laporanTableBody');
            const rows = Array.from(tableBody.querySelectorAll('tr'));
            const categoryBtns = document.querySelectorAll('.category-btn');

            let filteredRows = [...rows];
            let currentPage = 1;
            const itemsPerPage = 10;
            let currentPeriod = 'today';

            // Category filter handler
            categoryBtns.forEach(btn => {
                btn.addEventListener('click', function () {
                    // Update active state
                    categoryBtns.forEach(b => b.classList.remove('active'));
                    this.classList.add('active');

                    currentPeriod = this.dataset.period;
                    filterByPeriod();
                });
            });

            function filterByPeriod() {
                const now = new Date();
                const today = new Date(now.getFullYear(), now.getMonth(), now.getDate());

                filteredRows = rows.filter(row => {
                    const timeCell = row.cells[5].textContent.trim();
                    const [datePart] = timeCell.split(' ');
                    const [day, month, year] = datePart.split('-');
                    const rowDate = new Date(2000 + parseInt(year), parseInt(month) - 1, parseInt(day));

                    switch (currentPeriod) {
                        case 'today':
                            return rowDate.getTime() === today.getTime();
                        case 'week':
                            const weekAgo = new Date(today);
                            weekAgo.setDate(weekAgo.getDate() - 7);
                            return rowDate >= weekAgo;
                        case 'month':
                            return rowDate.getMonth() === today.getMonth() &&
                                rowDate.getFullYear() === today.getFullYear();
                        case 'all':
                        default:
                            return true;
                    }
                });

                currentPage = 1;
                updateTable();
                updatePagination();
            }

            function filterTable() {
                const searchTerm = searchInput.value.toLowerCase();

                // First filter by period
                filterByPeriod();

                // Then filter by search term
                if (searchTerm) {
                    filteredRows = filteredRows.filter(row => {
                        const invoice = row.cells[1].textContent.toLowerCase();
                        const menu = row.cells[2].textContent.toLowerCase();
                        return invoice.includes(searchTerm) || menu.includes(searchTerm);
                    });
                }

                currentPage = 1;
                updateTable();
                updatePagination();
            }

            // Prevent form submission
            document.getElementById('searchForm').addEventListener('submit', function (e) {
                e.preventDefault();
            });

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