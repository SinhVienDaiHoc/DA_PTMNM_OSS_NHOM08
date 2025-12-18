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
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('code',191)->unique();
            $table->string('name',191)->nullable();
            $table->text('description')->nullable(); // Dùng text cho mô tả dài
            $table->string('type', 20); // 'percentage' | 'fixed' | 'gift'
            $table->decimal('discount_amount', 10, 0);
            $table->integer('required_points')->default(0);//Admin sẽ set sau
            $table->integer('max_usage_count')->default(1); // Số lần tối đa mã này có thể được dùng (tổng cộng)
            $table->integer('quantity')->nullable(); // Số lượng Voucher phát hành (nếu là đổi điểm)
            $table->boolean('is_active')->default(true);
            $table->timestamp('start_at')->nullable(); // Thời điểm bắt đầu hiệu lực
            $table ->timestamp('expires_at')->nullable();//Time hiệu lực
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
