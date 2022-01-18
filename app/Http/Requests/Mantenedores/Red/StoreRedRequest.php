<?php

namespace App\Http\Requests\Mantenedores\Red;

use Illuminate\Foundation\Http\FormRequest;

class StoreRedRequest extends FormRequest
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
            'cod_sirh'                      => 'nullable | unique:red_hospitalarias',
            'nombre'                        => 'required | unique:red_hospitalarias',
            'sigla'                        => 'required | unique:red_hospitalarias',
        ];
    }

    public function messages()
    {
        return [
            'cod_sirh.unique'                         => 'El :attribute ya existe en los registros',

            'nombre.required'                         => 'El :attribute es obligatorio',
            'nombre.unique'                           => 'El :attribute ya existe en los registros',

            'sigla.required'                         => 'La :attribute es obligatoria',
            'sigla.unique'                           => 'La :attribute ya existe en los registros',
        ];
    }

    public function attributes()
    {
        return [
            'cod_sirh'                => 'código en SIRH',
            'nombre'                  => 'nombre',
            'sigla'                  => 'sigla'
        ];
    }
}
