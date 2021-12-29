<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
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
            'password'              => ['required'],
            'new_password'          => ['required', 'min:3'],
            'confirm_new_password'  => ['required']
        ];
    }

    public function messages()
    {
        return [
            'password.required'                 => 'La :attribute es obligatoria',
            'new_password.required'             => 'La :attribute es obligatoria',
            'confirm_new_password.required'     => 'La :attribute es obligatoria'
        ];
    }

    public function attributes()
    {
        return [
           'password'                  => 'contraseña actual',
           'new_password'              => 'nueva contraseña',
           'confirm_new_password'      => 'confirmación de contraseña',
        ];
    }
}
