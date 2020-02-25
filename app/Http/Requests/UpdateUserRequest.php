<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class UpdateUserRequest extends FormRequest
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
            'email'    => 'required|email|string|max:191|unique:users,email,'.auth('api')->user()->id,
            'phone'    => 'required|numeric|digits:10',
            'password' => 'sometimes|nullable|string|min:6|confirmed',
        ];
    }
}
