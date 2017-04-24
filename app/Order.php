<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model {

    protected $fillable = ['user_id', 'transaction_id', 'product_id', 'quantity', 'total_price', 'discount', 'order_status'];

    /**
     * function to get customer detail from order table.
     *
     * @return Response
     */
    public function getCustomer() {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    /**
     * function to get product detail from order table.
     *
     * @return Response
     */
    public function getProduct() {
        return $this->hasOne('App\Product', 'id', 'product_id');
    }

}
