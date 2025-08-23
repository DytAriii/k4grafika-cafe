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
        Schema::create('menus', function (Blueprint $table) {
    $table->id();
    $table->string('nama');
    $table->float('harga');
    $table->enum('kategori', ['Drink', 'Coffee', 'Snack', 'Food']);
    $table->string('gambar')->nullable();
    $table->enum('status', ['available', 'unavailable']);
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
