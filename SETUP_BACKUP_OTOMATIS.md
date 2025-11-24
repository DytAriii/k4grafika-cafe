# Setup Backup Database Otomatis - Spatie Laravel Backup

## 📋 Apa itu Spatie Laravel Backup?

**Spatie Laravel Backup** adalah package yang membuat backup database dan file secara otomatis.

### Analogi Sederhana:
Bayangkan seperti **"Save As"** di Microsoft Word, tapi:
- ✅ Otomatis jalan sendiri setiap hari
- ✅ Backup database + file penting
- ✅ Simpan ke cloud (Google Drive, Dropbox, AWS)
- ✅ Hapus backup lama otomatis
- ✅ Kirim notifikasi kalau gagal

---

## ⏰ Jadwal Backup yang Sudah Dikonfigurasi

### Backup Utama
- **Waktu:** Setiap hari jam **02:00 dini hari**
- **Alasan:** Waktu paling sepi, tidak ada transaksi
- **Isi:** Database + File penting

### Backup Tambahan (Safety Net)
- **Waktu:** Setiap hari jam **14:00 siang**
- **Alasan:** Backup cadangan di tengah hari
- **Isi:** Database + File penting

### Cleanup Backup Lama
- **Waktu:** Setiap hari jam **03:00** (setelah backup utama)
- **Fungsi:** Hapus backup lama sesuai retention policy

### Monitor Backup
- **Waktu:** Setiap hari jam **09:00**
- **Fungsi:** Cek kesehatan backup, kirim notifikasi jika ada masalah

---

## 📦 Apa yang Di-backup?

### ✅ Database
- Semua tabel transaksi
- Data kasir
- Data menu
- Data users
- Semua data penting

### ✅ File Penting
- `/app` - Kode aplikasi
- `/config` - Konfigurasi
- `/database` - Migration & seeder
- `/public` - Gambar & asset
- `/resources` - View & CSS
- `/routes` - Route file
- `.env` - Environment config

### ❌ Yang TIDAK Di-backup (untuk hemat space)
- `/vendor` - Package composer (bisa di-install ulang)
- `/node_modules` - Package npm (bisa di-install ulang)
- `/storage/logs` - Log file (tidak penting)
- `/storage/framework/cache` - Cache (temporary)

---

## 🗄️ Retention Policy (Berapa Lama Backup Disimpan)

| Periode | Jumlah Backup |
|---------|---------------|
| **7 hari terakhir** | Semua backup (2x sehari = 14 backup) |
| **30 hari terakhir** | 1 backup per hari (30 backup) |
| **3 bulan terakhir** | 1 backup per minggu (12 backup) |
| **6 bulan terakhir** | 1 backup per bulan (6 backup) |
| **2 tahun terakhir** | 1 backup per tahun (2 backup) |

**Total maksimal storage:** 2GB (backup lama otomatis dihapus jika melebihi)

### Contoh Skenario:
- Hari ini: Punya 2 backup (jam 02:00 & 14:00)
- 3 hari lalu: Punya 2 backup
- 10 hari lalu: Punya 1 backup (yang jam 14:00 sudah dihapus)
- 2 bulan lalu: Punya 1 backup per minggu
- 1 tahun lalu: Punya 1 backup per bulan

---

## 🚀 Cara Setup

### 1. Cari Path mysqldump Anda

**Untuk Laragon:**
```
C:\laragon\bin\mysql\mysql-8.0.30\bin\mysqldump
```

**Untuk XAMPP:**
```
C:\xampp\mysql\bin\mysqldump
```

**Untuk MySQL Standalone:**
```
C:\Program Files\MySQL\MySQL Server 8.0\bin\mysqldump
```

