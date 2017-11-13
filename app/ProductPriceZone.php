<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductPriceZone extends Model {

    protected $fillable = ['zone_id', 'product_id', 'product_price'];

}
