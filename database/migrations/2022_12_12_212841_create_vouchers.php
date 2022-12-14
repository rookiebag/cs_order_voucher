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
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->comment('Voucher Name');
            $table->string('code', 50)->unique()->comment('Voucher Unique Code');
            $table->char('type', 1)->default('1')->comment('1 = By value, 2 => By percentage');
            $table->decimal('discount_value')->default(0.00)->comment('Voucher value');
            $table->char('is_valid', 1)->default(1)->comment('Set to 0 by cron every morning');
            $table->dateTime('start_date')->comment('voucher validity start date');
            $table->dateTime('end_date')->comment('voucher validity ends date');
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
        Schema::dropIfExists('vouchers');
    }
};
