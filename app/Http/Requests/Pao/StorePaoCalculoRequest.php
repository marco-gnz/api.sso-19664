<?php

namespace App\Http\Requests\Pao;

use Illuminate\Foundation\Http\FormRequest;

class StorePaoCalculoRequest extends FormRequest
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
            'periodo_inicio'                => 'required',
            'periodo_termino'               => 'required',
            'observacion_periodo'           => 'nullable',
            'observacion'                   => 'nullable',
            'especialidad_id'               => 'required'
        ];
    }

    public function messages()
    {
        return [
            'periodo_inicio.required'          => 'El :attribute es obligatorio',
            'periodo_termino.required'         => 'El :attribute es obligatorio',
        ];
    }

    public function attributes()
    {
        return [
            'periodo_inicio'                => 'periodo de PAO',
            'periodo_termino'               => 'periodo de PAO'
        ];
    }
}
