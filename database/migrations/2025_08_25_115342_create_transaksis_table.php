<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
    Schema::create('transaksis', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // kasir
    $table->string('invoice')->unique();
    $table->string('nama_customer')->nullable();
    $table->enum('order_type', ['dine_in', 'take_away']);
    $table->decimal('total', 12, 2);
    $table->decimal('diskon', 12, 2)->default(0);
    $table->decimal('bayar', 12, 2)->nullable();
    $table->decimal('kembali', 12, 2)->nullable();
    $table->enum('metode_pembayaran', ['cash', 'qris'])->nullable();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
