<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoupanCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupan_codes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('coupon_name');
            $table->string('code');
            $table->integer('usage');
            $table->string('coupon_type')->nullable();
            $table->text('product_sku')->nullable();
            $table->decimal('discount', 5, 2)->nullable();
            $table->dateTime('expiration_date');
            $table->tinyInteger('status')->default(1);
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
        Schema::dropIfExists('coupan_codes');
    }
}
