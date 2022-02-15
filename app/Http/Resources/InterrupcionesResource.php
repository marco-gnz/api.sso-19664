<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class InterrupcionesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $inicio  = Carbon::parse($this->inicio_interrupcion);
        $termino = Carbon::parse($this->termino_interrupcion);

        return [
            'id'                => $this->id,
            'uuid_devolucion'   => $this->devolucion->uuid,
            'tipo'              => 'INTERRUPCIÓN',
            'fecha_inicio'      => $this->inicio_interrupcion,
            'fecha_termino'     => $this->termino_interrupcion,
            'diferencia'        => $inicio->diff($termino),
            'color'             => $this->devolucion->color,
            'observacion'       => $this->observacion,
            'devolucion_id'     => $this->devolucion_id,
            'causal'            => $this->causal->nombre,
            'fecha_add'         => $this->fecha_add,
            'user_add'          => $this->userAdd->sigla
        ];
    }
}
