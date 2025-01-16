<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Profesional extends Model
{
    use HasFactory;

    protected $table = "profesionals";
    protected $primaryKey = 'id';

    protected $fillable = ['uuid', 'rut', 'dv', 'rut_completo', 'nombres', 'apellidos', 'nombre_completo', 'email', 'n_contacto', 'ciudad', 'direccion_residencia', 'etapas_id', 'situacion_actual_id', 'calidad_juridica_id', 'planta_id', 'estado', 'genero_id', 'usuario_add_id', 'fecha_add', 'usuario_update_id', 'fecha_update'];

    protected $guarded = ['id'];

    public function etapa()
    {
        return $this->hasOne(Etapa::class, 'id', 'etapas_id');
    }

    public function genero()
    {
        return $this->hasOne(Genero::class, 'id', 'genero_id');
    }

    public function planta()
    {
        return $this->hasOne(Planta::class, 'id', 'planta_id');
    }

    public function calidad()
    {
        return $this->hasOne(CalidadJuridica::class, 'id', 'calidad_juridica_id');
    }

    public function convenios()
    {
        return $this->hasMany(Convenio::class);
    }

    public function situacionActual()
    {
        return $this->hasOne(SituacionActual::class, 'id', 'situacion_actual_id');
    }

    public function devoluciones()
    {
        return $this->hasMany(Devolucion::class);
    }

    public function especialidades()
    {
        return $this->hasMany(Especialidad::class);
    }

    public function facturas()
    {
        return $this->hasMany(Factura::class);
    }

    public function etapasDestinacion()
    {
        return $this->hasMany(EtapaDestinacion::class);
    }

    public function destinaciones()
    {
        return $this->hasMany(EtapaDestinacion::class);
    }

    public function establecimiento()
    {
        return $this->hasOne(Establecimiento::class, 'id', 'establecimiento_id');
    }

    public function establecimientos()
    {
        return $this->belongsToMany(Establecimiento::class);
    }

    public function comunas()
    {
        return $this->belongsToMany(Comuna::class);
    }

    public function userAdd()
    {
        return $this->hasOne(User::class, 'id', 'usuario_add_id');
    }

    public function userUpdate()
    {
        return $this->hasOne(User::class, 'id', 'usuario_update_id');
    }

    public function paos()
    {
        return collect($this->especialidades)->flatMap(function ($especialidad) {
            return $especialidad->paos;
        });
    }


    public static function booted()
    {
        static::creating(function ($profesional) {
            $profesional->uuid = Str::uuid();
        });
    }

    //search
    public function scopeGeneral($query, $search)
    {
        if ($search)
            return $query->where('rut_completo', 'like', '%' . $search . '%')->orWhere('nombre_completo', 'like', '%' . $search . '%');
    }
    public function scopeEtapaProfesional($query, $search)
    {
        if ($search)
            return $query->whereIn('etapas_id', $search);
    }
    public function scopeSituacionProfesional($query, $search)
    {
        if ($search)
            return $query->whereIn('situacion_actual_id', $search);
    }

    public function scopeTieneEspecialidades($query, $todas)
    {
        if ($todas === true)
            return $query->has('especialidades', '>', 0);
    }
    public function scopePerfeccionamiento($query, $search)
    {
        if ($search)
            $query->whereHas('especialidades', function ($query) use ($search) {
                $query->whereIn('perfeccionamiento_id', $search);
            });
    }

    public function scopeEstablecimientoProfesional($query, $search)
    {
        if ($search)
            $query->whereHas('establecimientos', function ($query) use ($search) {
                $query->whereIn('establecimiento_profesional.establecimiento_id', $search);
            });
    }

    public function scopeComunaProfesional($query, $search)
    {
        if ($search)
            $query->whereHas('comunas', function ($query) use ($search) {
                $query->whereIn('comuna_profesional.comuna_id', $search);
            });
    }

    public function scopeDestinacion($query, $inicio_f_ed, $termino_f_ed)
    {
        if ($inicio_f_ed && $termino_f_ed)
            $query->whereHas('destinaciones', function ($query) use ($inicio_f_ed, $termino_f_ed) {
                $query->whereBetween('inicio_periodo', array($inicio_f_ed, $termino_f_ed));
            });
    }

    public function scopeFormacion($query, $inicio_f_ef, $termino_f_ef)
    {
        if ($inicio_f_ef && $termino_f_ef)
            $query->whereHas('especialidades', function ($query) use ($inicio_f_ef, $termino_f_ef) {
                $query->where('origen', 'EDF')->whereBetween('inicio_formacion', array($inicio_f_ef, $termino_f_ef));
            });
    }

    public function scopePaos($query, $inicio_f_pao, $termino_f_pao)
    {
        if ($inicio_f_pao && $termino_f_pao)
            $query->whereHas('especialidades', function ($query) use ($inicio_f_pao, $termino_f_pao) {
                $query->whereHas('paos', function ($query) use ($inicio_f_pao, $termino_f_pao) {
                    $query->whereBetween('periodo_inicio', array($inicio_f_pao, $termino_f_pao));
                });
            });
    }

    public function scopeEstablecimi($query, $establecimiento)
    {
        if ($establecimiento)
            $query->whereHas('establecimientos', function ($query) use ($establecimiento) {
                $query->whereIn('establecimiento_profesional.establecimiento_id', $establecimiento);
            })->orWhereHas('destinaciones', function ($query) use ($establecimiento) {
                $query->whereIn('establecimiento_id', $establecimiento);
            })->orWhereHas('devoluciones', function ($query) use ($establecimiento) {
                $query->whereIn('establecimiento_id', $establecimiento);
            });
    }

    public function scopeEstado($query, $search)
    {
        if ($search)
            return $query->whereIn('estado', $search);
    }

    public function statusdestino($horas = 0)
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
        $mes_calcular = 30.46;
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
        $hora_real = $horas != 0 ? (44 / $horas) : 0;
        $total_falta_ok = $total_falta * $hora_real;

        $years_falta = floor($total_falta_ok / $dias_en_anio);
        $months_falta = floor(($total_falta_ok - ($years_falta * $dias_en_anio)) / $mes_calcular);
        $days_falta = round(($total_falta_ok - ($years_falta * $dias_en_anio) - ($months_falta * $mes_calcular)), 1);

        if (count($fechas_termino_pao) > 0) {
            $last_date = max($fechas_termino_pao);
            $last_date_format = Carbon::parse($last_date);
            $fecha_termino_pao = $last_date_format->addDay($total_falta_ok);
        }

        return (object)[
            'termina'                               => $fecha_termino_pao != null ? $fecha_termino_pao->isoFormat('DD/MM/YYYY') : 'Sin registros',
            'total_a_realizar'                      => $this->especialidades->count() > 0 && $this->destinaciones->count() == 0 ? $years_especialidad . ' años, ' . $months_especialidad . ' meses y ' . $days_especialidad . ' días' : 'Sin registros',
            'total_devolucion'                      => $this->devoluciones->count() > 0 ? $years . ' años, ' . $months . ' meses y ' . $days . ' días' : 'Sin registros',
            'le_faltan'                             => $this->devoluciones->count() > 0 ? $years_falta . ' años, ' . $months_falta . ' meses y ' . $days_falta . ' días' : 'Sin registros',
        ];
    }
}
