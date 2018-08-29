<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_details', function (Blueprint $table) {
           $table->increments('id');
           $table->integer('product_id')->unsigned();
           $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
           $table->string('product_images')->nullable();
           $table->string('text')->nullable();
           $table->string('sale_type')->nullable();
           $table->string('m_code')->nullable();
           $table->string('class')->nullable();
           $table->string('parse_link')->nullable();
           $table->string('oem_number')->nullable();
           $table->string('certification')->nullable();
           $table->string('warranty')->nullable();
           $table->string('software')->nullable();
           $table->string('licensed_by')->nullable();
           $table->string('car_cover')->nullable();
           $table->string('kit_includes')->nullable();
           $table->string('fender_flare_type')->nullable();
           $table->string('product_grade')->nullable();
           $table->string('lighting_size')->nullable();
           $table->string('lighting_beam_pattern')->nullable();
           $table->string('lighting_lens_material')->nullable();
           $table->string('lighting_mount_type')->nullable();
           $table->string('lighting_bulb_configuration')->nullable();
           $table->string('lighting_housing_shape')->nullable();
           $table->string('bracket_style')->nullable();
           $table->string('cooling_fan_type')->nullable();
           $table->string('radiator_row_count')->nullable();
           $table->string('oil_plan_capacity')->nullable();
       });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_details');
    }
}
