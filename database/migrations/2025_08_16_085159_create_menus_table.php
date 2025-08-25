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
    $table->unsignedBigInteger('kategori_id'); // foreign key
    $table->string('gambar')->nullable();
    $table->enum('status', ['available', 'unavailable']);
    $table->timestamps();

    $table->foreign('kategori_id')
          ->references('id')->on('categories')
          ->onDelete('cascade');
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
