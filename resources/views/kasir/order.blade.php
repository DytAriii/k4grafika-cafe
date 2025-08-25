@extends('layouts.app')

@section('content')
<style>
    body {
        background: #f9f9f9;
    }

    .kasir-container {
        display: flex;
        gap: 20px;
        align-items: stretch; /* agar keranjang sama tinggi dengan menu */
    }

    /* Bagian kategori */
    .category-list {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 20px;
    }

    .category-btn {
        border: 1px solid #A74C29;
        border-radius: 20px;
        padding: 8px 18px;
        font-size: 14px;
        background: #fff;
        color: #A74C29;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
    }

    .category-btn.active,
    .category-btn:hover {
        background: #A74C29;
        color: #fff;
    }

    /* Bagian menu */
    .menu-section {
        flex: 3;
        display: flex;
        flex-direction: column;
    }

    .menu-container {
        display: grid;
        grid-template-columns: repeat(4, 1fr); /* fix 4 card per baris */
        gap: 18px;
    }

    .menu-card {
        background: #fff;
        border-radius: 14px;
        box-shadow: 0 3px 8px rgba(0,0,0,0.08);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .menu-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 12px rgba(0,0,0,0.12);
    }

    .menu-card img {
        width: 100%;
        height: 150px;
        object-fit: cover;
    }

    .menu-info {
        padding: 12px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        flex: 1;
    }

    .menu-title {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 6px;
        text-align: center;
        color: #333;
    }

    .menu-price {
        font-size: 14px;
        color: #A74C29;
        font-weight: bold;
        text-align: center;
        margin-bottom: 8px;
    }

    .add-btn {
        background: #A74C29;
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 8px;
        font-size: 14px;
        cursor: pointer;
        transition: background 0.2s;
        width: 100%;
    }

    .add-btn:hover {
        background: #8C3E22;
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
    }

    .cart-title {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 12px;
        color: #333;
        text-align: center;
    }

    .cart-items {
        flex: 1;
        overflow-y: auto;
        padding-right: 6px;
    }

    .cart-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 0;
        border-bottom: 1px solid #eee;
        font-size: 14px;
        color: #444;
    }

    .cart-total {
        font-size: 16px;
        font-weight: bold;
        margin: 12px 0;
        text-align: right;
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
        transition: background 0.2s;
        width: 100%;
    }

    .pay-btn:hover {
        background: #8C3E22;
    }
</style>

<div class="kasir-container">
    <!-- Bagian Menu -->
    <div class="menu-section">
        <h2 class="mb-4">Pilih Menu</h2>
        
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
                        <div class="menu-price">Rp {{ number_format($menu->harga, 0, ',', '.') }}</div>
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

    <!-- Bagian Keranjang -->
    <div class="cart-section">
        <div class="cart-title">Keranjang</div>
        <div class="cart-items" id="cart-items">
            <p>Keranjang masih kosong.</p>
        </div>
        <div class="cart-total">Total: Rp 0</div>
        <button class="pay-btn">Bayar</button>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $(".category-btn").on("click", function(e) {
            e.preventDefault();
            $(".category-btn").removeClass("active");
            $(this).addClass("active");

            let kategoriId = $(this).data("id");

            $.get("/order/category/" + kategoriId, function(data) {
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
                                    <div class="menu-price">Rp ${new Intl.NumberFormat('id-ID').format(menu.harga)}</div>
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
            });
        });
    });
</script>
@endsection
