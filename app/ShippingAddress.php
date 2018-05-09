<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShippingAddress extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name','last_name','address1', 'user_id', 'address2', 'country_id', 'state_id', 'city', 'zip', 'latitude', 'longitude'
    ];

    public function get_country() {
        return $this->hasOne('App\Country', 'id', 'country_id');
    }

    public function get_state() {
        return $this->hasOne('App\State', 'id', 'state_id');
    }

}
