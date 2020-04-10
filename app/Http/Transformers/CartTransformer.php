<?php

namespace App\Http\Transformers;

use Illuminate\Support\Collection;
use App\Transformers\Transformer;

class CartTransformer extends Transformer
{
    //Transform cart based on the authenticated user along with all the products and the total price.
    public function transform($cart, $includeExtras)
	{
        return [
            'id'   => $cart->id,
            'name' => $cart->name,
            'image' => $cart->image,
            'rating' => $cart->averageRating(),
            'detail' => $cart->detail,
            'price' => $cart->price,
            'quantity' => $cart->pivot->quantity,
            'total' => $cart->price * $cart->pivot->quantity,
        ];
	}

}
