<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWarehouseStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('warehouse_stores', function (Blueprint $table) {
            $table->increments('id');
            $table->string('store_name');
            $table->string('email')->unique();
            $table->string('address');
            $table->string('country');
            $table->string('state');
            $table->string('city');
            $table->string('zip');
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('warehouse_stores');
    }
}
