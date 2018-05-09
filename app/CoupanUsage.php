<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CoupanUsage extends Model
{
    protected $fillable = ['email', 'coupan_id','usage'];
}
