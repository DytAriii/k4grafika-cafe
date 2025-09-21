<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            // Hapus kolom lama
            $table->dropColumn('order_type');

            // Tambahkan kolom baru
            $table->text('catatan')->nullable()->after('nama_customer');
        });
    }

    public function down(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            // Rollback: tambahkan kembali order_type
            $table->enum('order_type', ['dine_in', 'take_away'])->nullable();

            // Hapus kolom catatan
            $table->dropColumn('catatan');
        });
    }
};
