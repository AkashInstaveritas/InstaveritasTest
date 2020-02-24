<?php

namespace App\Http\Transformers;

use App\User;
use App\Models\Address;
use Illuminate\Support\Collection;
use App\Transformers\Transformer;
use Illuminate\Database\Eloquent\Model;
use App\Http\Transformers\UserTransformer;

class AddressTransformer extends Transformer
{
    private $userCartTransformer;

    public function __construct(UserTransformer $userCartTransformer)
    {
		$this->userCartTransformer = $userCartTransformer;
    }
    
    //Transform address based on the selection of address.
    public function transform($address)
    {
        return [
            'id'   => $address->id,
            'name' => $address->name,
            'landmark' => $address->landmark,
            'city' => $address->city,
            'pincode' => $address->pincode,
            'state' => $address->state,
            'country' => $address->country,
        ];
    }
    
    //Transform collection of address based on authenticaed user.
    public function transformCollection($user)
	{
        $addresses = $user->addresses->transform(function($address) {
            return [
                'id'   => $address->id,
                'name' => $address->name,
                'landmark' => $address->landmark,
                'city' => $address->city,
                'pincode' => $address->pincode,
                'state' => $address->state,
                'country' => $address->country,
            ];
        });

        return $addresses->all();
    }
    

}