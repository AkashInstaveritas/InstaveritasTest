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
            'email'         => 'required|email|string|max:191',
            'phone'         => 'required|numeric|digits:10',
            'address_id'    => 'required|integer',
            'type'          => 'in:cod,prepaid',
            'discount'      => 'nullable|integer',
            'discount_code' => 'nullable|',
            'tax'           => 'nullable|integer',
            'subtotal'      => 'nullable|integer',
            'total'         => 'nullable|integer',
        ];
    }
}
