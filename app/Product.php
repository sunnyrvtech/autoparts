<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_id', 'sub_category_id', 'sub_sub_category_id', 'product_name', 'product_long_description', 'product_short_description', 'part_number', 'quantity', 'price', 'discount', 'vehicle_fit', 'vehicle_year', 'vehicle_make_id', 'vehicle_model_id', 'part_type', 'brand_id', 'operation', 'wattage', 'mirror_option', 'location', 'size', 'material', 'carpet_color', 'light_option', 'fuel_tank_option', 'color', 'hood_type', 'front_location', 'side_location', 'tube_size', 'wheel_option', 'includes', 'design', 'product_line', 'status',
    ];

    public function product_details() {
        return $this->hasOne('App\ProductDetail');
    }

}
