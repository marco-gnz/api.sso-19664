<?php

namespace App\Http\Requests\Mantenedores\Etapa;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEtapaRequest extends FormRequest
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
            'cod_sirh'                      => ['nullable', Rule::unique('etapas', 'cod_sirh')->ignore($this->id)],
            'sigla'                         => ['required', Rule::unique('etapas', 'sigla')->ignore($this->id)],
            'nombre'                        => ['required', Rule::unique('etapas', 'nombre')->ignore($this->id)],
        ];
    }

    public function messages()
    {
        return [
            'cod_sirh.unique'                         => 'El :attribute ya existe en los registros',

            'sigla.required'                          => 'La :attribute es obligatoria',
            'sigla.unique'                            => 'La :attribute ya existe en los registros',

            'nombre.required'                         => 'El :attribute es obligatorio',
            'nombre.unique'                           => 'El :attribute ya existe en los registros',
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
