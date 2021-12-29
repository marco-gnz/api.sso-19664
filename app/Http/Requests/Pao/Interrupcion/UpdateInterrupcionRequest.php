<?php

namespace App\Http\Requests\Pao\Interrupcion;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInterrupcionRequest extends FormRequest
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
            'inicio_interrupcion'           => 'required',
            'termino_interrupcion'          => 'required',
            'observacion'                   => 'nullable',
            'causal_id'                     => 'required',
            'devolucion_id'                 => 'required'
        ];
    }

    public function messages()
    {
        return [
            'inicio_interrupcion.required'      => 'El :attribute es obligatorio',
            'termino_interrupcion.required'     => 'El :attribute es obligatorio',
            'causal_id.required'                => 'El :attribute es obligatorio',
        ];
    }

    public function attributes()
    {
        return [
            'inicio_interrupcion'           => 'periodo de interrupción',
            'termino_interrupcion'          => 'periodo de interrupción',
            'causal_id'                     => 'causal de interrupción'
        ];
    }
}
