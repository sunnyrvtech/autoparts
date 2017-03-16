<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_id','meta_title','meta_description','meta_keyword','software','paint_code','paint_applicator','brake_pad','tonneau_cover_type','shaft_size','licensed_by','car_cover','tow_ball_diameter','trailer_hitch_class','kit_includes','trunk_mat_color','fender_flare_type','product_grade','lighting_bulb_count','lighting_usage','lighting_bulb_brand','lighting_bulb_configuration','lighting_housing_shape','bracket_style','lighting_wattage_rating','lighting_size','lighting_beam_pattern','lighting_lens_material','lighting_mount_type','cooling_fan_type','radiator_row_count','oil_plan_capacity','intake_type','regulator_option','manufacturing_process','brake_rotor_type','thread_type','spark_plug_type'
    ];
    
}
