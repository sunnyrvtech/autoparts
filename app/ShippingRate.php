<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShippingRate extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'country_id', 'low_weight', 'high_weight', 'price'
    ];

    public function get_country() {
        return $this->hasOne('App\Country', 'id', 'country_id');
    }

}
