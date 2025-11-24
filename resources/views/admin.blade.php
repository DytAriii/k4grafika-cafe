<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Admin Café</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* Base styles untuk 1366x768 */
        /* RESET */
body {
    margin: 0;
    padding: 0;
    background-color: #f9f9f9;
    display: flex;
    flex-direction: row;
    font-family: sans-serif;
}

/* Sidebar fix width */
.sidebar-container {
    width: 240px;
    flex-shrink: 0;
}

/* Konten menyesuaikan */
.content {
    flex: 1;
    padding: 20px 30px;
    background: #f9f9f9;
    min-height: 100vh;
    box-sizing: border-box;
}
    </style>
    @stack('styles')
</head>

<body>
    <div class="sidebar-container">
        @include('components.admin-sidebar')
    </div>

    <div class="content">
        @include('components.admin-topbar')
        @yield('content')
    </div>
    @stack('scripts')
</body>

</html>