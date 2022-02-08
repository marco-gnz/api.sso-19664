<?php

namespace App\Http\Requests\Edf\Destinacion;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDestinacionRequest extends FormRequest
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
            'inicio_periodo'                        => 'required',
            'termino_periodo'                       => 'required',
            'observacion'                           => 'nullable',
            'establecimiento_id'                    => 'required',
            'grado_complejidad_establecimiento_id'  => 'required',
            'unidad_id'                             => 'required',
            'situacion_profesional_id'              => 'required'
        ];
    }

    public function messages()
    {
        return [
            'inicio_periodo.required'           => 'El :attribute es obligatorio',
            'termino_periodo.required'          => 'El :attribute es obligatorio',
            'establecimiento_id.required'       => 'La :attribute es obligatorio',
            'unidad_id.required'                => 'La :attribute es obligatoria',
            'situacion_profesional_id.required' => 'La :attribute es obligatoria'
        ];
    }

    public function attributes()
    {
        return [
            'inicio_periodo'                => 'periodo en destinación',
            'termino_periodo'               => 'periodo en destinación',
            'establecimiento_id'            => 'establecimiento',
            'unidad_id'                     => 'unidad',
            'situacion_profesional_id'      => 'situación de profesional'
        ];
    }
}
