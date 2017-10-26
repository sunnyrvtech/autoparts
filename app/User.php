<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\ResetNotification;

class User extends Authenticatable {

    use HasApiTokens,
        Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'verify_token', 'user_image', 'status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function sendPasswordResetNotification($token) {
        $username = $this->first_name . ' ' . $this->last_name;
        $this->notify(new ResetNotification($token, $username));
    }

    public function getShippingDetails() {
        return $this->belongsTo('App\ShippingAddress', 'id', 'user_id');
    }
    public function getBillingDetails() {
        return $this->belongsTo('App\BillingAddress', 'id', 'user_id');
    }
    

}
