<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Admin</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @stack('styles')
</head>

<body>
    <div style="display: flex;">
        @include('components.admin-sidebar') <!-- Sidebar tetap ada -->

        <div class="content">
            @yield('content')
        </div>
    </div>

    @stack('scripts') <!-- pastikan ada di sini sebelum </body> -->
</body>

</html>