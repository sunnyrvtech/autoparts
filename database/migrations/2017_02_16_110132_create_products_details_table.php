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
           $table->string('meta_title')->nullable();
           $table->string('meta_description')->nullable();
           $table->string('meta_keyword')->nullable();
           $table->string('product_images')->nullable();
           $table->string('software')->nullable();
           $table->string('paint_code')->nullable();
           $table->string('paint_applicator')->nullable();
           $table->string('brake_pad')->nullable();
           $table->string('tonneau_cover_type')->nullable();
           $table->string('shaft_size')->nullable();
           $table->string('licensed_by')->nullable();
           $table->string('car_cover')->nullable();
           $table->string('tow_ball_diameter')->nullable();
           $table->string('trailer_hitch_class')->nullable();
           $table->string('kit_includes')->nullable();
           $table->string('trunk_mat_color')->nullable();
           $table->string('fender_flare_type')->nullable();
           $table->string('product_grade')->nullable();
           $table->string('lighting_wattage_rating')->nullable();
           $table->string('lighting_size')->nullable();
           $table->string('lighting_beam_pattern')->nullable();
           $table->string('lighting_lens_material')->nullable();
           $table->string('lighting_mount_type')->nullable();
           $table->string('lighting_bulb_count')->nullable();
           $table->string('lighting_usage')->nullable();
           $table->string('lighting_bulb_brand')->nullable();
           $table->string('lighting_bulb_configuration')->nullable();
           $table->string('lighting_housing_shape')->nullable();
           $table->string('bracket_style')->nullable();
           $table->string('cooling_fan_type')->nullable();
           $table->string('radiator_row_count')->nullable();
           $table->string('oil_plan_capacity')->nullable();
           $table->string('intake_type')->nullable();
           $table->string('regulator_option')->nullable();
           $table->string('manufacturing_process')->nullable();
           $table->string('brake_rotor_type')->nullable();
           $table->string('thread_type')->nullable();
           $table->string('spark_plug_type')->nullable();
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
