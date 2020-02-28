<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class CreateWishlistRequest extends FormRequest
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
     * Validation rules when user is adding product in its wishlist.
     * @return array
     */
    public function rules()
    {
        return [
            'product_id' => 'required|exists:products,id|unique:wishlists,product_id,'.auth('api')->user()->id, 
        ];
    }
}