<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use stdClass;

class ProfesionalesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $especialidades = [];
        $count_pao  = 0;

        foreach ($this->especialidades as $especialidad) {
            $count_pao          += count($especialidad->paos);
            array_push($especialidades, $especialidad->perfeccionamiento->nombre);
        }

        return [
            'id'                => $this->id,
            'uuid'              => $this->uuid,
            'rut_completo'      => $this->rut_completo,
            'nombres'           => $this->nombres,
            'apellidos'         => $this->apellidos,
            'etapa'             => $this->etapa->sigla,
            'situacion_actual'  => $this->situacionActual->nombre,
            'estado'            => $this->estado,
            'especialidades'    => (count($especialidades) > 0) ? $especialidades : [],
            'count_pao'         => $count_pao,
            'count_ed'          => $this->destinaciones()->count(),
            'count_ef'          => $this->especialidades()->where('origen', 'EDF')->count()
        ];
    }
}
