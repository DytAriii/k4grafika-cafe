<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// ==================== Backup Schedule ====================

/**
 * Backup Otomatis Database & Files
 * 
 * Jadwal:
 * - Backup Utama: Setiap hari jam 02:00 (dini hari)
 * - Backup Tambahan: Setiap hari jam 14:00 (siang)
 * 
 * Retention Policy:
 * - 7 hari terakhir: Semua backup disimpan
 * - 30 hari terakhir: 1 backup per hari
 * - 3 bulan terakhir: 1 backup per minggu
 * - 6 bulan terakhir: 1 backup per bulan
 * - 2 tahun terakhir: 1 backup per tahun
 */

// Backup Utama - Jam 02:00 dini hari (waktu paling sepi)
Schedule::command('backup:run')
    ->dailyAt('02:00')
    ->name('backup-database-utama')
    ->onSuccess(function () {
        info('✅ Backup database berhasil pada ' . now()->format('d-m-Y H:i:s'));
    })
    ->onFailure(function () {
        error('❌ Backup database gagal pada ' . now()->format('d-m-Y H:i:s'));
    });

// Backup Tambahan - Jam 14:00 siang (sebagai safety net)
Schedule::command('backup:run')
    ->dailyAt('14:00')
    ->name('backup-database-tambahan')
    ->onSuccess(function () {
        info('✅ Backup database tambahan berhasil pada ' . now()->format('d-m-Y H:i:s'));
    })
    ->onFailure(function () {
        error('❌ Backup database tambahan gagal pada ' . now()->format('d-m-Y H:i:s'));
    });

// Cleanup backup lama - Setiap hari jam 03:00 (setelah backup utama)
Schedule::command('backup:clean')
    ->dailyAt('03:00')
    ->name('cleanup-old-backups')
    ->onSuccess(function () {
        info('✅ Cleanup backup lama berhasil pada ' . now()->format('d-m-Y H:i:s'));
    })
    ->onFailure(function () {
        error('❌ Cleanup backup lama gagal pada ' . now()->format('d-m-Y H:i:s'));
    });

// Monitor backup - Setiap hari jam 09:00 (cek kesehatan backup)
Schedule::command('backup:monitor')
    ->dailyAt('09:00')
    ->name('monitor-backups')
    ->onSuccess(function () {
        info('✅ Monitor backup berhasil pada ' . now()->format('d-m-Y H:i:s'));
    })
    ->onFailure(function () {
        error('❌ Monitor backup gagal pada ' . now()->format('d-m-Y H:i:s'));
    });
