@extends('layouts.app')

@section('onoffmenu')
<style>
    .switch {
        position: relative;
        display: inline-block;
        width: 46px;
        height: 24px;
        vertical-align: middle;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .4s;
        border-radius: 24px;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 18px;
        width: 18px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.15);
    }

    input:checked+.slider {
        background-color: #A74C29;
    }

    input:checked+.slider:before {
        transform: translateX(22px);
    }

    .filter-container {
        background: #fff;
        padding: 12px 16px;
        border-radius: 12px;
        margin-bottom: 20px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);

        /* Perbaikan utama ada di sini */
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        /* Jarak antar category-container dan search-container */
    }

    /* Jaga agar kategori tidak terlalu rapat */
    .category-list {
        list-style: none;
        padding: 0;
        margin: 0;
        display: inline-flex;
        flex-wrap: wrap;
        /* Penting agar kategori bisa ke bawah jika layarnya kecil */
        gap: 10px;
        /* Tambah spasi antar tombol kategori */
    }

    /* Biar tombol-tombolnya rapi */
    .category-btn {
        border: 1px solid #A74C29;
        border-radius: 20px;
        padding: 8px 18px;
        font-size: 14px;
        background: #fff;
        color: #A74C29;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        white-space: nowrap;
        /* Mencegah tulisan kategori putus */
    }

    .search-container-inline {
        flex: 0 0 230px;
        /* Lebar search bar dikurangi agar kategori lebih leluasa */
    }

    .search-input-inline {
        flex: 1;
        padding: 8px 12px;
        border: 1px solid #ccc;
        border-radius: 6px 0 0 6px;
        font-size: 14px;
    }

    .search-btn-inline {
        padding: 8px 14px;
        background: #A74C29;
        color: white;
        border: 1px solid #a74c29;
        border-radius: 0 6px 6px 0;
        cursor: pointer;
        font-size: 14px;
    }

    .category-container {
        flex: 1;
        /* kategori biar menyesuaikan isi */
    }

    .search-form {
        display: flex;
        align-items: center;
        width: 100%;
    }

    .category-btn.active,
    .category-btn:hover {
        background: #A74C29;
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 3px 8px rgba(167, 76, 41, 0.3);
    }
</style>

<div class="filter-container">
    <div class="category-container">
        <ul class="category-list">
            <li>
                <button class="category-btn {{ request('category', 'all') == 'all' && !request('search') ? 'active' : '' }}"
                    data-id="all">
                    Semua Kategori
                </button>
            </li>
            @foreach($categories as $category)
            <li>
                <button class="category-btn {{ request('category') == $category->id ? 'active' : '' }}"
                    data-id="{{ $category->id }}">
                    {{ $category->nama_category }}
                </button>
            </li>
            @endforeach
        </ul>
    </div>
    <div class="search-container-inline">
        <form method="GET" action="{{ route('menuhabis') }}" class="search-form" id="search-form">
            <input type="text"
                name="search"
                id="search-input"
                class="search-input-inline"
                placeholder="Cari nama / harga menu"
                value="{{ request('search') }}">
            <button type="submit" id="search-btn" class="search-btn-inline">
                <i class="fas fa-search"></i>
            </button>
        </form>
    </div>
</div>

<form action="{{ route('menuhabis.update') }}" method="POST">
    @csrf
    <div class="table-wrapper">
        <table class="menu-table">
            <thead>
                <tr>
                    <th>Nama Menu</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Gambar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($menu as $mn)
                <tr data-category="{{ $mn->category->id ?? '0' }}">
                    <td>{{ $mn->nama }}</td>
                    <td>{{ $mn->category->nama_category ?? '-' }}</td>
                    <td>Rp{{ number_format($mn->harga, 0, ',', '.') }}</td>
                    <td>
                        <img src="{{ asset('storage/' . $mn->gambar) }}"
                            alt="{{ $mn->nama }}" style="width: 50px; height: 50px; object-fit: cover;">
                    </td>
                    <td class="action-buttons">
                        <label class="switch">
                            <input type="hidden" name="status[{{ $mn->id }}]" value="2">
                            <input type="checkbox"
                                name="status[{{ $mn->id }}]"
                                value="1"
                                {{ $mn->status_id == 1 ? 'checked' : '' }}>
                            <span class="slider"></span>
                        </label>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- <button type="submit" class="btn btn-primary" style="margin-top:16px;">Simpan</button> -->
</form>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Filter berdasarkan kategori + pencarian (client-side)
        const buttons = document.querySelectorAll('.category-btn');
        const rows = document.querySelectorAll('.menu-table tbody tr');
        const searchForm = document.getElementById('search-form');
        const searchInput = document.getElementById('search-input');
        const searchBtn = document.getElementById('search-btn');

        function applyFilters() {
            const activeBtn = document.querySelector('.category-btn.active');
            const activeId = activeBtn ? activeBtn.dataset.id : 'all';
            const q = (searchInput.value || '').trim().toLowerCase();

            rows.forEach(row => {
                const matchesCategory = (activeId === 'all' || row.dataset.category === activeId);
                const name = (row.querySelector('td')?.innerText || '').toLowerCase();
                const price = (row.querySelectorAll('td')[2]?.innerText || '').toLowerCase();
                const matchesSearch = q === '' || name.includes(q) || price.includes(q);

                row.style.display = (matchesCategory && matchesSearch) ? '' : 'none';
            });
        }

        buttons.forEach(btn => {
            btn.addEventListener('click', function() {
                buttons.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                applyFilters();
            });
        });

        // Terapkan filter awal sesuai tombol yang aktif (jika ada)
        const activeBtn = document.querySelector('.category-btn.active');
        if (activeBtn) activeBtn.click();
        // Pastikan filter awal juga mempertimbangkan input search
        applyFilters();

        // Cari saat mengetik
        searchInput.addEventListener('input', function() {
            applyFilters();
        });

        // Cegah form submit reload — tombol search hanya menjalankan filter client-side
        searchForm.addEventListener('submit', function(e) {
            e.preventDefault();
            // jika user mengetik search dan ingin mencari lintas kategori,
            // aktifkan 'all' agar search menampilkan dari semua kategori.
            const q = (searchInput.value || '').trim();
            if (q !== '') {
                buttons.forEach(b => b.classList.remove('active'));
                const allBtn = document.querySelector('.category-btn[data-id="all"]');
                if (allBtn) allBtn.classList.add('active');
            }
            applyFilters();
        });

        // Pastikan klik icon/button juga memicu filter (untuk kompatibilitas)
        if (searchBtn) {
            searchBtn.addEventListener('click', function(e) {
                e.preventDefault();
                const q = (searchInput.value || '').trim();
                if (q !== '') {
                    buttons.forEach(b => b.classList.remove('active'));
                    const allBtn = document.querySelector('.category-btn[data-id="all"]');
                    if (allBtn) allBtn.classList.add('active');
                }
                applyFilters();
            });
        }

        // Konfirmasi saat mengubah status checkbox
        document.querySelectorAll('input[type="checkbox"][name^="status"]').forEach(function(checkbox) {
            checkbox.addEventListener('change', function(e) {
                let isChecked = this.checked;
                let namaMenu = this.closest('tr').querySelector('td').innerText;
                let pesan = isChecked ?
                    `Aktifkan menu "${namaMenu}"?` :
                    `Tandai menu "${namaMenu}" sebagai habis?`;
                if (confirm(pesan)) {
                    this.closest('form').submit();
                } else {
                    // Batalkan perubahan checkbox
                    this.checked = !isChecked;
                }
            });
        });
    });
</script>
@endsection