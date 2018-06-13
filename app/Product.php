<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
//    protected $fillable = [
//        'product_name', 'product_long_description', 'product_short_description', 'sku', 'quantity', 'price', 'discount', 'vehicle_fit', 'vehicle_year_from','vehicle_year_to', 'vehicle_make_id', 'vehicle_model_id','weight','length','width','height', 'part_type', 'brand_id', 'operation', 'wattage', 'mirror_option', 'location', 'size', 'material', 'carpet_color', 'light_option', 'fuel_tank_option', 'color', 'hood_type', 'front_location', 'side_location', 'tube_size', 'wheel_option', 'includes', 'design', 'product_line', 'status',
//    ];

    protected $fillable = [
        'product_name', 'product_slug', 'product_long_description', 'product_short_description', 'sku', 'quantity', 'price', 'special_price', 'discount', 'vehicle_fit', 'vehicle_year_from', 'vehicle_year_to', 'vehicle_make_id', 'vehicle_model_id', 'category_id', 'sub_category_id', 'weight', 'length', 'width', 'height', 'part_type', 'brand_id', 'operation', 'wattage', 'mirror_option', 'location', 'size', 'material', 'color', 'front_location', 'side_location', 'includes', 'design', 'product_line', 'status',
    ];

    public function product_details() {
        return $this->hasOne('App\ProductDetail');
    }

//    public function product_categories() {
//        return $this->hasMany('App\ProductCategory');
//    }
//    public function product_price_zones(){
//        return $this->hasMany('App\ProductPriceZone','product_id','id');
//    }
//    public function product_sub_categories() {
//        return $this->hasMany('App\ProductSubCategory');
//    }
//    public function product_sub_sub_categories() {
//        return $this->hasMany('App\ProductSubSubCategory');
//    }

    public function get_brands() {
        return $this->hasOne('App\Brand', 'id', 'brand_id');
    }

    /**
     * function to search product based on category name 
     *
     * @return Response
     */
//    public function product_category() {
//        return $this->belongsTo('App\ProductCategory', 'id','product_id');
//    }

    /**
     * function to get single subcategory
     *
     * @return Response
     */
//    public function product_sub_category() {
//        return $this->belongsTo('App\ProductSubCategory', 'id','product_id');
//    }

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

    /**
     * function to get category 
     *
     * @return Response
     */
    public function get_category() {
        return $this->hasOne('App\Category', 'id', 'category_id');
    }

    /**
     * function to get vehicle model 
     *
     * @return Response
     */
    public function get_sub_category() {
        return $this->hasOne('App\SubCategory', 'id', 'sub_category_id');
    }

    public static function count_product_by_catId($cat_id = null, $make_id = null, $model_id = null, $keyword = null) {
        if (($keyword != null || $cat_id != null || $make_id != null || $model_id != null)) {
            $products = Product::with(['product_details', 'get_sub_category', 'get_brands', 'get_vehicle_company', 'get_vehicle_model'])
                            ->Where([['products.quantity', '>', 0], ['status', '=', 1]])
                            ->Where(function($query) use($keyword, $cat_id,$make_id,$model_id) {
                                if ($cat_id != null)
                                    $query->Where('sub_category_id', '=', $cat_id);
                                if ($make_id != null)
                                    $query->Where('vehicle_make_id', '=', $make_id);
                                if ($model_id != null)
                                    $query->Where('vehicle_model_id', '=', $model_id);
                                if (!is_numeric($keyword) && $keyword != null) {
                                    $query->whereRaw("MATCH(product_name) AGAINST(? IN BOOLEAN MODE)", [$keyword]);
                                    $query->orWhere('products.sku', 'LIKE', $keyword . '%');
                                } elseif ($keyword != null) {
                                    $query->Where('products.price', 'LIKE', $keyword . '%');
                                }
                            })->orWhere(function($query) use($keyword) {
                        if ($keyword != null) {
                            $query->WhereHas('product_details', function ($q) use ($keyword) {
                                $q->where('product_details.oem_number', 'LIKE', '%' . $keyword . '%')
                                        ->orwhere('product_details.parse_link', 'LIKE', '%' . $keyword . '%');
                            });
                        }
                    })->orWhere(function($query) use($keyword) {
                        if ($keyword != null) {
                            $query->WhereHas('get_brands', function ($q) use($keyword) {
                                $q->where('brands.name', 'LIKE', '%' . $keyword . '%');
                            });
                        }
                    })->orWhere(function($query) use($keyword) {
                        if ($keyword != null) {
                            $query->WhereHas('get_vehicle_company', function ($q) use($keyword) {
                                $q->where('vehicle_companies.name', 'LIKE', '%' . $keyword . '%');
                            });
                        }
                    })->orWhere(function($query) use($keyword) {
                        if ($keyword != null) {
                            $query->WhereHas('get_vehicle_model', function ($q) use($keyword) {
                                $q->where('vehicle_models.name', 'LIKE', '%' . $keyword . '%');
                            });
                        }
                    })->orWhere(function($query) use ($keyword) {
                        if ($keyword != null) {
                            $query->orWhereHas('get_sub_category', function($q) use ($keyword) {
                                $q->Where('sub_categories.name', 'LIKE', '%' . $keyword . '%');
                            });
                        }
                    })->count();
        } else {
            $products = Product::with(['product_details', 'get_sub_category', 'get_brands', 'get_vehicle_company', 'get_vehicle_model'])->Where([['products.quantity', '>', 0], ['status', '=', 1]])->count();
        }

        return $products;
    }

}
