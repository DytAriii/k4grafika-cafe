<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Admin Café</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* Base styles untuk 1366x768 */
        body {
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            padding-left: 240px;
        }
        
        .content {
            width: 100%;
            padding: 20px 30px; 
            box-sizing: border-box;
        }
        
        /* Zoom untuk layar 1920x1080 (Full HD) */
        /* Rasio: 1366/1920 = 0.7114 ≈ 71% */
        @media screen and (min-width: 1920px) and (min-height: 1080px) {
            body {
                zoom: 0.711;
                -moz-transform: scale(0.711);
                -moz-transform-origin: 0 0;
            }
        }
        
        /* Untuk layar antara 1367-1919px, gunakan zoom proporsional */
        @media screen and (min-width: 1367px) and (max-width: 1919px) {
            body {
                zoom: calc(1366 / 100vw * 100);
            }
        }
    </style>
    @stack('styles')
</head>

<body>
    <div>
        @include('components.admin-sidebar')
        
        <div class="content">
            @include('components.admin-topbar')
            @yield('content')
        </div>
    </div>
    @stack('scripts')
</body>

</html>