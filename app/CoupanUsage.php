<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CoupanUsage extends Model
{
    protected $fillable = ['user_id', 'coupan_id','usage'];
}
