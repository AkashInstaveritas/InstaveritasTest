<?php

namespace App\Http\Transformers;

use App\Models\Product;
use App\User;
use Illuminate\Support\Collection;
use App\Transformers\Transformer;
use Illuminate\Database\Eloquent\Model;
use App\Http\Transformers\UserTransformer;

class CartTransformer extends Transformer
{
    //Transform cart based on the authenticated user along with all the products and the total price.
    public function transform($cart, $includeExtras)
	{
        return [
            'id'   => $cart->id,
            'name' => $cart->name,
            'image' => $cart->image,
            'price' => $cart->price,
            'quantity' => $cart->pivot->quantity,
            'total' => $cart->price * $cart->pivot->quantity,
        ];

	}

}