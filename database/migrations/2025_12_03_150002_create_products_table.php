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
            $table->string('name');
            $table->decimal('price');
            $table->integer('stock')->default(0);
            $table->string('description')->nullable();
            $table->string('image_cover');
            $table->integer('reward_point')->default(0);
            $table->timestamps();
            
            //==================================================
            //ĐÃ CHỈNH SỬA LẦN 1
            //Khóa ngoại Categories
            $table->unsignedBigInteger('ADMIN_id_Admin')->nullable();
            $table->unsignedBigInteger('CATEGORIES_id_Categories')->nullable();


            $table->foreignId('category_id')
            ->constrained('categories')//chiếu vào table categories
            ->onDelete('cascade');
            

            //Khóa ngoại User
            $table->foreignId('user_id')
            ->constrained('users')
            ->onDelete('restrict');
                  //===============================================
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
