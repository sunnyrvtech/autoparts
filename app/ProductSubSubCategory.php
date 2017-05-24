<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductSubSubCategory extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_id', 'sub_sub_category_id'
    ];

}
