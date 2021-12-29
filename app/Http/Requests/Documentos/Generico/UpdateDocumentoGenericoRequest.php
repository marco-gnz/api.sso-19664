<?php

namespace App\Http\Requests\Documentos\Generico;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDocumentoGenericoRequest extends FormRequest
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
            'n_documento'               => ['required', Rule::unique('documento_genericos', 'n_documento')->ignore($this->id)],
            'fecha_documento'           => 'required',
            'observacion'               => 'nullable',
            'tipo_documento_id'         => 'required'
        ];
    }

    public function messages()
    {
        return [
            'n_documento.required'               => 'El :attribute es obligatorio',
            'n_documento.unique'                 => 'El :attribute ya existe',

            'fecha_documento.required'           => 'La :attribute es obligatoria',
        ];
    }

    public function attributes()
    {
        return [
           'n_documento'          => 'n° documento',
           'fecha_documento'      => 'fecha de documento'
        ];
    }
}
