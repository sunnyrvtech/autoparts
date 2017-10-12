<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model {

    protected $fillable = ['order_id','track_id', 'product_id','product_name','sku_number', 'quantity', 'total_price', 'discount'];

    
    
     /**
     * function to get product detail from order table.
     *
     * @return Response
     */
    public function getProduct() {
        return $this->hasOne('App\Product', 'id', 'product_id');
    }
}
