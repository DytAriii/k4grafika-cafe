<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir Café</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #FAF9F6;
            color: #333;
        }

        ul, li {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .container {
            display: flex;
            height: 100vh;
        }

        /* Sidebar */
        aside {
            width: 80px;
            background: #fff;
            box-shadow: 2px 0 6px rgba(0,0,0,0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px 0;
        }

        .logo img {
            width: 70px;     
            height: auto;
            display: block;
            margin: 0 auto 40px auto;
        }

        nav {
            display: flex;
            flex-direction: column;
            gap: 20px;
            width: 100%;
            align-items: center;
            flex: 1;
        }

        nav a {
            text-decoration: none;
            color: #555;
            font-size: 12px;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 10px 0;
            width: 100%;
            transition: 0.2s;
        }

        nav a i {
            font-size: 18px;
            margin-bottom: 5px;
        }

        nav a:hover {
            color: #A74C3C;
        }

        nav a.active {
            background: #A74C3C;
            color: #fff;
            border-radius: 8px;
            width: 60px;
        }

        nav a.logout {
            margin-top: auto;
            color: #555;
        }

        nav a.logout:hover {
            color: #A74C3C;
        }

        nav a.logout.active {
            background: #A74C3C;
            color: #fff;
            border-radius: 8px;
        }

        /* Main */
        main {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .topbar {
            height: 60px;
            background: #fff;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            margin: 10px;
            border-radius: 8px;
            padding: 0 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .search-bar {
            display: flex;
            align-items: center;
            background: #f3f3f3;
            border-radius: 6px;
            padding: 6px 10px;
        }

        .search-bar input {
            border: none;
            outline: none;
            background: transparent;
            font-size: 14px;
        }

        .clock {
            font-weight: bold;
            font-size: 16px;
        }

        .profile {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .profile span {
            font-weight: 600;
        }

        .profile .avatar {
            width: 32px;
            height: 32px;
            background: #ccc;
            border-radius: 50%;
        }

        .content {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <aside>
            <div class="logo">
                <img src="/images/logok4cafe.png" alt="Logo">
            </div>
            <nav>
                <a href="{{ route('kasir.order') }}" class="active">
                    <i class="fa-solid fa-utensils"></i>
                    <span>Order</span>
                </a>
                <a href="#">
                    <i class="fa fa-clock-rotate-left"></i>
                    <span>Riwayat</span>
                </a>
                <a href="{{ route('menuhabis') }}">
                    <i class="fa-solid fa-circle-xmark"></i>
                    <span>Menu Habis</span>
                </a>
                <a href="{{ route('logout') }}" class="logout">
                    <i class="fa fa-right-from-bracket"></i>
                    <span>Keluar</span>
                </a>
            </nav>
        </aside>

        <!-- Main -->
        <main>
            <div class="topbar">
                <div class="search-bar">
                    <i class="fa fa-search" style="color: #777; margin-right: 6px;"></i>
                    <input type="text" placeholder="Cari...">
                </div>
                <div id="clock" class="clock"></div>
                <div class="profile">
                    <span>Sikasir</span>
                    <div class="avatar"></div>
                </div>
            </div>

            <div class="content">
                @yield('content')
                @yield('onoffmenu')
            </div>
        </main>
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
</body>
</html>