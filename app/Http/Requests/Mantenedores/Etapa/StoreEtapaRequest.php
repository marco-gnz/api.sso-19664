<?php

namespace App\Http\Requests\Mantenedores\Etapa;

use Illuminate\Foundation\Http\FormRequest;

class StoreEtapaRequest extends FormRequest
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
            'cod_sirh'                      => 'nullable | unique:etapas',
            'sigla'                         => 'required | unique:etapas',
            'nombre'                        => 'required | unique:etapas',
        ];
    }

    public function messages()
    {
        return [
            'cod_sirh.unique'                           => 'El :attribute ya existe en los registros',

            'sigla.required'                            => 'La :attribute es obligatoria',
            'sigla.unique'                              => 'La :attribute ya existe en los registros',

            'nombre.required'                           => 'El :attribute es obligatorio',
            'nombre.unique'                             => 'El :attribute ya existe en los registros',
        ];
    }

    public function attributes()
    {
        return [
            'cod_sirh'                => 'código en SIRH',
            'sigla'                   => 'sigla',
            'nombre'                  => 'nombre',
        ];
    }
}
