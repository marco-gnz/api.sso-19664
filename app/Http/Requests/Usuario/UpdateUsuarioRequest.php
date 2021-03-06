<?php

namespace App\Http\Requests\Usuario;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUsuarioRequest extends FormRequest
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
            'rut'                           => ['required', 'min:8', 'max:8', Rule::unique('users', 'rut')->ignore($this->id)],
            'dv'                            => 'required | min:1 | max:1',
            'rut_completo'                  => ['required', 'min:9', 'max:10', Rule::unique('users', 'rut_completo')->ignore($this->id)],
            'primer_nombre'                 => 'required',
            'segundo_nombre'                => 'nullable',
            'apellido_materno'              => 'required',
            'apellido_paterno'              => 'required',
            'nombre_completo'               => 'required',
            'email'                         => ['nullable','email', Rule::unique('users', 'email')->ignore($this->id)],
            'genero_id'                     => 'required',
            'rol'                           => 'required',
            'permisos_extras'               => 'nullable',
            'red_admin'                     => 'required'
        ];
    }

    public function messages()
    {
        return [
            'rut.required'          => 'El :attribute es obligatorio',
            'rut.min'               => 'El :attribute son mínimo :min caracteres',
            'rut.max'               => 'El :attribute son máximo :max caracteres',
            'rut.unique'            => 'El :attribute ya existe en los registros',

            'dv.required'           => 'El :attribute es obligatorio',
            'dv.min'                => 'El :attribute es solo :min caracter',
            'dv.max'                => 'El :attribute es máximo :max caracter',

            'nombres.required'      => 'El :attribute es obligatorio',

            'apellidos.required'    => 'Los :attribute son obligatorios',

            'email.required'        => 'El :attribute es obligatorio',
            'email.email'           => 'El :attribute debe ser un email (Debe incluir @ y punto)',
            'email.unique'          => 'El :attribute ya existe en los registros',

            'n_contacto.required'   => 'El :attribute es obligatorio',
            'n_contacto.unique'     => 'El :attribute ya existe en los registros',

            'ciudad.required'       => 'La :attribute es obligatoria',

            'etapas_id.required'    => 'La :attribute es obligatoria',

            'calidad_juridica_id.required'  => 'La :attribute es obligatoria',

            'planta_id.required'    => 'La :attribute es obligatoria',

            'genero_id.required'    => 'El :attribute es obligatorio',
        ];
    }

    public function attributes()
    {
        return [
            'rut'               => 'rut',
            'dv'                => 'dígito verificador',
            'nombres'           => 'nombre',
            'apellidos'         => 'apellidos',
            'email'             => 'correo electrónico',
            'n_contacto'        => 'n° de contacto',
            'ciudad'            => 'ciudad de residencia',
            'etapas_id'         => 'etapa actual',
            'calidad_juridica_id' => 'calidad jurídica',
            'planta_id'         => 'planta',
            'genero_id'         => 'género'
        ];
    }
}
