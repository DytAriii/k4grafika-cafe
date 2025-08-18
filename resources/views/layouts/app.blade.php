<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir Café</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="bg-[#FAF9F6] text-gray-800 font-sans">

    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-1/6 bg-white shadow-md p-6 flex flex-col">
            <div class="mb-8 font-bold text-lg text-[#A74C3C]">LOGO</div>
            <nav class="flex flex-col gap-4">
                <a href="#" class="flex items-center gap-2 text-[#A74C3C] font-semibold">
                    <i class="fa fa-cart-shopping"></i> Order
                </a>
                <a href="#" class="flex items-center gap-2 hover:text-[#A74C3C]">
                    <i class="fa fa-clock-rotate-left"></i> History
                </a>
                <a href="#" class="flex items-center gap-2 hover:text-[#A74C3C]">
                    <i class="fa fa-ban"></i> Menu Sold
                </a>
                <a href="#" class="flex items-center gap-2 hover:text-[#A74C3C]">
                    <i class="fa fa-right-from-bracket"></i> Logout
                </a>
            </nav>
        </aside>

        <!-- Main -->
        <main class="flex-1 flex flex-col">
            
            <!-- Topbar -->
            <div class="h-16 bg-white shadow rounded-lg m-4 px-6 flex items-center justify-between">
                
                <!-- Search Bar -->
                <div class="flex items-center bg-gray-100 rounded-lg px-3 py-2 ">
                    <i class="fa fa-search text-gray-500 mr-2"></i>
                    <input type="text" placeholder="Search..." 
                        class="bg-transparent outline-none w-full text-sm">
                </div>

                <!-- Clock -->
                <div id="clock" class="font-bold text-lg"></div>

                <!-- Profile -->
                <div class="flex items-center gap-3">
                    <span class="font-semibold">Sikasir</span>
                    <div class="w-8 h-8 rounded-full bg-gray-300"></div>
                </div>
            </div>

            <!-- Konten Halaman -->
            <div class="flex-1 p-4 overflow-y-auto">
                @yield('content')
            </div>
        </main>
    </div>

    <script>
        // Jam real-time
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
