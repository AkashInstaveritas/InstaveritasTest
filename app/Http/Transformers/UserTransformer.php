<?php

namespace App\Http\Transformers;

use App\Models\Product;
use App\User;
use App\Models\Wishlist;
use Illuminate\Support\Collection;
use App\Transformers\Transformer;
use Illuminate\Database\Eloquent\Model;
use App\Http\Transformers\ProductTransformer;

class UserTransformer extends Transformer
{
    
    
    public function transform($user)
    {        
        return [
            'fullname' => $user->name,
            'email' => $user->email,
        ];   
    }

	public function transformWishlist($user)
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