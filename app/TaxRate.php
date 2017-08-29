<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaxRate extends Model
{
    protected $fillable = ['country_id', 'state_id','price'];
}
