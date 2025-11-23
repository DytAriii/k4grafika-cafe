<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Document</title>
    <style>
        /* ====================== VARIABLES ======================= */
        :root {
            --primary-50: #fdf6f2;
            --primary-100: #f9e5db;
            --primary-200: #f3ccb8;
            --primary-300: #e9a98a;
            --primary-400: #dd7f5c;
            --primary-500: #d15e36;
            --primary-600: #a74c29;
            --primary-700: #8a3d23;
            --primary-800: #723322;
            --primary-900: #612c1f;

            --neutral-50: #f9fafb;
            --neutral-100: #f3f4f6;
            --neutral-200: #e5e7eb;
            --neutral-300: #d1d5db;
            --neutral-400: #9ca3af;
            --neutral-500: #6b7280;
            --neutral-600: #4b5563;
            --neutral-700: #374151;
            --neutral-800: #1f2937;
            --neutral-900: #111827;

            --sidebar-width: 260px;
            --sidebar-collapsed: 70px;
            --topbar-height: 70px;
            --transition: all 0.3s ease;
        }

        .topbar {
            height: 60px;
            background: #fff;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            margin: 0px;
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
            font-size: 16px;
            font-weight: 600;
            letter-spacing: 1px;
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            color: var(--neutral-700);
            background: var(--neutral-100);
            padding: 8px 16px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .clock i {
            color: var(--primary-500);
        }

        .profile {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-left: auto;
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

        /* ====================== RESPONSIVE ======================= */
        @media (max-width: 992px) {
            .topbar {
                margin-left: 0;
            }
            
            .mobile-menu-toggle {
                display: flex;
            }
        }

        @media (max-width: 768px) {
            .clock {
                display: none;
            }
            
            .topbar {
                padding: 0 15px;
            }
            
            .topbar-left {
                font-size: 18px;
            }
            
            .topbar-left i {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>

<div class="topbar">
    <div class="topbar-left">
        <span>
            @if(request()->routeIs('admin.dashboard'))
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

    <div id="clock" class="clock">
        <i class="far fa-clock"></i>
        <span>00:00:00</span>
    </div>

    <div class="profile">
        <span>Admin</span>
        <div class="avatar">A</div>
    </div>
</div>

<script>
    function updateClock() {
        const now = new Date();
        const h = String(now.getHours()).padStart(2, '0');
        const m = String(now.getMinutes()).padStart(2, '0');
        const s = String(now.getSeconds()).padStart(2, '0');
        
        // PERBAIKAN: Hanya mengatur teks di span, bukan seluruh konten clock
        const clockSpan = document.getElementById('clock').querySelector('span');
        clockSpan.textContent = `${h}:${m}:${s}`;
    }
    
    setInterval(updateClock, 1000);
    updateClock();
</script>

</body>
</html>