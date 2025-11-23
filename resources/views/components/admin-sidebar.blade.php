<aside>
    <div class="sidebar">
        <div class="sidebar-header">
            <img src="{{ asset('images/Judul.png') }}" alt="Logo K4 Cafe" class="sidebar-logo">
        </div>

        <ul class="sidebar-menu">
            <li>
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-border-all icon"></i> Dashboard
                </a>
            </li>

            <li>
                <a href="{{ route('daftarKasir') }}" class="{{ request()->routeIs('daftarKasir') ? 'active' : '' }}">
                    <i class="fas fa-users icon"></i> Daftar Kasir
                </a>
            </li>

            <li>
                <a href="{{ route('manajemenMenu') }}" class="{{ request()->routeIs('manajemenMenu') ? 'active' : '' }}">
                    <i class="fas fa-utensils icon"></i> Manajemen Menu
                </a>
            </li>

            <li>
                <a href="{{ route('admin.laporan') }}" class="{{ request()->routeIs('admin.laporan') ? 'active' : '' }}">
                    <i class="fas fa-file-alt icon"></i> Laporan Kasir
                </a>
            </li>
        </ul>

        <div class="sidebar-footer">
            <a href="{{ route('logout') }}">
                <i class="fas fa-sign-out-alt icon"></i> Logout
            </a>
        </div>
    </div>
</aside>

<link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
