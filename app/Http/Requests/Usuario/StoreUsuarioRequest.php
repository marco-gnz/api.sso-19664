<?php

namespace App\Http\Requests\Usuario;

use Illuminate\Foundation\Http\FormRequest;

class StoreUsuarioRequest extends FormRequest
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
            'rut'                           => 'required | min:8 | max:10',
            'dv'                            => 'required | min:1 | max:1',
            'rut_completo'                  => 'required | unique:users',
            'primer_nombre'                 => 'required',
            'segundo_nombre'                => 'nullable',
            'apellido_materno'              => 'required',
            'apellido_paterno'              => 'required',
            'email'                         => 'required | email | unique:users',
            'genero_id'                     => 'required',
            'rol'                           => 'required',
            'permisos_extras'               => 'nullable',
            'red_admin'                     => 'required'
        ];
    }

    public function messages()
    {
        return [
            'rut.required'                              => 'El :attribute es obligatorio',
            'rut.min'                                   => 'El :attribute son mínimo :min caracteres',
            'rut.max'                                   => 'El :attribute son máximo :max caracteres',

            'rut_completo.unique'                       => 'El :attribute ya existe en los registros',

            'dv.required'                               => 'El :attribute es obligatorio',
            'dv.min'                                    => 'El :attribute es solo :min caracter',
            'dv.max'                                    => 'El :attribute es máximo :max caracter',

            'primer_nombre.required'                    => 'El :attribute es obligatorio',

            'apellido_materno.required'                 => 'El :attribute es obligatorio',

            'apellido_paterno.required'                 => 'El :attribute es obligatorio',

            'email.required'                            => 'El :attribute es obligatorio',
            'email.email'                               => 'El :attribute debe ser un email (Debe incluir @ y punto)',
            'email.unique'                              => 'El :attribute ya existe en los registros',

            'genero_id.required'                        => 'El :attribute es obligatorio',

            'rol.required'                              => 'El :attribute es obligatorio',

            'red_admin.required'                        => 'La :attribute es obligatoria',

        ];
    }

    public function attributes()
    {
        return [
            'rut'                           => 'rut',
            'rut_completo'                  => 'rut completo',
            'dv'                            => 'dígito verificador',
            'primer_nombre'                 => 'nombre',
            'apellido_materno'              => 'apellido materno',
            'apellido_paterno'              => 'apellido paterno',
            'email'                         => 'correo',
            'genero_id'                     => 'genero',
            'rol'                           => 'perfil',
            'red_admin'                     => 'red hospitalaria'
        ];
    }
}
