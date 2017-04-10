<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    protected $fillable = ['category_id','name','category_image'];
    
      public function sub_sub_categories() {
        return $this->hasMany('App\SubSubCategory','sub_category_id','id');
    }
}

