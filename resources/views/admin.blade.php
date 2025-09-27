<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Admin Café</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }
    </style>
    @stack('styles')
</head>

<body>
    <div style="display: flex;">
        @include('components.admin-sidebar') <!-- Sidebar tetap ada -->

        
        <div class="content">
            @include('components.admin-topbar') <!-- Topbar tetap ada -->
            @yield('content')
        </div>
        @stack('scripts') <!-- pastikan ada di sini sebelum </body> -->
</body>

</html>