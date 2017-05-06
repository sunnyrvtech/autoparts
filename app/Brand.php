<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model {

    protected $fillable = ['name', 'brand_image'];

    /**
     * function to get product detail based on brand id.
     *
     * @return Response
     */
    public function getProducts() {
        return $this->hasMany('App\Product', 'brand_id', 'id');
    }

}
