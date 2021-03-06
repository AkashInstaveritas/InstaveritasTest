<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = ['user_id', 'name', 'landmark', 'city', 'pincode', 'state', 'country'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
