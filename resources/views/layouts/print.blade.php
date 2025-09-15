<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Print</title>
  <style>
    @media print {
      @page { size: 80mm auto; margin: 3mm; }
      body { font-family: monospace; font-size: 12px; }
    }
    body { font-family: monospace; font-size: 12px; margin: 0; padding: 0; }
    .receipt { width: 280px; margin: 0 auto; }
    .title { text-align:center; font-size:14px; font-weight:bold; }
    .subtitle { text-align:center; font-size:12px; margin-bottom:6px; }
    .line { border-bottom:1px dashed #000; margin:6px 0; }
    .row { display:flex; justify-content:space-between; }
  </style>
</head>
<body>
  <div class="receipt">
    @yield('content')
  </div>
</body>
</html>
