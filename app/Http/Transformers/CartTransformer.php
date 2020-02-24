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
    private $userCartTransformer;

    public function __construct(UserTransformer $userCartTransformer)
    {
		$this->userCartTransformer = $userCartTransformer;
    }
    
    //Transform cart based on the authenticated user along with all the products and the total price.
    public function transform($user)
	{
        $totalPrice = [];

        foreach($user->cart as $cart)
        {
            $totalPrice[] = $cart->price * $cart->pivot->quantity;
        }

        return [	
            'products' => $user->cart->transform(function($product) {
                        return [
                            'id'   => $product->id,
                            'name' => $product->name,
                            'image' => $product->image,
                            'price' => $product->price,
                            'quantity' => $product->pivot->quantity,
                        ];
                }),
            'cartTotal'	  => array_sum($totalPrice),                    
        ];
	}

}