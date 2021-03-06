<?php

namespace App\Http\Requests\Documentos\Convenio;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateConvenioRequest extends FormRequest
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
            'anios_arancel'             => 'nullable',
            'valor_arancel'             => 'required',
            'n_resolucion'              => 'required',
            'fecha_resolucion'          => 'required',
            'observacion'               => 'nullable',
            'especialidad_id'           => 'nullable',
            'tipo_convenio_id'          => 'required'
        ];
    }

    public function messages()
    {
        return [
            'anios_arancel.required'            => 'La :attribute es obligatorio',
            'valor_arancel.required'           => 'El :attribute es obligatorio',
            'n_resolucion.required'            => 'El :attribute es obligatorio',
            'n_resolucion.unique'              => 'El :attribute ya existe',
            'fecha_resolucion.required'        => 'La :attribute es obligatoria',
            'especialidad_id.required'         => 'La :attribute es obligatoria',
            'tipo_convenio_id.required'        => 'El :attribute es obligatorio'
        ];
    }

    public function attributes()
    {
        return [
            'anios_arancel'                 => 'año arancel',
            'valor_arancel'                 => 'valor del arancel',
            'n_resolucion'                  => 'n° resolución',
            'fecha_resolucion'              => 'fecha resolución',
            'especialidad_id'               => 'especialidad',
            'tipo_convenio_id'               => 'tipo de convenio'
        ];
    }
}
