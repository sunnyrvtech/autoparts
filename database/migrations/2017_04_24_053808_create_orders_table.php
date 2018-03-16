<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('transaction_id');
            $table->decimal('total_price', 5, 2);
            $table->decimal('ship_price', 5, 2);
            $table->decimal('tax_rate', 5, 2);
            $table->string('shipping_method')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('coupon_type')->nullable();
            $table->decimal('discount', 5, 2)->nullable();
            $table->string('order_status'); 	
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
}
