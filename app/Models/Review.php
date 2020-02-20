<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\User;

class Review extends Model
{
    protected $fillable = [
        'user_id',      //integer(Foreign key for users id)
        'product_id',   //integer(Foreign key for products id)
        'rating',       //tinyinteger
        'description'   //varchar(191)
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
