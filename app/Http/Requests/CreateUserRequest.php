<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
            'name'     => 'required|string|max:191|min:3',
            'email'    => 'required|email|string|max:191|unique:users',
            'phone'    => 'required|numeric|digits:10',
            'password' => 'required|min:6|max:191|confirmed',
        ];
    }
}
