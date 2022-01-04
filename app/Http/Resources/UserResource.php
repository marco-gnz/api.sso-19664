<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    //$wrap en null, para eliminar key "data" en la respuesta, ya que no es una collection, si no un objeto.
    public static $wrap = null;
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'rut'                   => $this->rut,
            'dv'                    => $this->dv,
            'rut_completo'          => $this->rut_completo,
            'primer_nombre'         => $this->primer_nombre,
            'segundo_nombre'        => $this->segundo_nombre,
            'apellido_materno'      => $this->apellido_materno,
            'apellido_paterno'      => $this->apellido_paterno,
            'sigla'                 => $this->sigla,
            'email'                 => $this->email,
            'estado'                => $this->estado,
            'roles'                 => $this->getRoleNames(),
            'permissions'           => $this->getPermissionNames(),
            'permissions_roles'     => $this->getPermissionsViaRoles()->pluck('name')
        ];
    }
}
