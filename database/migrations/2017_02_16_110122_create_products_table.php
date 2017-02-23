<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        Schema::create('products', function (Blueprint $table) {
//            $table->increments('id');
//            $table->integer('category_id')->nullable();
//            $table->integer('sub_category_id')->nullable();
//            $table->integer('sub_sub_category_id')->nullable();
//            $table->string('product_name');
//            $table->string('product_long_description');
//            $table->string('part_number');
//            $table->decimal('price', 5, 2);
//            $table->decimal('discount', 5, 2)->nullable();
//
//            $table->enum('status', array(0, 1))->default(0);
//            $table->rememberToken();
//            $table->timestamps();
//            $table->softDeletes();
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
//       Schema::dropIfExists('products');
    }
}
