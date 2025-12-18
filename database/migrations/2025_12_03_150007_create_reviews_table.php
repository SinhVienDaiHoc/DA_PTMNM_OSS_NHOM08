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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('rating')->nullable();
            $table->string('comment')->nullable();
            $table->timestamps();

            //=================================
            //CÁC RÀNG BUỘC
            //Bảng users
            $table->foreignId('user_id')
            ->constrained('users')
            ->onDelete('cascade');

            //Bảng products
            $table->foreignId('product_id')
            ->constrained('products')
            ->onDelete('cascade');

            $table->unique(['user_id','product_id']);// 1 user chỉ đánh giá 1 product 1 lần
            //=================================
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
