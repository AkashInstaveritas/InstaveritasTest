<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\OrderMeta;
use App\Models\Product;
use App\Models\Address;
use App\User;


class Order extends Model
{
    protected $fillable = [
        'user_id',          //integer(Foriegn key for users id)
        'email',            //varchar(191)
        'phone',            //integer
        'address_id',       //integer(Foreign key for addreses id)
        'type',             //enum(cod, prepaid)
        'discount',         //integer(nullable)
        'discount_code',    //varchar(nullable)
        'tax',              //TinyInteger
        'subtotal',         //Integer
        'total',             //Integer
        'status',            //TinyInteger
    ];

    public function products()
    {
    	return $this->belongsToMany(Product::class, 'order_product', 'order_id', 'product_id')->withPivot('quantity');
    }

    public function order_metas()
    {
    	return $this->hasMany(OrderMeta::class);
    }

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function address()
    {
    	return $this->belongsTo(Address::class);
    }

    // public function status()
    // {
    //     if($this->status == 0)
    //     {
    //         return "Order Placed.";
    //     }

    //     if($this->status == 1)
    //     {
    //         return "Order Canceled.";
    //     }

    //     return "Order Delivered.";

    // }
}
