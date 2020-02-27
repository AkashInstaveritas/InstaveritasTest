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
	public function transform($wishlist, $includeExtras)
	{   
        return [
            'id'    => $wishlist->id,
            'name'  => $wishlist->name,
            'image' => $wishlist->image,
            'price' => $wishlist->price,
        ];

    }

}