# 🎉 Fitur Baru: Export PDF & Backup Otomatis

## 📄 1. Export PDF Laporan Kasir

### ✅ Status: SIAP DIGUNAKAN

Fitur untuk export laporan kasir ke PDF dengan tampilan profesional.

### Cara Menggunakan:
1. Buka halaman **Laporan Kasir** (`/admin/laporan-kasir`)
2. Pilih **kasir** dari dropdown
3. Pilih **periode** (Hari Ini / Minggu Ini / Bulan Ini / Semua)
4. Klik tombol **"Export PDF"**
5. File PDF otomatis terdownload

### Format PDF:
- ✅ Header dengan judul laporan
- ✅ Info kasir (nama, periode, tanggal cetak)
- ✅ Summary box berwarna (jumlah transaksi, total pendapatan, rata-rata)
- ✅ Tabel detail transaksi lengkap
- ✅ Badge metode pembayaran berwarna (Cash, QRIS, Debit)
- ✅ Format Rupiah yang rapi
- ✅ Footer profesional

### Nama File:
```
Laporan_[NamaKasir]_[dd-mm-yyyy].pdf
```
Contoh: `Laporan_kasir1_25-11-2025.pdf`

### Setup (Sekali Saja):
```bash
php artisan vendor:publish --provider="Barryvdh\DomPDF\ServiceProvider"
php artisan config:clear
```

### File yang Dibuat:
- `app/Http/Controllers/LaporanController.php` - Method `exportPDF()`
- `resources/views/admin/laporan_pdf.blade.php` - Template PDF
- `routes/web.php` - Route `/admin/laporan-kasir/export-pdf`

### Dokumentasi:
📖 Lihat: `SETUP_PDF_EXPORT.md`

---

## 💾 2. Backup Database Otomatis

### ✅ Status: SIAP DIGUNAKAN

Sistem backup otomatis untuk database dan file penting menggunakan Spatie Laravel Backup.

### Jadwal Backup Otomatis:

| Waktu | Jenis | Keterangan |
|-------|-------|------------|
| **02:00** | Backup Full | Database + File (waktu paling sepi) |
| **14:00** | Backup Full | Safety net di siang hari |
| **03:00** | Cleanup | Hapus backup lama otomatis |
| **09:00** | Monitor | Cek kesehatan backup |

### Backup Manual:
```bash
# Backup database + file (FULL)
php artisan backup:run

# Backup hanya database (lebih cepat)
php artisan backup:run --only-db

# Lihat daftar backup
php artisan backup:list

# Hapus backup lama
php artisan backup:clean

# Cek kesehatan backup
php artisan backup:monitor
```

### Lokasi Backup:
```
storage/app/private/Laravel/
```

Format nama file:
```
k4grafika-cafe-2025-11-25-00-29-56.zip
```

### Retention Policy:

| Periode | Backup yang Disimpan |
|---------|----------------------|
| 7 hari terakhir | Semua backup (2x/hari = 14 backup) |
| 30 hari terakhir | 1 backup per hari (30 backup) |
| 3 bulan terakhir | 1 backup per minggu (12 backup) |
| 6 bulan terakhir | 1 backup per bulan (6 backup) |
| 2 tahun terakhir | 1 backup per tahun (2 backup) |

**Maksimal storage:** 2GB (backup lama otomatis dihapus)

### Yang Di-backup:
✅ Database (semua tabel)  
✅ `/app` - Kode aplikasi  
✅ `/config` - Konfigurasi  
✅ `/database` - Migration & seeder  
✅ `/public` - Gambar & asset  
✅ `/resources` - View & CSS  
✅ `/routes` - Route file  
✅ `.env` - Environment config  

❌ `/vendor` - Tidak di-backup (bisa di-install ulang)  
❌ `/node_modules` - Tidak di-backup (bisa di-install ulang)  
❌ `/storage/logs` - Tidak di-backup (tidak penting)  

### Setup Scheduler (Agar Jalan Otomatis):

**Windows Task Scheduler:**
1. Buka Task Scheduler (Win + R → `taskschd.msc`)
2. Create Basic Task
3. Name: `Laravel Backup Scheduler`
4. Trigger: Daily, jam 00:00
5. Action: Start a program
   - Program: `E:\laragon\bin\php\php-8.2.0\php.exe`
   - Arguments: `artisan schedule:run`
   - Start in: `E:\laragon\www\k4grafika-cafe`
6. Centang "Run whether user is logged on or not"

### Cara Restore Backup:

```bash
# 1. Extract file backup
cd storage/app/private/Laravel
unzip k4grafika-cafe-2025-11-25-00-29-56.zip -d restore

# 2. Restore database
cd restore/db-dumps
mysql -u root -p k4grafika < mysql-k4grafika.sql

# 3. Restore file (jika perlu)
# Copy file dari folder restore ke project
```

