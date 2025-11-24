# 🎉 Backup Otomatis Sudah Siap Digunakan!

## ✅ Status: BERHASIL DIKONFIGURASI

Backup database dan file sudah berfungsi dengan baik!

---

## 📋 Cara Menggunakan

### 1. Backup Manual (Kapan Saja)

```bash
# Backup database + file (FULL)
php artisan backup:run

# Backup hanya database (lebih cepat)
php artisan backup:run --only-db

# Backup hanya file
php artisan backup:run --only-files
```

### 2. Lihat Daftar Backup

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

### 3. Cleanup Backup Lama

```bash
php artisan backup:clean
```

Akan menghapus backup lama sesuai retention policy.

### 4. Monitor Kesehatan Backup

```bash
php artisan backup:monitor
```

Cek apakah backup masih fresh dan tidak ada masalah.

---

## 📁 Lokasi File Backup

Backup disimpan di:
```
storage/app/private/Laravel/
```

Format nama file:
```
k4grafika-cafe-2025-11-25-00-29-56.zip
```

---

## ⏰ Jadwal Backup Otomatis

Backup akan jalan otomatis setiap hari:

| Waktu | Jenis | Keterangan |
|-------|-------|------------|
| **02:00** | Backup Full | Database + File (waktu sepi) |
| **14:00** | Backup Full | Safety net di siang hari |
| **03:00** | Cleanup | Hapus backup lama |
| **09:00** | Monitor | Cek kesehatan backup |

---

## 🔧 Setup Scheduler (Agar Jalan Otomatis)

### Windows Task Scheduler

1. Buka **Task Scheduler** (Win + R → `taskschd.msc`)
2. Klik **Create Basic Task**
3. Isi form:
   - **Name:** Laravel Backup Scheduler
   - **Trigger:** Daily, jam 00:00
   - **Action:** Start a program
   - **Program:** `E:\laragon\bin\php\php-8.2.0\php.exe` (sesuaikan versi PHP Anda)
   - **Arguments:** `artisan schedule:run`
   - **Start in:** `E:\laragon\www\k4grafika-cafe`
4. Centang **"Run whether user is logged on or not"**
5. Klik **OK**

### Atau Jalankan Manual Setiap Hari

```bash
php artisan schedule:run
```

Command ini akan menjalankan semua scheduled task (backup, cleanup, monitor).

---

## 🗄️ Retention Policy (Berapa Lama Backup Disimpan)

| Periode | Jumlah Backup yang Disimpan |
|---------|------------------------------|
| **7 hari terakhir** | Semua backup (2x/hari = 14 backup) |
| **30 hari terakhir** | 1 backup per hari (30 backup) |
| **3 bulan terakhir** | 1 backup per minggu (12 backup) |
| **6 bulan terakhir** | 1 backup per bulan (6 backup) |
| **2 tahun terakhir** | 1 backup per tahun (2 backup) |

**Maksimal storage:** 2GB (backup lama otomatis dihapus jika melebihi)

---

## 🔄 Cara Restore Backup

### 1. Extract File Backup

```bash
# Buka folder backup
cd storage/app/private/Laravel

# Extract file zip
unzip k4grafika-cafe-2025-11-25-00-29-56.zip -d restore
```

### 2. Restore Database

```bash
# Masuk ke folder hasil extract
cd restore/db-dumps

# Restore database
mysql -u root -p k4grafika < mysql-k4grafika.sql
```

### 3. Restore File (Jika Perlu)

Copy file dari folder `restore` ke project Anda.

---

## 📊 Monitoring Backup

### Cek Backup Terakhir

```bash
php artisan backup:list
```

### Cek Ukuran Backup

```bash
# Windows
dir storage\app\private\Laravel

# Atau
php artisan backup:list
```

### Cek Log

```bash
# Windows
type storage\logs\laravel.log | findstr backup
```

---

## 🐛 Troubleshooting

### Backup Gagal

**Cek log:**
```bash
type storage\logs\laravel.log
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

### Backup Terlalu Besar

**Backup hanya database:**
```bash
php artisan backup:run --only-db
```

**Atau edit `config/backup.php`:**
- Tambahkan folder ke `exclude` list

---

## ⚙️ Konfigurasi Penting

### File .env

```env
DB_DUMP_PATH="E:\\laragon\\bin\\mysql\\mysql-8.4.3-winx64\\bin"
```

⚠️ **PENTING:** 
- Gunakan **double backslash** (`\\`) untuk Windows
- Path ke **folder bin**, bukan file `mysqldump.exe`

### Jika Ganti Versi MySQL

Update path di `.env`:
```env
DB_DUMP_PATH="E:\\laragon\\bin\\mysql\\mysql-8.5.0-winx64\\bin"
```

Lalu clear cache:
```bash
php artisan config:clear
```

---

## 📈 Best Practices

1. **Test Restore Secara Berkala**
   - Backup tidak berguna jika tidak bisa direstore
   - Test restore setiap bulan

2. **Monitor Ukuran Backup**
   ```bash
   php artisan backup:list
   ```

3. **Backup ke Cloud (Opsional)**
   - Google Drive
   - AWS S3
   - Dropbox

4. **Dokumentasi Prosedur**
   - Simpan dokumentasi restore
   - Catat password jika ada

5. **Security**
   - Jangan commit `.env` ke git
   - Batasi akses ke folder backup
   - Encrypt backup jika berisi data sensitif

---

## 🎯 Quick Reference

```bash
# Backup sekarang
php artisan backup:run

# Lihat daftar backup
php artisan backup:list

# Hapus backup lama
php artisan backup:clean

# Cek kesehatan
php artisan backup:monitor

# Jalankan scheduler
php artisan schedule:run
```

---

## ✅ Checklist

- [x] Install Spatie Backup
- [x] Konfigurasi database dump path
- [x] Test backup manual
- [x] Setup retention policy
- [x] Konfigurasi scheduler
- [ ] Setup Windows Task Scheduler (untuk otomatis)
- [ ] Test restore backup
- [ ] (Opsional) Setup cloud storage
- [ ] (Opsional) Setup email notification

---

## 📞 Support

Jika ada masalah:
1. Cek log: `storage/logs/laravel.log`
2. Test manual: `php artisan backup:run --only-db`
3. Clear cache: `php artisan config:clear`

---

## 🎉 Summary

✅ **Backup sudah berfungsi dengan baik!**

- Backup manual: `php artisan backup:run`
- Lokasi: `storage/app/private/Laravel/`
- Retention: 7 hari semua, 30 hari harian, dst.
- Scheduler: Tinggal setup Windows Task Scheduler

**Backup database Anda sudah aman! 🔒**
