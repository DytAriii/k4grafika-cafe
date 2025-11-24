<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('invoice')->unique();
            $table->string('customer_name')->nullable();
            $table->integer('total_items')->default(0);
            $table->integer('total_qty')->default(0);
            $table->bigInteger('total_price')->default(0); // rupiah, integer
            $table->string('payment_method')->nullable(); // 'cash' or 'qris'
            $table->bigInteger('paid_amount')->nullable();
            $table->bigInteger('change_amount')->nullable();
            $table->enum('status', ['pending','paid','cancelled'])->default('pending');
            $table->timestamps();
        });
    }
    public function down() {
        Schema::dropIfExists('orders');
    }
};
