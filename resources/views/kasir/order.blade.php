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

    /* kategori pill */
    .nav-pills .nav-link.active {
        background-color: #A74C29;
    }
</style>

<div class="container-fluid">
    <h2 class="mb-4">Pilih Menu</h2>

    {{-- Kategori --}}
    <ul class="nav nav-pills mb-3">
        @foreach($categories as $category)
            <li class="nav-item">
                <button 
                    class="nav-link category-btn {{ $loop->first ? 'active' : '' }}"
                    data-id="{{ $category->id }}">
                    {{ $category->name }}
                </button>
            </li>
        @endforeach
    </ul>

    {{-- Daftar Menu --}}
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

{{-- Script AJAX untuk ganti kategori --}}
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
