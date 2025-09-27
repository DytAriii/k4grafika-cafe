<style>
    .topbar {
        height: 60px;
        background: #fff;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        margin: 20px 20px 0;
        border-radius: 8px;
        padding: 0 20px;
        display: flex;
        align-items: center;
        position: sticky;
        top: 20px;
        z-index: 1000;
    }

    .topbar-left {
        font-weight: 700;
        font-size: 18px;
        color: #892A06;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .clock {
        font-size: 18px;
        /* sedikit lebih besar */
        font-weight: 600;
        /* semi-bold, tidak terlalu tebal */
        letter-spacing: 1px;
        /* beri jarak antar digit */
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        color: #333;
        /* lebih netral, cocok dengan tema */
    }

    .profile {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-left: auto;
        /* dorong ke kanan */
    }

    .profile span {
        font-weight: 600;
    }

    .profile .avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #892A06;
        color: #fff;
        font-weight: bold;
        font-size: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>

<div class="topbar">
    <div class="topbar-left">
        <span>
            @if(request()->routeIs('dashboard'))
            Dashboard Admin
            @elseif(request()->routeIs('daftarKasir'))
            Manajemen Kasir
            @elseif(request()->routeIs('manajemenMenu'))
            Manajemen Menu
            @elseif(request()->routeIs('menuhabis'))
            Kelola Menu Habis
            @elseif(request()->routeIs('admin.laporan'))
            Laporan Penjualan
            @else
            Kasir Cafe
            @endif
        </span>
    </div>
    <div id="clock" class="clock"></div>
    <div class="profile">
        <span>{{ session('users_username') }}</span>
        <div class="avatar" id="profile-avatar">
            {{ strtoupper(substr(session('users_username'), 0, 1)) }}
        </div>
    </div>
</div>

<script>
    function updateClock() {
        const now = new Date();
        const h = String(now.getHours()).padStart(2, '0');
        const m = String(now.getMinutes()).padStart(2, '0');
        const s = String(now.getSeconds()).padStart(2, '0');
        document.getElementById('clock').textContent = `${h}:${m}:${s}`;
    }
    setInterval(updateClock, 1000);
    updateClock();
</script>