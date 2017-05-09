<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    //
    
    public function get_countries() {
        return $this->hasOne('App\Country','id','country_id');
    }

}
