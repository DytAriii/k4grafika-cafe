    @extends('layouts.app')

    @section('content')
    <style>
        body {
            background: #f9f9f9;
        }

        .kasir-container {
            display: flex;
            gap: 20px;
            align-items: stretch;
            padding: 10px 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Bagian kategori */
        .category-list {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 8px;
            padding: 15px;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }

        .category-btn {
            border: 1px solid #A74C29;
            border-radius: 20px;
            padding: 10px 20px;
            font-size: 14px;
            background: #fff;
            color: #A74C29;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .category-btn.active,
        .category-btn:hover {
            background: #A74C29;
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 3px 8px rgba(167, 76, 41, 0.3);
        }

        /* Bagian menu */
        .menu-section {
            flex: 3;
            display: flex;
            flex-direction: column;
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
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 10px;
            border: 1px solid #f0f0f0;
            height: 220px;
        }

        .menu-card img {
            width: 100%;
            height: 140px;
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
            max-height: 350px;
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

        .order-type-buttons input:checked + label {
            background: #A74C29;
            color: #fff;
            border-color: #A74C29;
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
    </style>
    <div class="kasir-container">
    <div class="menu-section">
        <ul class="category-list">
            @foreach($categories as $category)
                <li>
                    <button 
                        class="category-btn {{ $loop->first ? 'active' : '' }}" 
                        data-id="{{ $category->id }}">
                        {{ $category->name }}
                    </button>
                </li>
            @endforeach
        </ul>

        <div class="menu-container" id="menu-container">
            @forelse($menus as $menu)
                <div class="menu-card">
                    <img src="{{ asset('storage/'.$menu->gambar) }}" alt="{{ $menu->nama }}">
                    <div class="menu-info">
                        <div class="menu-title">{{ $menu->nama }}</div>
                        <div class="menu-price">
                            Rp {{ number_format($menu->harga, 0, ',', '.') }}
                        </div>
                        <form action="{{ route('order.add', $menu->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="add-btn">+ Tambah</button>
                        </form>
                    </div>
                </div>
            @empty
                <p>Tidak ada menu tersedia.</p>
            @endforelse
        </div>
    </div>

    {{-- Cart --}}
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
                <form action="{{ route('order.checkout') }}" method="POST">
                    @csrf
                    <label for="nama_customer" class="form-label">Nama Pelanggan:</label>
                    <input type="text" name="nama_customer" id="nama_customer" placeholder="Pelanggan" class="form-control" required>

                    <div class="order-type">
                        <label>Pilih Tipe Pesanan:</label>
                        <div class="order-type-buttons">
                            <input type="radio" id="dine_in" name="order_type" value="dine_in" checked>
                            <label for="dine_in">Dine In</label>
                            <input type="radio" id="take_away" name="order_type" value="take_away">
                            <label for="take_away">Takeaway</label>
                        </div>
                    </div>

                    <div class="cart-summary">
    <div><span>Jumlah Menu:</span><span data-summary="total_items">{{ count(session('cart')) }}</span></div>
    <div><span>Total Porsi:</span><span data-summary="total_qty">{{ array_sum(array_column(session('cart'), 'qty')) }}</span></div>
    <div class="total"><span>Total Bayar:</span>
        <span data-summary="total_price">
            Rp {{ number_format(array_sum(array_map(fn($i) => $i['harga'] * $i['qty'], session('cart'))), 0, ',', '.') }}
        </span>
    </div>
</div>

                    <div style="display:flex; gap:10px; margin-top:12px;">
                        <button type="submit" class="pay-btn" style="flex:2;">Bayar</button>
                </form>
                <form action="{{ route('order.reset') }}" method="POST" style="flex:1;">
                    @csrf
                    <button type="submit" class="reset-btn">Reset</button>
                </form>
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
                        html += `
                            <div class="menu-card">
                                <img src="/storage/${menu.gambar}" alt="${menu.nama}">
                                <div class="menu-info">
                                    <div class="menu-title">${menu.nama}</div>
                                    <div class="menu-price">
                                        Rp ${new Intl.NumberFormat('id-ID').format(menu.harga)}
                                    </div>
                                    <form action="/order/add/${menu.id}" method="POST">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <button type="submit" class="add-btn">+ Tambah</button>
                                    </form>
                                </div>
                            </div>
                        `;
                    });
                }
                $("#menu-container").html(html);
            },
            error: function(xhr) {
                console.error("Gagal load kategori:", xhr.responseText);
            }
        });
    }

    // Saat reload → buka kategori terakhir yang aktif
    let savedCategory = localStorage.getItem("activeCategory");
    if (savedCategory) {
        $(".category-btn").removeClass("active");
        $(`.category-btn[data-id="${savedCategory}"]`).addClass("active");
        loadCategory(savedCategory);
    }
});

// --- Handle add/remove/update cart via AJAX ---
$(document).on("click", "form button[type=submit]", function() {
    $(this).closest("form").find("button[type=submit]").removeAttr("clicked");
    $(this).attr("clicked", "true");
});

$(document).on("submit", ".menu-card form, .cart-item-controls, .cart-item form[action*='remove']", function(e) {
    e.preventDefault();

    let form = $(this);
    let url = form.attr("action");

    let clickedButton = form.find("button[type=submit][clicked=true]");
    let data = form.serialize();

    if (clickedButton.length) {
        data += "&" + clickedButton.attr("name") + "=" + encodeURIComponent(clickedButton.val());
    }

    $.post(url, data, function(res) {
        if (res.success) {
            renderCart(res.cart, res.summary);
        }
    });
});

// --- Render ulang cart ---
function renderCart(cart, summary) {
    let itemsHtml = "";

    if (Object.keys(cart).length === 0) {
        itemsHtml = `<div class="empty-cart"><p>Keranjang masih kosong.</p></div>`;
        $("#cart-footer").hide(); // sembunyikan footer jika kosong
    } else {
        $("#cart-footer").show(); // tampilkan footer
        $.each(cart, function(id, item) {
            itemsHtml += `
                <div class="cart-item">
                    <div style="flex:1">
                        <div class="cart-item-name">${item.nama}</div>
                        <form action="/order/update/${id}" method="POST" class="cart-item-controls">
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
                        <form action="/order/remove/${id}" method="POST">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <button type="submit" class="remove-btn">Hapus</button>
                        </form>
                    </div>
                </div>
            `;
        });

        // --- footer dynamic ---
        let footerHtml = `
            <form action="/order/checkout" method="POST">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <label for="nama_customer" class="form-label">Nama Pelanggan:</label>
                <input type="text" name="nama_customer" id="nama_customer" placeholder="Pelanggan" class="form-control" required>
                <div class="order-type">
                    <label>Pilih Tipe Pesanan:</label>
                    <div class="order-type-buttons">
                        <input type="radio" id="dine_in" name="order_type" value="dine_in" checked>
                        <label for="dine_in">Dine In</label>
                        <input type="radio" id="take_away" name="order_type" value="take_away">
                        <label for="take_away">Takeaway</label>
                    </div>
                </div>
                <div class="cart-summary">
                    <div><span>Jumlah Menu:</span><span data-summary="total_items">${summary.total_items}</span></div>
                    <div><span>Total Porsi:</span><span data-summary="total_qty">${summary.total_qty}</span></div>
                    <div class="total"><span>Total Bayar:</span>
                        <span data-summary="total_price">Rp ${new Intl.NumberFormat('id-ID').format(summary.total_price)}</span>
                    </div>
                </div>
                <div style="display:flex; gap:10px; margin-top:12px;">
                    <button type="submit" class="pay-btn" style="flex:2;">Bayar</button>
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
</script>
    @endsection