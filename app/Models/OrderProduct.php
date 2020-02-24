<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    protected $table = 'order_product';

    protected $fillable = [
        'order_id',     //integer(Foreign key for orders id)
        'product_id',   //integer(Foreign key for Products id)
        'quantity'      //integer
    ];
}
