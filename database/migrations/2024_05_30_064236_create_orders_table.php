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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('cart_id')->constrained()->cascadeOnDelete();
            $table->enum('method_type', ['on_delivery', 'pickup'])->default('on_delivery');
            $table->foreignId('posts_id')->constrained()->cascadeOnDelete();
            $table->enum('status', ['processing', 'completed', 'accept', 'cancelled', 'confirmed_order'])->default('processing');
            $table->time('pickup_time')->nullable();

            $table->foreignId('voucher_id')->nullable()->constrained()->cascadeOnDelete();
            $table->integer('discount_amount')->default(0);
            $table->integer('final_amount')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
