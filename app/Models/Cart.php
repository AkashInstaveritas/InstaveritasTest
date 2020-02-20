<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Cart extends Model
{
    protected $fillable = [
        'user_id',      //integer (Foreign key for users id)
        'product_id',   //integer (Foreign key for products id)
        'quantity'      //integer
    ];

    public function products()
    {
    	return $this->hasMany(Product::class);
    }
}
