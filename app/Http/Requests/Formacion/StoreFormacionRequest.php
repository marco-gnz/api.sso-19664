<?php

namespace App\Http\Requests\Formacion;

use Illuminate\Foundation\Http\FormRequest;

class StoreFormacionRequest extends FormRequest
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
            'fecha_registro'            => 'nullable',
            'inicio_formacion'          => 'nullable',
            'termino_formacion'         => 'nullable',
            'origen'                    => 'required',
            'observacion'               => 'nullable | max:100',
            'profesional_id'            => 'required',
            'centro_formador_id'        => 'required',
            'perfeccionamiento_id'      => 'required',
            'situacion_profesional_id'  => 'nullable',
            'aumentar'                  => 'nullable',
            'aumentar_observacion'      => 'nullable',
            'campo_clinico_id'          => 'nullable'
        ];
    }

    public function messages()
    {
        return [
            'fecha_registro.required'           => 'La :attribute es obligatorio',
            'origen.required'                   => 'El :attribute es obligatorio',
            'inicio_formacion.required'         => 'El :attribute es obligatorio',
            'termino_formacion.required'        => 'El :attribute es obligatorio',
            'observacion.max'                   => 'La :attribute son máximo :max caracteres',
            'profesional_id.required'           => 'El :attribute es obligatorio',
            'centro_formador_id.required'       => 'El :attribute es obligatorio',
            'perfeccionamiento_id.required'     => 'El :attribute es obligatorio',
        ];
    }

    public function attributes()
    {
        return [
           'fecha_registro'                 => 'fecha de registro',
           'origen'                         => 'motivo',
           'inicio_formacion'               => 'periodo de formación',
           'termino_formacion'              => 'periodo de formación',
            'centro_formador_id'            => 'centro formador',
            'perfeccionamiento_id'          => 'perfeccionamiento'
        ];
    }
}
