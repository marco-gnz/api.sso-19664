<?php

namespace App\Http\Requests\Documentos\Generico;

use Illuminate\Foundation\Http\FormRequest;

class StoreDocumentoGenericoRequest extends FormRequest
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
            'n_documento'               => 'required',
            'fecha_documento'           => 'required',
            'observacion'               => 'nullable',
            'tipo_documento_id'         => 'required',
            'profesional_uuid'          => 'required'
        ];
    }

    public function messages()
    {
        return [
            'n_documento.required'               => 'El :attribute es obligatorio',
            'n_documento.unique'                 => 'El :attribute ya existe',

            'fecha_documento.required'           => 'La :attribute es obligatorio',

            'tipo_documento_id.required'         => 'El :attribute es obligatorio'
        ];
    }

    public function attributes()
    {
        return [
           'n_documento'          => 'n° documento',
           'fecha_documento'      => 'fecha documento',
           'tipo_documento_id'    => 'tipo de documento'
        ];
    }
}
