<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class DevolucionesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $inicio  = Carbon::parse($this->inicio_devolucion);
        $termino = Carbon::parse($this->termino_devolucion);

        return [
            'id'                => $this->id,
            'uuid'              => $this->uuid,
            'tipo'              => 'DEVOLUCIÓN',
            'fecha_inicio'      => $this->inicio_devolucion,
            'fecha_termino'     => $this->termino_devolucion,
            'diferencia'        => $inicio->diff($termino),
            'observacion'       => $this->observacion,
            'color'             => $this->color,
            'tipo_contrato'     => $this->tipoContrato->nombre,
            'establecimiento'   => $this->establecimiento->nombre,
            'red'               => $this->establecimiento->redHospitalaria->sigla,
            'created_at'        => $this->created_at,
            'user_add'          => $this->userAdd->name
        ];
    }
}
