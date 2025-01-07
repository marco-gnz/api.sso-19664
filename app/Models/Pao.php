<?php

namespace App\Models;

use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Pao extends Model
{
    use HasFactory;

    protected $table = "paos";
    protected $primaryKey = 'id';

    protected $fillable = ['uuid', 'periodo_inicio', 'periodo_termino', 'observacion_periodo', 'estado', 'observacion', 'especialidad_id', 'usuario_add_id', 'fecha_add', 'usuario_update_id', 'fecha_update'];

    protected $guarded = ['id'];

    public function especialidad()
    {
        return $this->hasOne(Especialidad::class, 'id', 'especialidad_id');
    }

    public function devoluciones()
    {
        return $this->hasMany(Devolucion::class);
    }

    public function interrupciones()
    {
        return $this->hasMany(Interrupcion::class);
    }

    public function userAdd()
    {
        return $this->hasOne(User::class, 'id', 'usuario_add_id');
    }

    public function userUpdate()
    {
        return $this->hasOne(User::class, 'id', 'usuario_update_id');
    }

    public static function booted()
    {
        static::creating(function ($pao) {
            $pao->uuid = Str::uuid();
        });
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($pao) { // before delete() method call this
            $pao->devoluciones()->delete();
            $pao->interrupciones()->delete();
            // do the rest of the cleanup...
        });
    }

    public function totalDevuelto()
    {
        $dias_en_anio = 365.2;
        $mes_calcular = 30.42;
        $total_devoluciones = 0;

        foreach ($this->devoluciones as $devolucion) {
            $fecha_inicio   = Carbon::parse($devolucion->inicio_devolucion);
            $fecha_termino  = Carbon::parse($devolucion->termino_devolucion);
            $diff           = $fecha_inicio->diffInDays($fecha_termino);
            $hora               = $devolucion->tipoContrato->horas;
            $hora_real          = $hora / 44;

            $total_devoluciones += ($diff + 1) * $hora_real;
        }

        $sum_devoluciones   = $total_devoluciones;
        $years              = floor($sum_devoluciones / $dias_en_anio);
        $months             = floor(($sum_devoluciones - ($years * $dias_en_anio)) / $mes_calcular);
        $days               = round(($sum_devoluciones - ($years * $dias_en_anio) - ($months * $mes_calcular)), 1);

        $resultado = sprintf(
            '%d años, %d meses y %.1f días',
            $years,
            $months,
            $days
        );

        return $resultado;
    }

    function totalInterrupciones()
    {
        $dias_en_anio = 365.2;
        $mes_calcular = 30.42;
        $dias_totales = 0;

        if (!empty($this->interrupciones)) {
            foreach ($this->interrupciones as $interrupcion) {
                $fecha_inicio = Carbon::parse($interrupcion->inicio_interrupcion);
                $fecha_termino = Carbon::parse($interrupcion->termino_interrupcion);

                // Diferencia en días, incluyendo el día de inicio (por eso +1)
                $diferencia_dias = $fecha_inicio->diffInDays($fecha_termino) + 1;
                // Sumar los días ponderados
                $dias_totales += $diferencia_dias;
            }
        }

        $sum_interrupciones   = $dias_totales;
        $years              = floor($sum_interrupciones / $dias_en_anio);
        $months             = floor(($sum_interrupciones - ($years * $dias_en_anio)) / $mes_calcular);
        $days               = round(($sum_interrupciones - ($years * $dias_en_anio) - ($months * $mes_calcular)), 1);

        $resultado = sprintf(
            '%d años, %d meses y %.1f días',
            $years,
            $months,
            $days
        );

        return $resultado;
    }

}
