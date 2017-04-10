<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
     protected $fillable = ['name', 'category_image','status'];
     
     
      public function sub_categories() {
        return $this->hasMany('App\SubCategory');
    }

     
}
