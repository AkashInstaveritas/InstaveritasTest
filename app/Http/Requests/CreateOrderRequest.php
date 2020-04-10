<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends FormRequest
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
     *
     * @return array
     */
    public function rules()
    {
        return [
            'address_id'    => 'required|integer',
            'discount'      => 'nullable|integer',
            'discount_code' => 'nullable|',
            'tax'           => 'nullable|integer',
            'subtotal'      => 'nullable|integer',
            'total'         => 'nullable|integer',
        ];
    }
}
