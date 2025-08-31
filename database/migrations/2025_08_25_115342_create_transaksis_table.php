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
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); // kasir yg input
        $table->decimal('total', 10, 2);
        $table->decimal('diskon', 10, 2)->default(0);
        $table->decimal('bayar', 10, 2); // uang yg dibayar customer
        $table->enum('metode_pembayaran', ['cash', 'qris']);
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
