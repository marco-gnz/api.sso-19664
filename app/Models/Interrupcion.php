<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Interrupcion extends Model
{
    use HasFactory;

    protected $table = "interrupcions";
    protected $primaryKey = 'id';

    protected $fillable = ['uuid', 'inicio_interrupcion', 'termino_interrupcion', 'observacion', 'pao_id', 'devolucion_id', 'causal_id', 'usuario_add_id', 'fecha_add', 'usuario_update_id', 'fecha_update'];

    protected $guarded = ['id'];

    public function pao()
    {
        return $this->hasOne(Pao::class, 'id', 'pao_id');
    }

    public function causal()
    {
        return $this->hasOne(Causal::class, 'id', 'causal_id');
    }

    public function devolucion()
    {
        return $this->hasOne(Devolucion::class, 'id', 'devolucion_id');
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
        static::creating(function ($interrupcion) {
            $interrupcion->uuid = Str::uuid();
        });
    }

    function totalInterrupciones()
    {
        $dias_en_anio = 365.2;
        $mes_calcular = 30.42;
        $dias_totales = 0;

        $fecha_inicio = Carbon::parse($this->inicio_interrupcion);
        $fecha_termino = Carbon::parse($this->termino_interrupcion);

        // Diferencia en días, incluyendo el día de inicio (por eso +1)
        $diferencia_dias = $fecha_inicio->diffInDays($fecha_termino) + 1;
        // Sumar los días ponderados
        $dias_totales = $diferencia_dias;



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