**Cara Cek Versi MySQL di Laragon:**
1. Buka folder `C:\laragon\bin\mysql\`
2. Lihat nama folder (contoh: `mysql-8.0.30`)
3. Path lengkap: `C:\laragon\bin\mysql\mysql-8.0.30\bin\mysqldump`

### 2. Update File .env

Buka file `.env` dan cari bagian database, lalu tambahkan:

```env
DB_DUMP_PATH="C:\laragon\bin\mysql\mysql-8.0.30\bin\mysqldump"
```

⚠️ **PENTING:** Sesuaikan path dengan versi MySQL Anda!

### 3. Clear Config Cache

```bash
php artisan config:clear
php artisan cache:clear
```

### 4. Test Backup Manual

```bash
php artisan backup:run
```

Jika berhasil, Anda akan melihat:
```
Starting backup...
Dumping database k4grafika...
Zipping...
Backup completed!
```

### 5. Cek Hasil Backup

Backup disimpan di:
```
storage/app/k4grafika-cafe/
```

File backup format:
```
k4grafika-cafe-2025-11-24-02-00-00.zip
```

---

## 🔧 Setup Scheduler (Agar Jalan Otomatis)

Backup sudah dijadwalkan di `routes/console.php`, tapi Laravel Scheduler perlu dijalankan.

### Opsi 1: Windows Task Scheduler (Recommended untuk Production)

1. Buka **Task Scheduler** (tekan Win + R, ketik `taskschd.msc`)
2. Klik **Create Basic Task**
3. Isi:
   - **Name:** Laravel Backup Scheduler
   - **Trigger:** Daily
   - **Start time:** 00:00 (tengah malam)
   - **Action:** Start a program
   - **Program:** `C:\laragon\bin\php\php-8.2.0\php.exe`
   - **Arguments:** `artisan schedule:run`
   - **Start in:** `E:\laragon\www\k4grafika-cafe`
4. Centang **"Run whether user is logged on or not"**
5. Klik **OK**

### Opsi 2: Manual (Untuk Development)

Jalankan command ini setiap hari:
```bash
php artisan schedule:run
```

### Opsi 3: Cron Job (Untuk Linux Server)

Edit crontab:
```bash
crontab -e
```

Tambahkan:
```
* * * * * cd /path/to/project && php artisan schedule:run >> /dev/null 2>&1
```

---

## 📊 Command Backup yang Tersedia

### 1. Backup Manual
```bash
php artisan backup:run
```
Membuat backup sekarang juga.

### 2. Backup Hanya Database
```bash
php artisan backup:run --only-db
```
Backup database saja, tanpa file.

### 3. Backup Hanya File
```bash
php artisan backup:run --only-files
```
Backup file saja, tanpa database.

### 4. Cleanup Backup Lama
```bash
php artisan backup:clean
```
Hapus backup lama sesuai retention policy.

### 5. List Semua Backup
```bash
php artisan backup:list
```
Lihat semua backup yang tersimpan.

### 6. Monitor Backup
```bash
php artisan backup:monitor
```
Cek kesehatan backup (apakah backup terbaru masih fresh).

---

## 🔍 Cara Restore Backup

### Manual Restore:

1. **Extract file backup:**
   - Buka `storage/app/k4grafika-cafe/`
   - Extract file `.zip` yang ingin direstore

2. **Restore Database:**
   ```bash
   mysql -u root -p k4grafika < db-dumps/mysql-k4grafika.sql
   ```

3. **Restore File:**
   - Copy folder yang di-extract ke project Anda
   - Replace file yang ada

### Otomatis (Buat Command Custom):

Saya bisa buatkan command `php artisan backup:restore` jika diperlukan.

---

## 📧 Setup Notifikasi Email (Opsional)

Jika ingin dapat email saat backup gagal:

### 1. Update .env untuk Email

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

### 2. Update config/backup.php

Cari bagian `notifications` dan update:

```php
'mail' => [
    'to' => 'admin@k4grafika.com', // Email admin
    
    'from' => [
        'address' => env('MAIL_FROM_ADDRESS', 'hello@example.com'),
        'name' => env('MAIL_FROM_NAME', 'K4Grafika Backup'),
    ],
],
```

---

## ☁️ Backup ke Cloud (Opsional)

### Google Drive

1. Install package:
```bash
composer require masbug/flysystem-google-drive-ext
```

2. Setup Google Drive API (ikuti dokumentasi Spatie)

3. Update `config/backup.php`:
```php
'disks' => [
    'local',
    'google', // Tambahkan ini
],
```

### AWS S3

1. Install package:
```bash
composer require league/flysystem-aws-s3-v3
```

2. Update .env:
```env
AWS_ACCESS_KEY_ID=your-key
AWS_SECRET_ACCESS_KEY=your-secret
AWS_DEFAULT_REGION=ap-southeast-1
AWS_BUCKET=k4grafika-backup
```

3. Update `config/backup.php`:
```php
'disks' => [
    'local',
    's3', // Tambahkan ini
],
```

---

## 🐛 Troubleshooting

### Error: "mysqldump not found"

**Solusi:**
1. Cek path mysqldump di `.env`
2. Pastikan path benar dan file ada
3. Gunakan double backslash: `C:\\laragon\\bin\\mysql\\...`
4. Atau gunakan forward slash: `C:/laragon/bin/mysql/...`

### Error: "Permission denied"

**Solusi:**
```bash
# Windows
icacls storage /grant Users:F /T

