<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('product_categories', function (Blueprint $table) {
           $table->increments('id');
           $table->integer('product_id')->unsigned()->nullable();
           $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
           $table->integer('category_id')->unsigned()->nullable();
           $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
       });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_categories');
    }
}
