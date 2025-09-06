<div class="sidebar">
    <div class="sidebar-header">
        <img src="{{ asset('images/logok4cafe.png') }}" alt="Logo K4 Cafe" class="sidebar-logo">
    </div>
    <ul class="sidebar-menu">
        <li>
            <a href="{{ route('dashboard') }}">
                <span class="icon">👓</span> Dashboard
            </a>
        </li>
        <li>
            <a href="{{ route('daftarKasir') }}">
                <span class="icon">👥</span> Daftar Kasir
            </a>
        </li>
        <li>
            <a href="{{ route('manajemenMenu') }}">
                <span class="icon">☰</span> Manajemen Menu
            </a>
        </li>
    </ul>
    <div class="sidebar-footer">
        <a href="{{ route('logout') }}">
            <span class="icon">↪️</span> Logout
        </a>
    </div>
</div>

{{-- panggil file css --}}
<link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">