# Linux
chmod -R 775 storage
chown -R www-data:www-data storage
```

### Backup terlalu besar

**Solusi:**
1. Exclude folder tidak penting di `config/backup.php`
2. Backup hanya database: `php artisan backup:run --only-db`
3. Compress database di config:
```php
'database_dump_compressor' => Spatie\DbDumper\Compressors\GzipCompressor::class,
```

### Scheduler tidak jalan

**Solusi:**
1. Cek Windows Task Scheduler sudah setup
2. Test manual: `php artisan schedule:run`
3. Cek log: `storage/logs/laravel.log`

---

## 📈 Monitoring Backup

### Cek Backup Terakhir:
```bash
php artisan backup:list
```

### Cek Log:
```bash
# Windows
type storage\logs\laravel.log | findstr backup

# Linux
tail -f storage/logs/laravel.log | grep backup
```

### Cek Ukuran Backup:
```bash
# Windows
dir storage\app\k4grafika-cafe

# Linux
du -sh storage/app/k4grafika-cafe/*
```

---

## ✅ Checklist Setup

- [ ] Install Spatie Backup: `composer require spatie/laravel-backup`
- [ ] Publish config: `php artisan vendor:publish --provider="Spatie\Backup\BackupServiceProvider"`
- [ ] Update `.env` dengan path mysqldump
- [ ] Update `config/database.php` dengan dump config
- [ ] Update `config/backup.php` (sudah dikonfigurasi)
- [ ] Update `routes/console.php` (sudah dikonfigurasi)
- [ ] Test backup: `php artisan backup:run`
- [ ] Setup Windows Task Scheduler
- [ ] Test scheduler: `php artisan schedule:run`
- [ ] (Opsional) Setup email notifikasi
- [ ] (Opsional) Setup cloud storage

---

## 🎯 Best Practices

1. **Test Restore Secara Berkala**
   - Backup tidak berguna jika tidak bisa direstore
   - Test restore setiap bulan

2. **Monitor Ukuran Backup**
   - Cek ukuran backup secara berkala
   - Adjust retention policy jika perlu

3. **Backup ke Multiple Location**
   - Local + Cloud (Google Drive/S3)
   - Jangan hanya 1 lokasi

4. **Dokumentasi**
   - Catat prosedur restore
   - Simpan di tempat aman

5. **Security**
   - Jangan commit `.env` ke git
   - Encrypt backup jika berisi data sensitif
   - Batasi akses ke folder backup

---

## 📞 Support

Jika ada masalah:
1. Cek log: `storage/logs/laravel.log`
2. Cek dokumentasi Spatie: https://spatie.be/docs/laravel-backup
3. Test manual: `php artisan backup:run --only-db`

---

## 🔐 Keamanan Backup

### Encrypt Backup (Opsional)

Update `.env`:
```env
BACKUP_ARCHIVE_PASSWORD=your-strong-password
```

Backup akan di-encrypt dengan password. Untuk extract:
```bash
# Perlu password untuk extract
unzip -P your-strong-password backup.zip
```

---

## 📝 Summary

✅ **Backup Otomatis:** Setiap hari jam 02:00 & 14:00  
✅ **Retention:** 7 hari semua, 30 hari harian, 3 bulan mingguan, 6 bulan bulanan, 2 tahun tahunan  
✅ **Storage:** Maksimal 2GB  
✅ **Cleanup:** Otomatis setiap hari jam 03:00  
✅ **Monitor:** Setiap hari jam 09:00  
✅ **Lokasi:** `storage/app/k4grafika-cafe/`  

**Backup sudah siap! Tinggal setup Windows Task Scheduler agar jalan otomatis.**
