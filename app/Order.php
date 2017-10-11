<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model {

    protected $fillable = ['user_id','track_id', 'transaction_id','total_price','ship_price','tax_rate', 'order_status'];

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
