<?php

namespace App\Http\Requests\Mantenedores\Establecimiento;

use Illuminate\Foundation\Http\FormRequest;

class StoreEstablecimientoRequest extends FormRequest
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
            'cod_sirh'                      => 'nullable | unique:establecimientos',
            'sigla'                         => 'required | unique:establecimientos',
            'nombre'                        => 'required | unique:establecimientos',
            'red_hospitalaria_id'           => 'required',
            'grado_complejidad_id'          => 'nullable',
        ];
    }

    public function messages()
    {
        return [
            'cod_sirh.unique'                         => 'El :attribute ya existe en los registros',

            'sigla.required'                          => 'El :attribute es obligatorio',
            'sigla.unique'                            => 'El :attribute ya existe en los registros',

            'nombre.required'                         => 'El :attribute es obligatorio',
            'nombre.unique'                           => 'El :attribute ya existe en los registros',

            'red_hospitalaria_id.required'            => 'El :attribute es obligatorio',

            'grado_complejidad_id.required'           => 'El :attribute es obligatorio',
        ];
    }

    public function attributes()
    {
        return [
            'cod_sirh'                      => 'código en SIRH',
            'sigla'                         => 'nombre',
            'nombre'                        => 'nombre',
            'red_hospitalaria_id'           => 'red',
            'grado_complejidad_id'          => 'grado de complejidad'
        ];
    }
}
