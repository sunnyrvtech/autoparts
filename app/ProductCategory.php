<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model {
    
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_id', 'category_id'
    ];
    
    
    
    /**
     * function to search product based on category name 
     *
     * @return Response
     */

    public function category() {
        return $this->belongsTo('App\Category', 'category_id','id');
    }

}
