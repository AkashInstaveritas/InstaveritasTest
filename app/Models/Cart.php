<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'carts';
    
    protected $fillable = [
        'user_id',      //integer (Foreign key for users id)
        'product_id',   //integer (Foreign key for products id)
        'quantity'      //integer
    ];

}
