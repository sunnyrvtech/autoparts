<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('order_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id');
            $table->string('track_id')->nullable();
            $table->integer('product_id');
            $table->string('product_name');
            $table->string('sku_number');
            $table->integer('quantity');
            $table->decimal('total_price', 5, 2);
            $table->decimal('discount', 5, 2)->nullable();
            $table->string('ship_carrier')->nullable();
            $table->timestamp('ship_date')->nullable();
            $table->text('notes')->nullable();
            $table->string('item_status')->default('processing'); 	
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
        Schema::dropIfExists('order_details');
    }
}
