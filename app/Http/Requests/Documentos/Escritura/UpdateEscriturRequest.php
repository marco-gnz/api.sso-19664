<?php

namespace App\Http\Requests\Documentos\Escritura;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEscriturRequest extends FormRequest
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
            'escritura_firmada'         => 'nullable',
            'valor_garantia'            => 'required | numeric',
            'n_resolucion'              => ['required', Rule::unique('escrituras', 'n_resolucion')->ignore($this->id)],
            'fecha_resolucion'          => 'required',
            'observacion'               => 'nullable',
            'especialidad_id'           => 'required'
        ];
    }

    public function messages()
    {
        return [
            'valor_garantia.required'               => 'La :attribute es obligatorio',
            'n_resolucion.required'                 => 'La :attribute es obligatorio',
            'fecha_resolucion.required'             => 'La :attribute es obligatorio',
            'especialidad_id.required'              => 'La :attribute es obligatorio',
        ];
    }

    public function attributes()
    {
        return [
            'valor_garantia'          => 'valor de garantía',
            'n_resolucion'            => 'n° de resolución',
            'fecha_resolucion'        => 'fecha de resolución',
            'especialidad_id'         => 'especialidad'
        ];
    }
}
