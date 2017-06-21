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
        'product_name', 'product_long_description', 'product_short_description', 'part_number', 'quantity', 'price', 'discount', 'vehicle_fit', 'vehicle_year', 'vehicle_make_id', 'vehicle_model_id','weight','length','width','height', 'part_type', 'brand_id', 'operation', 'wattage', 'mirror_option', 'location', 'size', 'material', 'carpet_color', 'light_option', 'fuel_tank_option', 'color', 'hood_type', 'front_location', 'side_location', 'tube_size', 'wheel_option', 'includes', 'design', 'product_line', 'status',
    ];

    public function product_details() {
        return $this->hasOne('App\ProductDetail');
    }

    public function product_categories() {
        return $this->hasMany('App\ProductCategory');
    }

    public function product_sub_categories() {
        return $this->hasMany('App\ProductSubCategory');
    }

    public function product_sub_sub_categories() {
        return $this->hasMany('App\ProductSubSubCategory');
    }

    public function get_brands() {
        return $this->hasOne('App\Brand', 'id', 'brand_id');
    }
    
    
    /**
     * function to search product based on category name 
     *
     * @return Response
     */

    public function product_category() {
        return $this->belongsTo('App\ProductCategory', 'id','product_id');
    }

    /**
     * function to get vehicle company 
     *
     * @return Response
     */
    public function get_vehicle_company() {
        return $this->hasOne('App\VehicleCompany', 'id', 'vehicle_make_id');
    }

    /**
     * function to get vehicle model 
     *
     * @return Response
     */
    public function get_vehicle_model() {
        return $this->hasOne('App\VehicleModel', 'id', 'vehicle_model_id');
    }

}
