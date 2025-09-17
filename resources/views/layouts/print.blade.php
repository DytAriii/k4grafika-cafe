<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Print</title>
  <style>
    /* Global untuk print */
    @media print {
      @page { 
        size: 80mm auto;   /* bisa diganti 58mm auto kalau pakai printer kecil */
        margin: 3mm; 
      }
      body { 
        font-family: monospace; 
        font-size: 12px; 
        margin: 0;
        padding: 0;
      }
    }

    body { 
      font-family: monospace; 
      font-size: 12px; 
      margin: 0; 
      padding: 0; 
    }

    .receipt { 
      width: 80mm;     /* pastikan sama dengan @page size */
      max-width: 80mm;
      margin: 0 auto; 
    }

    .title { 
      text-align: center; 
      font-size: 14px; 
      font-weight: bold; 
    }

    .subtitle { 
      text-align: center; 
      font-size: 12px; 
      margin-bottom: 6px; 
    }

    .line { 
      border-bottom: 1px dashed #000; 
      margin: 6px 0; 
    }

    .row { 
      display: flex; 
      justify-content: space-between; 
    }
  </style>
</head>
<body>
  <div class="receipt">
    @yield('content')
  </div>
</body>
</html>
