<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Order;

class OrderMeta extends Model
{
    protected $fillable = [
        'order_id',         //integer(Foreign key for orders id)
        'name_on_card',     //varchar 
        'payment_gateway',  //varchar
        'success',          //varchar(nullable)
        'error'             //varchar(nullable)
    ];

    public function order()
    {
    	return $this->belongsTo(Order::class);
    }

}
