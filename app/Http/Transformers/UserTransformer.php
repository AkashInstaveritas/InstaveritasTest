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
    //Transform the user.
    public function transform($user)
    {        
        return [
            'fullname' => $user->name,
            'email' => $user->email,
        ];   
    }
    

}