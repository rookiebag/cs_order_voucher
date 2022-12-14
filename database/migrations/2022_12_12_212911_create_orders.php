<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('user_email', 100)->comment('User Email, a sort of user identity');
            $table->smallInteger('quantity')->default(0);
            $table->foreignId('voucher_id')->nullable()->constrained('vouchers');
            $table->decimal('discount')->default(0.00)->comment('voucher discount applied');
            $table->decimal('sub_total')->default(0.00);
            $table->decimal('order_total')->default(0.00);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
