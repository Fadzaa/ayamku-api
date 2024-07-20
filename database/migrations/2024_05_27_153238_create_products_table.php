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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->text('description');
            $table->enum('category', ['geprek', 'ricebowl', 'snack', 'minuman'])->default('geprek');
            $table->decimal('price', 8, 2);
            $table->decimal('rating', 2, 1)->default(0);
//            $table->unsignedInteger('stock')->default(0);
            $table->string('image');
            $table->unsignedInteger('total_rating')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
