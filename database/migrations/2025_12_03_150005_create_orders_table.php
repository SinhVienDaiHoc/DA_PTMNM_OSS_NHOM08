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
            $table->dateTime('date')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->decimal('total', 10, 0)->nullable();
            $table->string('shipping_address', 255)->nullable();
            $table->string('payment_method', 50)->nullable();
            $table->timestamps();//created_at và update_at
            //==========================================================
            //CÁC KHÓA NGOẠI
            //Bảng Users
            $table->foreignId('user_id')
            ->constrained('users')
            ->onDelete('restrict');

            //Khóa ngoại với bảng Vouchers
            $table->foreignId('voucher_id')
            ->nullable()//có thể có voucher hoặc ko
            ->constrained('vouchers')
            ->onDelete('set null');
            
            //==========================================================

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
