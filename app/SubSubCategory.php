<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubSubCategory extends Model
{
    protected $fillable = ['sub_category_id', 'vehicle_company_id'];
     public function get_vehicle_company_name() {
        return $this->hasOne('App\VehicleCompany','id','vehicle_company_id');
    }
}
