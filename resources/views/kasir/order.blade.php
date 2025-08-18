@extends('layouts.app')

@section('content')
<style>
    .menu-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 16px;
        padding: 16px;
    }

    .menu-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: transform 0.2s ease;
        cursor: pointer;
    }

    .menu-card:hover {
        transform: translateY(-4px);
    }

    .menu-card img {
        width: 100%;
        height: 140px;
        object-fit: cover;
    }

    .menu-info {
        padding: 12px;
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .menu-title {
        font-size: 16px;
        font-weight: bold;
        margin-bottom: 4px;
    }

    .menu-price {
        font-size: 14px;
        color: #A74C29;
        font-weight: bold;
    }

    .add-btn {
        background: #A74C29;
        color: #fff;
        border: none;
        border-radius: 6px;
        padding: 6px;
        margin-top: 8px;
        font-size: 14px;
        cursor: pointer;
        transition: background 0.2s;
    }

    .add-btn:hover {
        background: #8C3E22;
    }

    /* kategori */
    .category-list {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 16px;
    }

    .category-btn {
        border: 1px solid #A74C29;
        border-radius: 20px;
        padding: 6px 16px;
        font-size: 14px;
        background: #fff;
        color: #A74C29;
        cursor: pointer;
        transition: all 0.2s;
    }

    .category-btn.active,
    .category-btn:hover {
        background: #A74C29;
        color: #fff;
    }

    .kasir-container {
        display: flex;
        gap: 20px;
    }

    .menu-section {
        flex: 3;
    }

    .cart-section {
        flex: 1;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        display: flex;
        flex-direction: column;
        padding: 16px;
        height: calc(100vh - 120px);
    }

    .cart-title {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 12px;
    }

    .cart-items {
        flex: 1;
        overflow-y: auto;
    }

    .cart-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 0;
        border-bottom: 1px solid #eee;
    }

    .cart-total {
        font-size: 16px;
        font-weight: bold;
        margin: 12px 0;
        text-align: right;
    }

    .pay-btn {
        background: #A74C29;
        color: #fff;
        border: none;
        border-radius: 8px;
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
                    <img src="{{ asset('storage/'.$menu->image) }}" alt="{{ $menu->name }}">
                    <div class="menu-info">
                        <div>
                            <div class="menu-title">{{ $menu->name }}</div>
                            <div class="menu-price">Rp {{ number_format($menu->price, 0, ',', '.') }}</div>
                        </div>
                        <form action="{{ route('order.add', $menu->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="add-btn">Tambah</button>
                        </form>
                    </div>
                </div>
            @empty
                <p>Tidak ada menu tersedia.</p>
            @endforelse
        </div>
    </div>

    <div class="cart-section">
        <div class="cart-title">Keranjang</div>
        <div class="cart-items" id="cart-items">
            <div class="cart-item">
                <span>Cappuccino</span>
                <span>Rp 20.000</span>
            </div>
            <div class="cart-item">
                <span>Snack A</span>
                <span>Rp 15.000</span>
            </div>
        </div>
        <div class="cart-total">Total: Rp 35.000</div>
        <button class="pay-btn">Bayar</button>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(".category-btn").on("click", function() {
        $(".category-btn").removeClass("active");
        $(this).addClass("active");

        let categoryId = $(this).data("id");
        $.get("/order/category/" + categoryId, function(data) {
            let html = "";
            if (data.length === 0) {
                html = "<p>Tidak ada menu tersedia.</p>";
            } else {
                data.forEach(menu => {
                    html += `
                        <div class="menu-card">
                            <img src="/storage/${menu.image}" alt="${menu.name}">
                            <div class="menu-info">
                                <div>
                                    <div class="menu-title">${menu.name}</div>
                                    <div class="menu-price">Rp ${new Intl.NumberFormat('id-ID').format(menu.price)}</div>
                                </div>
                                <form action="/order/add/${menu.id}" method="POST">
                                    @csrf
                                    <button type="submit" class="add-btn">Tambah</button>
                                </form>
                            </div>
                        </div>
                    `;
                });
            }
            $("#menu-container").html(html);
        });
    });
</script>
@endsection
