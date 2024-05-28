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
        Schema::create('promos', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('description');
            $table->string('qty')->default(0);
            $table->date('start_date');
            $table->date('end_date');
//            $table->string('promo_code')->unique();
//            $table->decimal('discount', 8, 2);
//            $table->decimal('min_purchase', 8, 2)->nullable();
//            $table->decimal('max_discount', 8, 2)->nullable();
//            $table->boolean('is_active')->default(true);
//            $table->integer('usage_limit')->nullable();
//            $table->integer('used_count')->default(0);
            $table->string('image');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promos');
    }
};
