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
            if (!Schema::hasTable('points')) {
            Schema::create('points', function (Blueprint $table) {
                $table->id();
                $table->integer('points');
                $table->tinyInteger('type');
                $table->string('description');
                $table->timestamps();
                //==========================
                //CÁC RÀNG BUỘC
                //Bảng users
                $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');

                //Bảng orders
                $table->foreignId('order_id')
                ->nullable()//Null vì có thể là giao dịch của Admin
                ->constrained('orders')
                ->onDelete('set null');
                //==========================
            });
        }
    }
        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::dropIfExists('points');
        }
    };
