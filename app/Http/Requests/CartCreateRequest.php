<?php

namespace App\Http\Requests;
use Auth;

use Illuminate\Foundation\Http\FormRequest;

class CartCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     * Validation rules when user is adding product in its cart.
     * @return array
     */
    public function rules()
    {
        return [
            'product_id' => 'required|exists:products,id|unique:carts,product_id,'.auth('api')->user()->id,
            'quantity'   => 'required|numeric|min:1|max:3' 
        ];
    }
}
