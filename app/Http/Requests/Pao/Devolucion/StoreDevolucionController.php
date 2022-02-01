<?php

namespace App\Http\Requests\Pao\Devolucion;

use Illuminate\Foundation\Http\FormRequest;

class StoreDevolucionController extends FormRequest
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
            'inicio_devolucion'             => 'required',
            'termino_devolucion'            => 'required',
            'observacion'                   => 'nullable',
            'color'                         => 'required',
            'tipo_contrato'                 => 'required',
            'pao_id'                        => 'required',
            'establecimiento_id'            => 'required'
        ];
    }

    public function messages()
    {
        return [
            'inicio_devolucion.required'            => 'El :attribute es obligatorio',
            'termino_devolucion.required'           => 'El :attribute es obligatorio',
            'tipo_contrato.required'                => 'El :attribute es obligatorio',
            'establecimiento_id.required'           => 'El :attribute es obligatorio',
        ];
    }

    public function attributes()
    {
        return [
            'inicio_devolucion'                => 'inicio devolución',
            'termino_devolucion'               => 'término devolución',
            'tipo_contrato'                    => 'tipo de contrato (horas)',
            'establecimiento_id'               => 'establecimiento'
        ];
    }
}
