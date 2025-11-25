# Setup Fitur Export PDF - Laporan Kasir

## Langkah Setup

### 1. Publish Config DomPDF
Jalankan command berikut di terminal:
```bash
php artisan vendor:publish --provider="Barryvdh\DomPDF\ServiceProvider"
```

### 2. Clear Cache (Opsional)
```bash
php artisan config:clear
php artisan cache:clear
```

### 3. Test Fitur
1. Buka halaman laporan kasir: `/admin/laporan-kasir`
2. Pilih kasir dari dropdown
3. Pilih periode (Hari Ini, Minggu Ini, Bulan Ini, atau Semua)
4. Klik tombol "Export PDF"
5. File PDF akan otomatis terdownload

## File yang Dibuat/Dimodifikasi

### 1. Controller: `app/Http/Controllers/LaporanController.php`
**Method baru: `exportPDF()`**
- Mengambil data kasir dan transaksi
- Filter berdasarkan periode yang dipilih
- Generate PDF menggunakan DomPDF
- Download file dengan nama: `Laporan_[NamaKasir]_[Tanggal].pdf`

**Method helper:**
- `filterByPeriod()` - Filter transaksi berdasarkan periode
- `getPeriodLabel()` - Mendapatkan label periode dalam bahasa Indonesia

### 2. View PDF: `resources/views/admin/laporan_pdf.blade.php`
Template PDF dengan styling yang rapi, berisi:
- Header dengan judul laporan
- Info kasir (nama, periode, tanggal cetak)
- Summary box (jumlah transaksi, total pendapatan, rata-rata)
- Tabel detail transaksi
- Footer

### 3. Routes: `routes/web.php`
Route baru:
```php
Route::get('/laporan-kasir/export-pdf', [LaporanController::class, 'exportPDF'])
    ->name('admin.laporan.pdf');
```

### 4. View: `resources/views/admin/laporan_kasir.blade.php`
Update function `exportToPDF()` untuk:
- Mengambil kasir yang dipilih
- Mengambil periode yang aktif
- Redirect ke endpoint export dengan parameter

## Cara Kerja

### Flow Export PDF:
1. User klik tombol "Export PDF"
2. JavaScript mengambil:
   - ID kasir yang dipilih dari dropdown
   - Periode yang aktif (today/week/month/all)
3. Redirect ke route `admin.laporan.pdf` dengan parameter
4. Controller `exportPDF()`:
   - Validasi kasir
   - Ambil data transaksi
   - Filter berdasarkan periode
   - Format data untuk PDF
   - Generate PDF dengan DomPDF
   - Return file untuk download
5. Browser otomatis download file PDF

### Parameter yang Dikirim:
- `kasir` - ID kasir yang dipilih
- `period` - Periode filter (today/week/month/all)

### Format Nama File:
`Laporan_[Username Kasir]_[dd-mm-yyyy].pdf`

Contoh: `Laporan_kasir1_24-11-2025.pdf`

## Fitur PDF

### 1. Header
- Judul: "LAPORAN TRANSAKSI KASIR"
- Subtitle: "Sistem Kasir Restoran"

### 2. Info Section
- Nama Kasir
- Periode laporan
- Tanggal & waktu cetak

### 3. Summary Boxes (Berwarna)
- **Biru**: Jumlah Transaksi
- **Hijau**: Total Pendapatan
- **Orange**: Rata-rata per Transaksi

### 4. Tabel Transaksi
Kolom:
- No (nomor urut)
- Invoice
- Menu (dengan jumlah)
- Metode Pembayaran (dengan badge berwarna)
- Total (format Rupiah)
- Waktu Transaksi

### 5. Footer
- Informasi dokumen otomatis
- Copyright tahun berjalan

## Styling PDF

### Warna Badge Metode Pembayaran:
- **Cash**: Hijau muda (#d4edda)
- **QRIS**: Biru muda (#cce5ff)
- **Debit**: Kuning muda (#fff3cd)

### Layout:
- Paper: A4 Landscape
- Font: Arial
- Responsive table dengan zebra striping
- Professional color scheme

## Troubleshooting

### PDF tidak ter-generate:
1. Pastikan package dompdf sudah terinstall
2. Jalankan `composer dump-autoload`
3. Clear cache Laravel

### Error "Class not found":
```bash
php artisan config:clear
composer dump-autoload
```

### PDF kosong/error:
- Cek apakah ada transaksi untuk kasir tersebut
- Cek log Laravel: `storage/logs/laravel.log`

### Font tidak muncul:
- DomPDF menggunakan font default
- Untuk custom font, tambahkan di config `dompdf.php`

## Kustomisasi

### Mengubah Orientasi PDF:
Di `LaporanController.php`, method `exportPDF()`:
```php
$pdf->setPaper('a4', 'portrait'); // Ubah ke portrait
```

### Menambah Logo:
Di `laporan_pdf.blade.php`, tambahkan di header:
```html
<img src="{{ public_path('images/logo.png') }}" alt="Logo">
```

### Mengubah Warna:
Edit CSS di `laporan_pdf.blade.php`, section `<style>`

## Testing

### Test Case:
1. ✅ Export dengan periode "Hari Ini"
2. ✅ Export dengan periode "Minggu Ini"
3. ✅ Export dengan periode "Bulan Ini"
4. ✅ Export dengan periode "Semua"
5. ✅ Export untuk kasir dengan banyak transaksi
6. ✅ Export untuk kasir tanpa transaksi
7. ✅ Nama file sesuai format
8. ✅ Data di PDF sesuai dengan di web

## Keamanan

- ✅ Validasi kasir ID
- ✅ Hanya kasir yang terdaftar bisa diexport
- ✅ Data difilter per kasir (tidak bisa akses data kasir lain)
- ✅ Parameter di-sanitize oleh Laravel

## Performance

- Query menggunakan Eloquent dengan eager loading (`with()`)
- Filter dilakukan di collection (memory) untuk fleksibilitas
- Untuk data besar (>1000 transaksi), pertimbangkan pagination atau filter di query

## Next Steps (Opsional)

1. Tambah filter tanggal custom
2. Export ke Excel (gunakan `maatwebsite/excel`)
3. Email PDF otomatis ke admin
4. Simpan history export
5. Tambah chart/grafik di PDF
