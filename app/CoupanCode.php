<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CoupanCode extends Model
{
    protected $fillable = ['coupan_type', 'code','usage','expiration_date', 'status'];

}
