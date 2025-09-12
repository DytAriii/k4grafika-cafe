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
            $table->string('nama', 50);
            $table->float('harga');
            $table->foreignId('categories_id')->constrained('categories')->cascadeOnDelete();
            $table->string('gambar')->nullable();
            $table->foreignId('status_id')->constrained('status')->cascadeOnDelete();
            $table->timestamps();
        });
    }
//     public function up(): void
//     {
//         Schema::create('menus', function (Blueprint $table) {
//     $table->id();
//     $table->string('nama');
//     $table->float('harga');
//     $table->unsignedBigInteger('categories_id');
//     $table->string('gambar')->nullable();
//     $table->enum('status', ['available', 'unavailable']);
//     $table->timestamps();

//     $table->foreign('categories_id')
//           ->references('id')->on('categories')
//           ->onDelete('cascade');
// });
//     }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
