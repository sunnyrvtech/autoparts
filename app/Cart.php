<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
     protected $fillable = ['user_id', 'session_id','product_id','quantity','total_price'];
     
     public function get_products(){
        return $this->hasOne('App\Product', 'id', 'product_id');
     }
        
}
