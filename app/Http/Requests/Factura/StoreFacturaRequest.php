<?php

namespace App\Http\Requests\Factura;

use Illuminate\Foundation\Http\FormRequest;

class StoreFacturaRequest extends FormRequest
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
            'n_resolucion'              => 'required',
            'fecha_resolucion'          => 'required',
            'n_factura'                 => 'required',
            'fecha_emision_factura'     => 'required',
            'fecha_vencimiento_factura' => 'nullable',
            'cargo_item'                => 'nullable',
            'anios_pago'                => 'required',
            'monto_total'               => 'required',
            'tipo_contrado_id'          => 'required',
            'situacion_factura_id'      => 'required',
            'convenio_id'               => 'required',
            'red_hospitalaria_id'       => 'required',
            'tipo_factura'              => 'required',
            'observacion'               => 'nullable'
        ];
    }

    public function messages()
    {
        return [
            'n_resolucion.required'           => 'El :attribute es obligatorio',
            'n_resolucion.unique'             => 'El :attribute ya existe',

            'fecha_resolucion.required'       => 'La :attribute es obligatoria',
            'n_factura.required'              => 'El :attribute es obligatorio',
            'n_factura.unique'                => 'El :attribute ya existe',

            'fecha_emision_factura.required'  => 'La :attribute es obligatoria',
            'anios_pago.required'             => 'El :attribute es obligatorio',
            'monto_total.required'            => 'El :attribute es obligatorio',
            'tipo_contrado_id.required'       => 'El :attribute es obligatorio',
            'situacion_factura_id.required'   => 'El :attribute es obligatorio',
            'convenio_id.required'            => 'El :attribute es obligatorio',
            'red_hospitalaria_id.required'    => 'El :attribute es obligatorio',
            'tipo_factura.required'           => 'El :attribute es obligatorio',
        ];
    }

    public function attributes()
    {
        return [
           'n_resolucion'                 => 'N° resolución',
           'fecha_resolucion'             => 'fecha de resolución',
           'n_factura'                    => 'N° factura',
           'fecha_emision_factura'        => 'fecha emisión',
           'anios_pago'                   => 'año de pago',
           'monto_total'                  => 'monto',
           'tipo_contrado_id'             => 'tipo de contrato',
           'situacion_factura_id'         => 'situación actual',
           'convenio_id'                  => 'convenio',
           'red_hospitalaria_id'          => 'red hospitalaria',
           'tipo_factura'                 => 'tipo factura'
        ];
    }
}
