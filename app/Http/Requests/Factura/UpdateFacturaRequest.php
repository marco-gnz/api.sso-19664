<?php

namespace App\Http\Requests\Factura;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFacturaRequest extends FormRequest
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
            'situacion_factura_id' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'situacion_factura_id.required'  => 'El :attribute es obligatorio'
        ];
    }

    public function attributes()
    {
        return [
           'situacion_factura_id'  => 'situación actual'
        ];
    }
}
