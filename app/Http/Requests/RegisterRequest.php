<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
//    public function authorize()
//    {
//        return false;
//    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:22'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'code' => ['nullable', 'string', 'min:3', 'max:26', 'unique:users'],
            'phone' => ['required', 'regex:/^(8)[0-9]{10}$/'],
            'password' => ['required', 'string', 'min:8', 'max:20', 'confirmed'],
        ];
    }
}
