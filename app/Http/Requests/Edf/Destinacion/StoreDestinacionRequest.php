<?php

namespace App\Http\Requests\Edf\Destinacion;

use Illuminate\Foundation\Http\FormRequest;

class StoreDestinacionRequest extends FormRequest
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
            'profesional_id'                        => 'required',
            'establecimiento_id'                    => 'required',
            'grado_complejidad_establecimiento_id'  => 'required',
            'unidad_id'                             => 'required'
        ];
    }

    public function messages()
    {
        return [
            'inicio_periodo.required'           => 'El :attribute es obligatorio',
            'termino_periodo.required'          => 'El :attribute es obligatorio',
            'establecimiento_id.required'       => 'La :attribute es obligatorio',
            'unidad_id.required'                => 'La :attribute es obligatoria'
        ];
    }

    public function attributes()
    {
        return [
            'inicio_periodo'                => 'periodo en destinación',
            'termino_periodo'               => 'periodo en destinación',
            'establecimiento_id'            => 'establecimiento',
            'unidad_id'                     => 'unidad'
        ];
    }
}
