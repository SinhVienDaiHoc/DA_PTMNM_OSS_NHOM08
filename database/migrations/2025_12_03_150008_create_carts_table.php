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
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->decimal('total', 10, 0)->nullable();
            $table->tinyInteger('status')->nullable();
            $table->timestamps();
            
            //=================================
            //CÁC RÀNG BUỘC
            //Bảng users
            $table->foreignId('user_id')
            ->constrained('users')
            ->onDelete('cascade');
            $table->unique('user_id');
            //=================================
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
