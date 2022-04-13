<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class ProfesionalesExportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $total_especialidad = 0;
        $total_pao = 0;
        $total_devoluciones    = 0;
        $fecha = '';
        $fechas_menores = [];
        $unique_fecha_menor = '';
        $fecha_final = null;
        $dt = '';
        $anios = [];
        $anio_bisiesto = 0;
        $fechas_termino_pao = [];
        $fecha_termino_pao = null;


        if ($this->devoluciones->count() > 0) {
            foreach ($this->especialidades as $especialidad) {
                if ($especialidad->paos->count() > 0) {
                    foreach ($especialidad->paos as $pao) {
                        $fecha_inicio_especialidad   = Carbon::parse($pao->periodo_inicio);
                        $fecha_termino_especialidad  = Carbon::parse($pao->periodo_termino);

                        $diff_especialidad  = $fecha_inicio_especialidad->diffInDays($fecha_termino_especialidad);

                        $total_especialidad += $diff_especialidad + 1;
                        array_push($fechas_termino_pao, $pao->periodo_inicio);
                        if ($pao->devoluciones->count() > 0) {
                            foreach ($pao->devoluciones as $devolucion) {
                                array_push($fechas_termino_pao, $devolucion->termino_devolucion);

                                $fecha_inicio   = Carbon::parse($devolucion->inicio_devolucion);
                                $fecha_termino  = Carbon::parse($devolucion->termino_devolucion);

                                array_push($fechas_menores, $devolucion->inicio_devolucion);
                                array_push($anios, $devolucion->inicio_devolucion);
                                array_push($anios, $devolucion->termino_devolucion);

                                $diff               = $fecha_inicio->diffInDays($fecha_termino);
                                $hora               = $devolucion->tipoContrato->horas;
                                $hora_real          = $hora / 44;

                                $total_devoluciones += ($diff + 1) * $hora_real;
                            }
                        }
                        if ($pao->interrupciones->count() > 0) {
                            foreach ($pao->interrupciones as $interrupcion) {
                                array_push($fechas_termino_pao, $interrupcion->termino_interrupcion);
                            }
                        }
                    }
                }
            }

            $unique_fecha_menor = min($fechas_menores);

            foreach ($anios as $anio) {
                $anio_format = Carbon::parse($anio);

                $days = $anio_format->isLeapYear();

                switch ($days) {
                    case 366:
                        $anio_bisiesto += 1;
                        break;

                    default:
                        $anio_bisiesto;
                        break;
                }
            }
        }

        //total_a_realizar
        $dias_en_anio = 365.2;
        $mes_calcular = 30.42;
        $sum_especialidad = $total_especialidad;
        $years_especialidad = floor($sum_especialidad / $dias_en_anio);
        $months_especialidad = floor(($sum_especialidad - ($years_especialidad * $dias_en_anio)) / $mes_calcular);
        $days_especialidad = round(($sum_especialidad - ($years_especialidad * $dias_en_anio) - ($months_especialidad * $mes_calcular)), 1);

        //total_devolucion
        $sum_devoluciones = $total_devoluciones;
        $years = floor($sum_devoluciones / $dias_en_anio);
        $months = floor(($sum_devoluciones - ($years * $dias_en_anio)) / $mes_calcular);
        $days = round(($sum_devoluciones - ($years * $dias_en_anio) - ($months * $mes_calcular)), 1);

        //le_faltan
        $total_falta = $sum_especialidad - $sum_devoluciones;
        $years_falta = floor($total_falta / $dias_en_anio);
        $months_falta = floor(($total_falta - ($years_falta * $dias_en_anio)) / $mes_calcular);
        $days_falta = round(($total_falta - ($years_falta * $dias_en_anio) - ($months_falta * $mes_calcular)), 1);

        if (count($fechas_termino_pao) > 0) {
            $last_date = max($fechas_termino_pao);
            $last_date_format = Carbon::parse($last_date);
            bcdiv($total_falta, '1', 0);
            $fecha_termino_pao = $last_date_format->addDay($total_falta);
        }

        $tex_anio_especialidad  = $years_especialidad   > 1 ? 'años'    : 'año';
        $tex_mes_especialidad   = $months_especialidad  > 1 ? 'meses'   : 'mes';
        $tex_dia_especialidad   = $days_especialidad    > 1 ? 'días'    : 'día';

        $tex_anio_devolucion    = $years   > 1 ? 'años'    : 'año';
        $tex_mes_devolucion     = $months  > 1 ? 'meses'   : 'mes';
        $tex_dia_devolucion     = $days    > 1 ? 'días'    : 'día';

        $tex_anio_falta         = $years_falta   > 1 ? 'años'    : 'año';
        $tex_mes_falta          = $months_falta  > 1 ? 'meses'   : 'mes';
        $tex_dia_falta          = $days_falta    > 1 ? 'días'    : 'día';

        return [
            'rut_completo'                          => $this->rut_completo,
            'nombre_completo'                       => $this->apellidos . ' ' . $this->nombres,
            'genero'                                => $this->genero != null ? $this->genero->nombre : '',
            'planta'                                => $this->planta != null ? $this->planta->nombre : '',
            'etapa'                                 => $this->etapa != null ? $this->etapa->nombre : '',
            'situacionActual'                       => $this->situacionActual != null ? $this->situacionActual->nombre : '',
            'establecimientos'                      => $this->establecimientos != null ? $this->establecimientos->pluck('nombre')->implode(' - ') : '',
            'especialidades'                        => $this->especialidades,
            'devoluciones'                          => $this->devoluciones,
            'destinaciones'                         => $this->destinaciones,
            'total_a_realizar'                      => $this->especialidades->count() > 0 && $this->destinaciones->count() == 0 ? $years_especialidad.' '.$tex_anio_especialidad.', '.$months_especialidad.' '.$tex_mes_especialidad.' y '.$days_especialidad.' '.$tex_dia_especialidad : '',
            'total_devolucion'                      => $this->devoluciones->count() > 0 ? $years.' '.$tex_anio_devolucion.', '.$months.' '.$tex_mes_devolucion.' y '.$days.' '.$tex_dia_devolucion : '',
            'le_faltan'                             => $this->devoluciones->count() > 0 ? $years_falta.' '.$tex_anio_falta.', '.$months_falta.' '.$tex_mes_falta.' y '.$days_falta.' '.$tex_dia_falta : '',
            'termina'                               => $fecha_termino_pao != null ? $fecha_termino_pao->isoFormat('DD-MM-YYYY') : '',
        ];
    }
}
