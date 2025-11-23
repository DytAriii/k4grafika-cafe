@extends('admin')

@section('content')
    <div class="menu-container">
        {{-- Controls: Search, Filter, dan Tombol Tambah --}}
        <div class="menu-controls">
            <div class="controls-left">
                <div class="search-box">
                    <input type="text" id="searchMenu" placeholder="Cari menu..." class="search-input">
                    <button type="button" class="search-btn">
                        <i class="fas fa-search"></i>
                    </button>
                </div>

                <div class="filter-box">
                    <select id="categoryFilter" class="filter-select">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->nama_category }}">{{ $category->nama_category }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="filter-box">
                    <select id="statusFilter" class="filter-select">
                        <option value="">Semua Status</option>
                        @foreach($statuses as $status)
                            <option value="{{ $status->nama_status }}">{{ $status->nama_status }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="controls-right">
                <button class="btn btn-add" id="openModal">+ Tambah Menu</button>
            </div>
        </div>

        {{-- Tabel Menu --}}
        <div>
            <div class="table-wrapper">
                <table class="menu-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama menu</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Gambar</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="menuTableBody">
                        @foreach ($menu as $index => $mn)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $mn->nama }}</td>
                                <td>{{ $mn->category->nama_category ?? '-' }}</td>
                                <td>Rp{{ number_format($mn->harga, 0, ',', '.') }}</td>
                                <td>
                                    <img src="{{ asset('storage/' . $mn->gambar) }}" alt="{{ $mn->nama }}" width="70">
                                </td>
                                <td>
                                    <div class="status-col">
                                        <span
                                            class="status-badge status-{{ strtolower(str_replace(' ', '', $mn->status->nama_status ?? 'available')) }}">
                                            {{ $mn->status->nama_status ?? 'Available' }}
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-edit" data-id="{{ $mn->id }}" data-nama="{{ $mn->nama }}"
                                            data-harga="{{ $mn->harga }}" data-category="{{ $mn->categories_id }}"
                                            data-status="{{ $mn->status_id }}"
                                            data-gambar="{{ asset('storage/' . $mn->gambar) }}">
                                            <i class="fas fa-edit"></i>
                                            Edit
                                        </button>

                                        <a href="{{ route('menu.delete', $mn->id) }}"
                                            onclick="return confirm('Yakin ingin menghapus?')" class="btn-delete">
                                            <i class="fas fa-trash"></i>
                                            Hapus
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        <div class="pagination-wrapper">
            <div class="pagination-info">
                <span>Menampilkan <span id="startItem">1</span> - <span id="endItem">10</span> dari <span
                        id="totalItems">{{ count($menu) }}</span> items</span>
            </div>
            <div class="pagination-controls">
                <button class="pagination-btn" id="prevPage" disabled>Previous</button>
                <div class="pagination-numbers" id="paginationNumbers"></div>
                <button class="pagination-btn" id="nextPage">Next</button>
            </div>
        </div>
    </div>

    {{-- Modal Tambah Menu --}}
    <div id="menuModal" class="modal">
        <div class="modal-content">
            <span class="close" id="closeModal">&times;</span>
            <h2>Tambah Menu</h2>

            <form action="{{ route('menu.store') }}" method="POST" enctype="multipart/form-data" class="form-container">
                @csrf
                <div class="form-group">
                    <label>Nama Menu</label>
                    <input type="text" name="nama" required>
                </div>

                <div class="form-row">
                    <div class="form-group half">
                        <label>Category</label>
                        <select name="categories_id" required>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->nama_category }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group half">
                        <label>Harga</label>
                        <input type="number" name="harga" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Foto</label>
                    <input type="file" name="gambar" accept="image/*" required>
                </div>

                <div class="form-group hidden">
                    <select name="status_id" required>
                        @foreach($statuses as $status)
                            <option value="{{ $status->id }}">{{ $status->nama_status }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="button-group">
                    <button type="button" class="btn-batal" id="closeModal2">Batal</button>
                    <button type="submit" class="btn-simpan">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Edit Menu --}}
    <div id="editMenuModal" class="modal">
        <div class="modal-content">
            <span class="close" id="closeEditModal">&times;</span>
            <h2>Edit Menu</h2>

            <form id="editMenuForm" method="POST" enctype="multipart/form-data" class="form-container">
                @csrf
                @method('PATCH')

                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" name="nama" id="editNama" required>
                </div>

                <div class="form-row">
                    <div class="form-group half">
                        <label>Category</label>
                        <select name="categories_id" id="editCategory" required>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->nama_category }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group half">
                        <label>Harga</label>
                        <input type="number" name="harga" id="editHarga" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>Foto</label>
                    <div class="preview-img" id="editPreviewImg"></div>
                    <input type="file" name="gambar" accept="image/*">
                </div>

                <div class="form-group">
                    <label>Status</label>
                    <select name="status_id" id="editStatus" required>
                        @foreach($statuses as $status)
                            <option value="{{ $status->id }}">{{ $status->nama_status }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="button-group">
                    <button type="button" class="btn-batal" id="closeEditModal2">Batal</button>
                    <button type="submit" class="btn-simpan">Update</button>
                </div>
            </form>
        </div>
    </div>

    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('css/manajemenmenu.css') }}">
    <link rel="stylesheet" href="{{ asset('css/create-menu.css') }}">

    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 1100;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background: #fff;
            margin: 5% auto;
            padding: 20px;
            border-radius: 15px;
            width: 50%;
            position: relative;
            animation: fadeIn 0.3s ease-in-out;
        }

        .close {
            position: absolute;
            right: 20px;
            top: 15px;
            font-size: 24px;
            cursor: pointer;
            color: #666;
        }

        .close:hover {
            color: #000;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    {{-- JavaScript --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Modal Elements
            const menuModal = document.getElementById('menuModal');
            const editMenuModal = document.getElementById('editMenuModal');
            const openModalBtn = document.getElementById('openModal');
            const closeModalBtns = document.querySelectorAll('#closeModal, #closeModal2');
            const closeEditModalBtns = document.querySelectorAll('#closeEditModal, #closeEditModal2');
            const editButtons = document.querySelectorAll('.btn-edit');

            // Search, Filter, dan Pagination Elements
            const searchInput = document.getElementById('searchMenu');
            const categoryFilter = document.getElementById('categoryFilter');
            const statusFilter = document.getElementById('statusFilter');
            const tableBody = document.getElementById('menuTableBody');
            const rows = Array.from(tableBody.querySelectorAll('tr'));

            let filteredRows = [...rows];
            let currentPage = 1;
            const itemsPerPage = 10;

            // Modal Functions
            const topbar = document.querySelector('.topbar');

            function openModal(modal) {
                modal.style.display = "block";
                if (topbar) {
                    topbar.style.zIndex = "900";
                }
            }

            function closeModal(modal) {
                modal.style.display = "none";
                if (topbar) {
                    topbar.style.zIndex = "1000";
                }
            }

            // Tambah Menu Modal
            openModalBtn.addEventListener('click', () => openModal(menuModal));
            closeModalBtns.forEach(btn => {
                btn.addEventListener('click', () => closeModal(menuModal));
            });

            // Edit Menu Modal
            editButtons.forEach(btn => {
                btn.addEventListener('click', function () {
                    const id = this.dataset.id;
                    const nama = this.dataset.nama;
                    const harga = this.dataset.harga;
                    const category = this.dataset.category;
                    const status = this.dataset.status;
                    const gambar = this.dataset.gambar;

                    // Isi form
                    document.getElementById('editNama').value = nama;
                    document.getElementById('editHarga').value = harga;
                    document.getElementById('editCategory').value = category;
                    document.getElementById('editStatus').value = status;

                    // Gambar preview
                    const preview = document.getElementById('editPreviewImg');
                    preview.innerHTML = `<img src="${gambar}" width="100" alt="Preview">`;

                    // Update action form
                    document.getElementById('editMenuForm').action = `/admin/${id}/update-menu`;

                    openModal(editMenuModal);
                });
            });

            closeEditModalBtns.forEach(btn => {
                btn.addEventListener('click', () => closeModal(editMenuModal));
            });

            // Close modal ketika klik di luar
            window.addEventListener('click', function (event) {
                if (event.target === menuModal) closeModal(menuModal);
                if (event.target === editMenuModal) closeModal(editMenuModal);
            });

            // Search, Filter, dan Pagination Functions
            function filterTable() {
                const searchTerm = searchInput.value.toLowerCase();
                const selectedCategory = categoryFilter.value.toLowerCase();
                const selectedStatus = statusFilter.value.toLowerCase();

                filteredRows = rows.filter(row => {
                    const menuName = row.cells[1].textContent.toLowerCase();
                    const category = row.cells[2].textContent.toLowerCase();
                    const status = row.cells[5].textContent.toLowerCase();

                    return menuName.includes(searchTerm) &&
                        (selectedCategory === '' || category.includes(selectedCategory)) &&
                        (selectedStatus === '' || status.includes(selectedStatus));
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
                    pageBtn.addEventListener('click', () => {
                        currentPage = i;
                        updateTable();
                        updatePagination();
                    });

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

            // Event listeners untuk search dan filter
            searchInput.addEventListener('input', filterTable);
            categoryFilter.addEventListener('change', filterTable);
            statusFilter.addEventListener('change', filterTable);

            // Initialize
            updateTable();
            updatePagination();
        });
    </script>
@endsection