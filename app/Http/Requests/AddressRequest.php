<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
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
        switch($this->method())
        {
            //Validation when the user is adding a new address to its account.
            case 'POST':
            {
                return [
                    'name' => 'required|string|max:191|min:3|unique:addresses',
                    'landmark' => 'nullable|string|max:191|min:3',
                    'city' => 'required|string|max:191',
                    'pincode' => 'required|numeric|digits:6',
                    'state' => 'required|string|max:191|min:2',
                    'country'=> 'required'
                ];
            }
            
            //Validation when user is editing and updating an existing address for its account.
            case 'PATCH':
            {
                return [
                    'name' => 'required|string|max:191|min:3|unique:addresses,id,'.$this->get('id'),
                    'landmark' => 'nullable|string|max:191|min:3',
                    'city' => 'required|string|max:191',
                    'pincode' => 'required|numeric|digits:6',
                    'state' => 'required|string|max:191|min:2',
                    'country'=> 'required'
                ];
            }

            default:break;
        }
    }
}
