<?php

namespace App\Http\Requests\Mantenedores\Establecimiento;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEstablecimientoRequest extends FormRequest
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
            'cod_sirh'                      => ['nullable', Rule::unique('establecimientos', 'cod_sirh')->ignore($this->id)],
            'sigla'                         => ['required', Rule::unique('establecimientos', 'sigla')->ignore($this->id)],
            'nombre'                        => ['required', Rule::unique('establecimientos', 'nombre')->ignore($this->id)],
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
