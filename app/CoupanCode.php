<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CoupanCode extends Model
{
    protected $fillable = ['coupon_name', 'code','usage','coupon_type','product_sku','discount','expiration_date', 'status'];

}
