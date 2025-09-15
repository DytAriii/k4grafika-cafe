<div class="sidebar">
    <div class="sidebar-header">
        <img src="{{ asset('images/logok4cafe.png') }}" alt="Logo K4 Cafe" class="sidebar-logo">
    </div>
    <ul class="sidebar-menu">
        <li>
            <a href="{{ route('dashboard') }}">
                <i class="fas fa-tachometer-alt icon"></i> Dashboard
            </a>
        </li>
        <li>
            <a href="{{ route('daftarKasir') }}">
                <i class="fas fa-users icon"></i> Daftar Kasir
            </a>
        </li>
        <li>
            <a href="{{ route('manajemenMenu') }}">
                <i class="fas fa-utensils icon"></i> Manajemen Menu
            </a>
        </li>
    </ul>
    <div class="sidebar-footer">
        <a href="{{ route('logout') }}">
            <i class="fas fa-sign-out-alt icon"></i> Logout
        </a>
    </div>
</div>

{{-- Panggil file CSS --}}
<link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">

{{-- Panggil Font Awesome --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
