<?php

namespace App\Http\Transformers;

use App\Models\Address;
use Illuminate\Support\Collection;
use App\Transformers\Transformer;
use Illuminate\Database\Eloquent\Model;

class AddressTransformer extends Transformer
{
    //Transform address based on the selection of address.
    public function transform($address, $includeExtras)
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
    

}