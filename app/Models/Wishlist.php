<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    protected $fillable = [
        'user_id',      //integer(foreign key for users id)
        'product_id'    //integer(foreign key for products id)
    ];

    
}