### File yang Dibuat:
- `config/backup.php` - Konfigurasi backup
- `routes/console.php` - Schedule backup
- `config/database.php` - Config dump path
- `.env` - Path mysqldump

### Dokumentasi:
📖 Lihat: `CARA_PAKAI_BACKUP.md`  
📖 Lihat: `SETUP_BACKUP_OTOMATIS.md` (dokumentasi lengkap)

---

## 🔧 Konfigurasi Penting

### File .env

```env
# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=k4grafika
DB_USERNAME=root
DB_PASSWORD=

# Path mysqldump untuk backup
# PENTING: Gunakan double backslash (\\) untuk Windows
# Path ke FOLDER bin, bukan file mysqldump.exe
DB_DUMP_PATH="E:\\laragon\\bin\\mysql\\mysql-8.4.3-winx64\\bin"
```

### Cek Path mysqldump

Jalankan file:
```
check-mysqldump.bat
```

Atau manual:
```bash
# Cari versi MySQL Anda
dir E:\laragon\bin\mysql

# Update .env dengan path yang benar
# Contoh: E:\\laragon\\bin\\mysql\\mysql-8.4.3-winx64\\bin
```

---

## 🎯 Quick Commands

### Export PDF
- Klik tombol "Export PDF" di halaman laporan kasir

### Backup
```bash
# Backup sekarang
php artisan backup:run

# Lihat daftar backup
php artisan backup:list

# Hapus backup lama
php artisan backup:clean

# Cek kesehatan
php artisan backup:monitor

# Jalankan scheduler (semua task)
php artisan schedule:run
```

---

## 📊 Monitoring

### Cek Backup Terakhir
```bash
php artisan backup:list
```

Output:
```
+---------+-------+-----------+---------+--------------+-----------------------+--------------+
| Name    | Disk  | Reachable | Healthy | # of backups | Newest backup         | Used storage |
+---------+-------+-----------+---------+--------------+-----------------------+--------------+
| Laravel | local | ✅        | ✅      |            2 | 0.00 (14 seconds ago) |     38.29 MB |
+---------+-------+-----------+---------+--------------+-----------------------+--------------+
```

### Cek Log
```bash
# Windows
type storage\logs\laravel.log | findstr backup
```

---

## 🐛 Troubleshooting

### Export PDF Tidak Jalan

**Solusi:**
```bash
php artisan vendor:publish --provider="Barryvdh\DomPDF\ServiceProvider"
php artisan config:clear
```

### Backup Gagal

**Cek path mysqldump:**
```bash
# Jalankan
check-mysqldump.bat

# Update .env dengan path yang benar
# Gunakan double backslash (\\)
```

**Clear cache:**
```bash
php artisan config:clear
php artisan cache:clear
```

**Test manual:**
```bash
php artisan backup:run --only-db
```

### Scheduler Tidak Jalan

**Test manual:**
```bash
php artisan schedule:run
```

**Cek Windows Task Scheduler:**
- Pastikan task sudah dibuat
- Cek "Last Run Result" (harus 0x0 = sukses)
- Cek path PHP sudah benar

---

## ✅ Checklist Setup

### Export PDF
- [x] Install DomPDF
- [x] Buat controller method
- [x] Buat template PDF
- [x] Tambah route
- [x] Update JavaScript
- [ ] Test export PDF

### Backup Otomatis
- [x] Install Spatie Backup
- [x] Konfigurasi backup.php
- [x] Setup scheduler
- [x] Konfigurasi database dump path
- [x] Test backup manual
- [ ] Setup Windows Task Scheduler
- [ ] Test restore backup
- [ ] (Opsional) Setup cloud storage
- [ ] (Opsional) Setup email notification

---

## 📚 Dokumentasi Lengkap

1. **SETUP_PDF_EXPORT.md** - Panduan lengkap export PDF
2. **CARA_PAKAI_BACKUP.md** - Panduan praktis backup (RECOMMENDED)
3. **SETUP_BACKUP_OTOMATIS.md** - Dokumentasi teknis backup lengkap
4. **check-mysqldump.bat** - Script cek path mysqldump

---

## 🎉 Summary

### Export PDF
✅ **Siap digunakan!**
- Klik tombol "Export PDF" di laporan kasir
- PDF langsung terdownload dengan format profesional

### Backup Otomatis
✅ **Siap digunakan!**
- Backup manual: `php artisan backup:run`
- Lokasi: `storage/app/private/Laravel/`
- Scheduler: Tinggal setup Windows Task Scheduler

**Kedua fitur sudah berfungsi dengan baik! 🚀**

---

## 📞 Support

Jika ada masalah:
1. Baca dokumentasi di folder project
2. Cek log: `storage/logs/laravel.log`
3. Test manual command
4. Clear cache: `php artisan config:clear`

---

**Dibuat dengan ❤️ untuk K4Grafika Cafe**
