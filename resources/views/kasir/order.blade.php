@extends('layouts.app') 

@section('content')
<style>
body {
    background: #f9f9f9;
}

.kasir-container {
    display: flex;
    gap: 20px;
    height: 100vh; /* Memastikan container mengambil seluruh tinggi viewport */
}

.menu-section {
    flex: 3; /* Atau proporsi yang kamu inginkan */
    overflow-y: auto; /* Memungkinkan menu di-scroll jika isinya terlalu banyak */
}

.cart-section {
    flex: 1; /* Atau proporsi yang kamu inginkan */
    display: flex; /* Mengatur flexbox untuk konten di dalam keranjang */
    flex-direction: column;
    height: 100%; /* Penting: Mengambil tinggi penuh dari parent (kasir-container) */
    background-color: #f9f9f9;
    padding: 15px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.cart-items {
    flex-grow: 1; /* Agar item mengambil seluruh ruang yang tersedia */
    overflow-y: auto; /* Ini yang membuat keranjang bisa di-scroll */
    max-height: calc(100vh - 250px); /* Atur tinggi maksimum, sesuaikan angka 250px */
    /* Angka 250px adalah perkiraan tinggi dari judul keranjang dan footer */
    padding-bottom: 15px; /* Memberikan sedikit ruang di bagian bawah scroll */
}

#cart-footer {
    flex-shrink: 0; /* Mencegah footer mengecil */
    margin-top: auto; /* Mendorong footer ke bagian bawah */
    padding-top: 15px;
    border-top: 1px solid #ccc;
}

.filter-container {
    background: #fff;
    padding: 12px 16px;
    border-radius: 12px;
    margin-bottom: 20px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.05);

    /* Perbaikan utama ada di sini */
    display: flex;
    justify-content: space-between; 
    align-items: center;
    gap: 20px; /* Jarak antar category-container dan search-container */
}

/* Jaga agar kategori tidak terlalu rapat */
.category-list {
    list-style: none;
    padding: 0;
    margin: 0;
    display: inline-flex;
    flex-wrap: wrap; /* Penting agar kategori bisa ke bawah jika layarnya kecil */
    gap: 10px; /* Tambah spasi antar tombol kategori */
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
    white-space: nowrap; /* Mencegah tulisan kategori putus */
}

