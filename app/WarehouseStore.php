<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WarehouseStore extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'store_name','email','address', 'country', 'state','city','zip','latitude','longitude','status',
    ];
}
