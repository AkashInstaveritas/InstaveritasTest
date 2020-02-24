<?php

namespace App\Http\Transformers;

use App\Models\Product;
use App\User;
use App\Models\Wishlist;
use Illuminate\Support\Collection;
use App\Transformers\Transformer;
use Illuminate\Database\Eloquent\Model;

class WishlistTransformer extends Transformer
{
    //Transform wishlist based on authenticated user.
	public function transform($user)
	{
        
        $products = $user->wishlist->transform(function($product) {
                        return [
                            'id'   => $product->id,
                            'name' => $product->name,
                            'image' => $product->image,
                        ];
                    });

        return $products->all();
    }

}