.search-container-inline {
    flex: 0 0 230px; /* Lebar search bar dikurangi agar kategori lebih leluasa */
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
  flex: 1; /* kategori biar menyesuaikan isi */
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
   
    .menu-section h2 {
        color: #333;
        font-size: 20px;
        margin-bottom: 16px;
        font-weight: 600;
    }

    .menu-container {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
    }

    .menu-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 10px;
        border: 1px solid #f0f0f0;
        height: 245px;
    }

    .menu-card img {
        width: 100%;
        height: 112.8px;
        object-fit: cover;
        border-radius: 8px;
    }

    .menu-info {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-top: 8px;
    }

    .menu-title {
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 4px;
        text-align: center;
        color: #333;
        line-height: 1.2;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .menu-price {
        font-size: 14px;
        color: #A74C29;
        font-weight: bold;
        margin-bottom: 6px;
        text-align: center;
    }

    .add-btn {
        width: 180px;
        background: #A74C29;
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 6px 12px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        display: inline-block;
    }

    .add-btn:hover {
        background: #8C3E22;
        transform: translateY(-1px);
        box-shadow: 0 3px 8px rgba(140, 62, 34, 0.3);
    }

    .cart-title {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 12px;
        color: #A74C29;
        text-align: center;
    }

    .cart-items::-webkit-scrollbar {
        width: 6px;
    }

    .cart-items::-webkit-scrollbar-thumb {
        background: #ccc;
        border-radius: 10px;
    }

    .cart-item {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        padding: 10px 0;
        border-bottom: 1px solid #eee;
        font-size: 14px;
        color: #444;
    }

    .cart-item-name {
        font-weight: 600;
        margin-bottom: 6px;
    }

    .cart-item-controls {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .qty-btn {
        background: #A74C29;
        color: #fff;
        border: none;
        border-radius: 6px;
        padding: 4px 10px;
        font-size: 14px;
        font-weight: bold;
        cursor: pointer;
        transition: 0.2s;
    }

    .qty-btn:hover {
        background: #8C3E22;
    }

    .qty-btn.minus {
        background: #ccc;
        color: #333;
    }

    .qty-btn.minus:hover {
        background: #aaa;
    }

    .qty-display {
        width: 35px;
        text-align: center;
        border: 1px solid #ddd;
        border-radius: 4px;
        background: #f9f9f9;
    }

    .remove-btn {
        background: none;
        border: none;
        color: red;
        cursor: pointer;
        font-size: 13px;
        margin-top: 6px;
    }

    .empty-cart {
        text-align: center;
        color: #999;
        padding: 20px;
        font-style: italic;
    }

    .cart-summary {
        border-top: 1px solid #eee;
        padding-top: 10px;
        margin-top: 10px;
        font-size: 15px;
    }

    .cart-summary div {
        display: flex;
        justify-content: space-between;
        margin-bottom: 6px;
    }

    .cart-summary .total {
        font-size: 16px;
        font-weight: bold;
        color: #222;
    }

    .pay-btn {
        background: #A74C29;
        color: #fff;
        border: none;
        border-radius: 10px;
        padding: 12px;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
        transition: 0.2s;
        width: 100%;
    }

    .pay-btn:hover {
        background: #8C3E22;
    }

    .reset-btn {
        background: #bbb;
        color: #000;
        border: none;
        border-radius: 10px;
        padding: 12px;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
        width: 100%;
    }

    .reset-btn:hover {
        background: #999;
    }

    .form-control {
        width: 100%;
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 6px;
        margin-bottom: 8px;
        box-sizing: border-box;
    }

    .order-type {
        margin: 10px 0;
        font-size: 14px;
        font-weight: 600;
        color: #333;
    }

    .order-type-buttons {
        display: flex;
        gap: 10px;
        margin-top: 6px;
    }

    .form-label {
        font-size: 14px;
        font-weight: 600;
        color: #333;
        margin: 10px 0 6px;
        display: block;
    }

    .order-type-buttons label {
        display: inline-flex;
        align-items: center;
        cursor: pointer;
        border: 1px solid #A74C29;
        border-radius: 8px;
        padding: 8px 16px;
        transition: all 0.2s ease;
        color: #A74C29;
        font-weight: 500;
    }

    .order-type-buttons input {
        display: none;
    }

    .order-type-buttons label:hover {
        background: #f2e2dd;
    }

    .order-type-buttons input:checked+label {
        background: #A74C29;
        color: #fff;
        border-color: #A74C29;
    }

    @media (max-width: 1024px) {
        .menu-container {
            grid-template-columns: repeat(3, 1fr);
        }
    }

.menu-card {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    overflow: hidden;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    align-items: center;
    padding: 10px;
    border: 1px solid #f0f0f0;
    height: 245px; /* konsisten */
}

.menu-card img {
    width: 100%;
    height: 133.8px;
    object-fit: cover;
    border-radius: 8px;
    background: #f5f5f5; /* placeholder bg */
}

.menu-info {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: flex-end;
    flex-grow: 1;
    width: 100%;
}

.menu-title {
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 4px;
    margin-top: 4px;
    text-align: center;
    color: #333;
    line-height: 1.2;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.menu-price {
    font-size: 14px;
    color: #A74C29;
    font-weight: bold;
    margin-bottom: 6px;
    text-align: center;
}

.add-btn {
    width: 180px;
    background: #A74C29;
    color: #fff;
    border: none;
    border-radius: 8px;
    padding: 6px 12px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    display: inline-block;
}

.add-btn:hover {
    background: #8C3E22;
    transform: translateY(-1px);
    box-shadow: 0 3px 8px rgba(140, 62, 34, 0.3);
}

/* Bagian keranjang */
.cart-section {
    flex: 1;
    background: #fff;
    border-radius: 14px;
    box-shadow: 0 3px 8px rgba(0,0,0,0.08);
    display: flex;
    flex-direction: column;
    padding: 16px;
    min-height: 80vh;
}

.cart-title {
    font-size: 18px;
    font-weight: bold;
    margin-bottom: 12px;
    color: #A74C29;
    text-align: center;
}

.cart-items {
    flex: 1;
    overflow-y: auto;
    margin-bottom: 15px;
    max-height: 500px;
}

.cart-items::-webkit-scrollbar {
    width: 6px;
}

.cart-items::-webkit-scrollbar-thumb {
    background: #ccc;
    border-radius: 10px;
}

.cart-item {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    padding: 10px 0;
    border-bottom: 1px solid #eee;
    font-size: 14px;
    color: #444;
}

.cart-item-name {
    font-weight: 600;
    margin-bottom: 6px;
}

.cart-item-controls {
    display: flex;
    align-items: center;
    gap: 6px;
}

.qty-btn {
    background: #A74C29;
    color: #fff;
    border: none;
    border-radius: 6px;
    padding: 4px 10px;
    font-size: 14px;
    font-weight: bold;
    cursor: pointer;
    transition: 0.2s;
}

.qty-btn:hover {
    background: #8C3E22;
}

.qty-btn.minus {
    background: #ccc;
    color: #333;
}

.qty-btn.minus:hover {
    background: #aaa;
}

.qty-display {
    width: 30px;
    height: 26px;  /* kecilkan tinggi */
    font-size: 13px;
    text-align: center;
    border: 1px solid #ddd;
    border-radius: 4px;
    background: #f9f9f9;
    padding: 2px;
}

.remove-btn {
    background: none;
    border: none;
    color: red;
    cursor: pointer;
    font-size: 13px;
    margin-top: 6px;
}

.empty-cart {
    text-align: center;
    color: #999;
    padding: 20px;
    font-style: italic;
}

.cart-summary {
    border-top: 1px solid #eee;
    padding-top: 10px;
    margin-top: 10px;
    font-size: 15px;
}

.cart-summary div {
    display: flex;
    justify-content: space-between;
    margin-bottom: 6px;
}

.cart-summary .total {
    font-size: 16px;
    font-weight: bold;
    color: #222;
}

.pay-btn {
    background: #A74C29;
    color: #fff;
    border: none;
    border-radius: 10px;
    padding: 12px;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
    transition: 0.2s;
    width: 100%;
}

.pay-btn:hover {
    background: #8C3E22;
}

.reset-btn {
    background: #bbb;
    color: #000;
    border: none;
    border-radius: 10px;
    padding: 12px;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
    width: 100%;
}

.reset-btn:hover {
    background: #999;
}

.form-control {
    width: 100%;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 6px;
    margin-bottom: 8px;
    box-sizing: border-box;
}

.form-label {
    font-size: 14px;
    font-weight: 600;
    color: #333;
    margin: 10px 0 6px;
    display: block;
}

@media (max-width: 1024px) {
    .menu-container {
        grid-template-columns: repeat(3, 1fr);
    }
}

@media (max-width: 768px) {
    .menu-container {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 480px) {
    .menu-container {
        grid-template-columns: 1fr;
    }
}

.menu-card.sold-out {
    position: relative;
}

.menu-card.sold-out img {
    filter: grayscale(50%) brightness(20%);
    opacity: 0.7;
}

.menu-card .sold-out-label {
    position: absolute;
    top: 30%;
    left: 50%;
    transform: translate(-50%, -50%);
    color: #fff;
    font-size: 16px;           /* sedikit diperkecil agar muat */
    font-weight: bold;
    padding: 6px 12px;
    border-radius: 8px;
    z-index: 2;
    pointer-events: none;
    text-shadow: 0 2px 6px rgba(0, 0, 0, 0.25);

    /* tambahan agar teks tidak terpisah ke baris baru */
    white-space: nowrap;
    display: inline-block;
    text-align: center;
    box-sizing: border-box;
}
    </style>
<div class="kasir-container">
    <div class="menu-section">
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
                <form method="GET" action="{{ route('kasir.order') }}" class="search-form">
                    <input type="text" 
                           name="search" 
                           class="search-input-inline" 
                           placeholder="Cari nama / harga menu" 
                           value="{{ request('search') }}">
                    <button type="submit" class="search-btn-inline">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
        </div>
        
        {{-- Menu --}}
        <div class="menu-container" id="menu-container">
            @forelse($menus as $menu)
            <div class="menu-card{{ $menu->status_id == 2 ? ' sold-out' : '' }}">
                <img src="{{ asset('storage/'.$menu->gambar) }}" alt="{{ $menu->nama }}">
                @if($menu->status_id == 2)
                <div class="sold-out-label">Menu Habis</div>
                @endif
                <div class="menu-info">
                    <div class="menu-title">{{ $menu->nama }}</div>
                    <div class="menu-price">
                        Rp {{ number_format($menu->harga, 0, ',', '.') }}
                    </div>
                    @if($menu->status_id != 2)
                    <form action="{{ route('order.add', $menu->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="add-btn">+ Tambah</button>
                    </form>
                    @else
                    <button class="add-btn" disabled style="background:#bbb;cursor:not-allowed;">+ Tambah</button>
                    @endif
                </div>
            </div>
            @empty
                <p>Tidak ada menu tersedia.</p>
            @endforelse
        </div>
    </div>
    
    <div class="cart-section">
        <div class="cart-title">Keranjang</div>
        <div class="cart-items">
            @if(session('cart') && count(session('cart')) > 0)
                @foreach(session('cart') as $id => $item)
                    <div class="cart-item">
                        <div style="flex:1">
                            <div class="cart-item-name">{{ $item['nama'] }}</div>
                            <form action="{{ route('order.update', $id) }}" method="POST" class="cart-item-controls">
                                @csrf
                                <button type="submit" name="qty" value="{{ $item['qty'] - 1 }}" class="qty-btn minus" {{ $item['qty'] <= 1 ? 'disabled' : '' }}>-</button>
                                <input type="text" value="{{ $item['qty'] }}" readonly class="qty-display">
                                <button type="submit" name="qty" value="{{ $item['qty'] + 1 }}" class="qty-btn">+</button>
                            </form>
                        </div>
                        <div style="text-align:right; min-width:100px;">
                            <div>Rp {{ number_format($item['harga'], 0, ',', '.') }}</div>
                            <div style="font-size:13px; color:#666;">
                                Subtotal: Rp {{ number_format($item['harga'] * $item['qty'], 0, ',', '.') }}
                            </div>
                            <form action="{{ route('order.remove', $id) }}" method="POST">
                                @csrf
                                <button type="submit" class="remove-btn">Hapus</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="empty-cart"><p>Keranjang masih kosong.</p></div>
            @endif
        </div>
        
        <div id="cart-footer">
    @if(session('cart') && count(session('cart')) > 0)
        <label for="nama_customer" class="form-label">Nama Pelanggan:</label>
        <input type="text" name="nama_customer" id="nama_customer" placeholder="Pelanggan" class="form-control" required>
        
        <div class="form-group" style="margin-top:12px;">
            <label for="catatan" class="form-label">Catatan Pesanan (Opsional):</label>
            <textarea name="catatan" id="catatan" class="form-control" rows="2" placeholder="Contoh: tanpa gula, pedas sedang, es sedikit"></textarea>
        </div>
        
        <div class="cart-summary" style="margin-top:12px;">
            <div><span>Jumlah Menu:</span><span data-summary="total_items">{{ count(session('cart')) }}</span></div>
            <div><span>Total Porsi:</span><span data-summary="total_qty">{{ array_sum(array_column(session('cart'), 'qty')) }}</span></div>
            <div class="total" style="margin-top:6px;"><span>Total Bayar:</span>
                <span data-summary="total_price">
                    Rp {{ number_format(array_sum(array_map(fn($i) => $i['harga'] * $i['qty'], session('cart'))), 0, ',', '.') }}
                </span>
            </div>
        </div>
        
        <div style="display:flex; gap:10px; margin-top:12px;">
            <form action="{{ route('order.checkout') }}" method="POST" style="flex:3;">
                @csrf
                <button type="submit" class="pay-btn">Bayar</button>
            </form>
            <form action="{{ route('order.reset') }}" method="POST" style="flex:1;">
                @csrf
                <button type="submit" class="reset-btn">Reset</button>
            </form>
        </div>
    @endif
</div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function () {
    // Klik kategori → simpan ke localStorage
    $(".category-btn").on("click", function(e) {
        e.preventDefault();
        $(".category-btn").removeClass("active");
        $(this).addClass("active");

        let kategoriId = $(this).data("id");
        localStorage.setItem("activeCategory", kategoriId);
        loadCategory(kategoriId);
    });
    
    // Fungsi load menu by kategori
    function loadCategory(kategoriId) {
        $.ajax({
            url: "/order/category/" + kategoriId,
            method: "GET",
            success: function(data) {
                let html = "";
                if (data.length === 0) {
                    html = "<p>Tidak ada menu tersedia.</p>";
                } else {
                    data.forEach(menu => {
                        let soldOutClass = menu.status_id == 2 ? " sold-out" : "";
                        let soldOutLabel = menu.status_id == 2 ? `<div class="sold-out-label">Menu Habis</div>` : "";
                        let addButton = "";
                        if (menu.status_id != 2) {
                            addButton = `
                                <form action="/order/add/${menu.id}" method="POST">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <button type="submit" class="add-btn">+ Tambah</button>
                                </form>
                            `;
                        } else {
                            addButton = `<button class="add-btn" disabled style="background:#bbb;cursor:not-allowed;">+ Tambah</button>`;
                        }

                            html += `
                                <div class="menu-card${soldOutClass}">
                                    <img src="/storage/${menu.gambar}" alt="${menu.nama}">
                                    ${soldOutLabel}
                                    <div class="menu-info">
                                        <div class="menu-title">${menu.nama}</div>
                                        <div class="menu-price">
                                            Rp ${new Intl.NumberFormat('id-ID').format(menu.harga)}
                                        </div>
                                        ${addButton}
                                    </div>
                                </div>
                            `;
                        });
                    }
                    $("#menu-container").html(html);
                }
            });
        }

        // Restore kategori atau search
        let currentSearch = "{{ request('search') }}";
        if (!currentSearch) {
            let savedCategory = localStorage.getItem("activeCategory") || "all";
            $(".category-btn").removeClass("active");
            $(`.category-btn[data-id="${savedCategory}"]`).addClass("active");
            loadCategory(savedCategory);
        }

        // Handler untuk semua form di menu/cart (delegasi)
        $(document).on("submit", ".ajax-form, .cart-item form", function(e) {
            let form = $(this);

            // Kalau checkout atau reset → biarkan normal (redirect server)
if (form.attr("action").includes("/order/checkout") || form.attr("action").includes("/order/reset")) {
    return; 
}
            e.preventDefault(); // hanya intercept selain checkout dan reset

            let url = form.attr("action");
            let data = form.serialize();

            let btn = form.find("button[type=submit]:focus");
            if (btn.length) {
                data += "&" + btn.attr("name") + "=" + encodeURIComponent(btn.val());
            }

            $.post(url, data, function(res) {
                if (res.success) {
                    renderCart(res.cart, res.summary);
                }
            });
        });

        // Render cart
        // Render cart
function renderCart(cart, summary) {
    let itemsHtml = "";
    let savedCustomer = $("#nama_customer").val() || "";
    let savedCatatan = $("#catatan").val() || "";

    if (Object.keys(cart).length === 0) {
        itemsHtml = `<div class="empty-cart"><p>Keranjang masih kosong.</p></div>`;
        $("#cart-footer").html("");
    } else {
        $.each(cart, function(id, item) {
            itemsHtml += `
                <div class="cart-item">
                    <div style="flex:1">
                        <div class="cart-item-name">${item.nama}</div>
                        <form action="/order/update/${id}" method="POST" class="ajax-form cart-item-controls">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <button type="submit" name="qty" value="${item.qty - 1}" class="qty-btn minus" ${item.qty <= 1 ? 'disabled' : ''}>-</button>
                            <input type="text" value="${item.qty}" readonly class="qty-display">
                            <button type="submit" name="qty" value="${item.qty + 1}" class="qty-btn">+</button>
                        </form>
                    </div>
                    <div style="text-align:right; min-width:100px;">
                        <div>Rp ${new Intl.NumberFormat('id-ID').format(item.harga)}</div>
                        <div style="font-size:13px; color:#666;">
                            Subtotal: Rp ${new Intl.NumberFormat('id-ID').format(item.subtotal)}
                        </div>
                        <form action="/order/remove/${id}" method="POST" class="ajax-form">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <button type="submit" class="remove-btn">Hapus</button>
                        </form>
                    </div>
                </div>
            `;
        });

        // Bagian ini yang perlu diperbaiki
        let footerHtml = `
            <label for="nama_customer" class="form-label">Nama Pelanggan:</label>
            <input type="text" name="nama_customer" id="nama_customer" placeholder="Pelanggan" class="form-control" required value="${savedCustomer}">
            
            <div class="form-group" style="margin-top:12px;">
                <label for="catatan" class="form-label">Catatan Pesanan (Opsional):</label>
                <textarea name="catatan" id="catatan" class="form-control" rows="2" placeholder="Contoh: tanpa gula, pedas sedang, es sedikit">${savedCatatan}</textarea>
            </div>
            
            <div class="cart-summary" style="margin-top:12px;">
                <div><span>Jumlah Menu:</span><span>${summary.total_items}</span></div>
                <div><span>Total Porsi:</span><span>${summary.total_qty}</span></div>
                <div class="total" style="margin-top:6px;"><span>Total Bayar:</span>
                    <span>Rp ${new Intl.NumberFormat('id-ID').format(summary.total_price)}</span>
                </div>
            </div>
            
            <div style="display:flex; gap:10px; margin-top:12px;">
                <form action="/order/checkout" method="POST" style="flex:3;">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <button type="submit" class="pay-btn">Bayar</button>
                </form>
                <form action="/order/reset" method="POST" style="flex:1;">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <button type="submit" class="reset-btn">Reset</button>
                </form>
            </div>
        `;
        
        $("#cart-footer").html(footerHtml);
    }
    
    $(".cart-items").html(itemsHtml);
}
    });
</script>
@endsection