<?php

namespace App\Http\Requests\Director;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class ChangeUserRoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Gate::allows(env('IS_DIRECTOR'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => ['required', 'integer', 'min:2', 'exists:users,id',function ($attribute, $value, $fail) {
        if (User::find($value)->role_id == 2) {
            return $fail(__('Вы не имеете прав менять этому пользователю должность!'));
        }
    }],
            'role_id' => ['required', 'integer', 'min:3', 'exists:roles,role_id'],
        ];
    }
}
