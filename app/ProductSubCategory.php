<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductSubCategory extends Model {
    
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_id', 'sub_category_id'
    ];
    
    /**
     * function to get customer detail from order table.
     *
     * @return Response
     */
    
    public function getProducts(){
        return $this->hasOne('App\Product','id','product_id');
    }

}
