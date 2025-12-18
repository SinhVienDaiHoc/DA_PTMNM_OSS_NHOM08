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
        Schema::create('order_items', function (Blueprint $table) {
            //ĐÃ CHỈNH LẠI CẤU TRÚC
            $table->id();
            $table->integer('quantity');
            $table->decimal('price_at_order',10,0);
            $table->timestamps();
            
               //=======================================
            // CÁC RÀNG BUỘC
            // Bảng orders
            $table->foreignId('order_id') 
                  ->constrained('orders') 
                  ->onDelete('cascade');

            //Bản products
            $table->foreignId('product_id')
            ->constrained('products')
            ->onDelete('restrict');
         
            $table->unique(['order_id','product_id']);
          //=======================================
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};