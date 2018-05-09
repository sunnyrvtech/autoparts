<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model {

    protected $fillable = ['user_id', 'transaction_id','email','billing_address','shipping_address','total_price','ship_price','tax_rate','shipping_method','payment_method','coupon_type','discount', 'order_status'];

    /**
     * function to get customer detail from order table.
     *
     * @return Response
     */
    public function getCustomer() {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    /**
     * function to get order detail based on order id.
     *
     * @return Response
     */
    public function getOrderDetails() {
        return $this->hasOne('App\OrderDetail', 'order_id', 'id');
    }
    
    /**
     * function to get order detail based on order id.
     *
     * @return Response
     */
    public function getOrderDetailById() {
        return $this->hasMany('App\OrderDetail', 'order_id', 'id');
    }

}
