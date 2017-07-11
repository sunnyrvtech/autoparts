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
       Schema::create('products', function (Blueprint $table) {
           $table->increments('id');
           $table->string('product_name');
           $table->string('product_slug');
           $table->text('product_long_description');
           $table->text('product_short_description')->nullable();
           $table->string('sku');
           $table->integer('quantity')->nullable();
           $table->decimal('price', 5, 2);
           $table->decimal('discount', 5, 2)->nullable();
           $table->text('vehicle_fit')->nullable();
           $table->integer('vehicle_year')->nullable();
           $table->integer('vehicle_make_id')->nullable();
           $table->integer('vehicle_model_id')->nullable();
           $table->decimal('length', 5, 2)->nullable();
           $table->decimal('weight', 5, 2)->nullable();
           $table->decimal('width', 5, 2)->nullable();
           $table->decimal('height', 5, 2)->nullable();
           $table->string('part_type')->nullable();
           $table->integer('brand_id')->nullable();
           $table->string('operation')->nullable();
           $table->string('wattage')->nullable();
           $table->string('mirror_option')->nullable();
           $table->string('location')->nullable();
           $table->string('size')->nullable();
           $table->string('material')->nullable();
           $table->string('color')->nullable();
           $table->string('front_location')->nullable();
           $table->string('side_location')->nullable();
           $table->string('includes')->nullable();
           $table->string('design')->nullable();
           $table->string('product_line')->nullable();
           $table->tinyInteger('status')->default(1);
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
       Schema::dropIfExists('products');
    }
}
