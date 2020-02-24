<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Address extends Model
{
    protected $fillable = [
        'user_id',  //integer (foreign key for users id)
        'name',     //varchar(191)
        'landmark', //varchar(191) nullable
        'city',     //varchar(191)
        'pincode',  // MediumInteger
        'state',    //varchar(191)
        'country'   //enum (India, china)
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
