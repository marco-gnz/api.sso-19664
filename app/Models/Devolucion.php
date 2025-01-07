<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Devolucion extends Model
{
    use HasFactory;

    protected $table = "devolucions";
    protected $primaryKey = 'id';

    protected $fillable = ['uuid', 'inicio_devolucion', 'termino_devolucion', 'observacion', 'color', 'tipo_contrato', 'pao_id', 'profesional_id', 'establecimiento_id', 'escritura_id', 'usuario_add_id', 'fecha_add', 'usuario_update_id', 'fecha_update'];

    protected $guarded = ['id'];

    public function pao()
    {
        return $this->hasOne(Pao::class, 'id', 'pao_id');
    }

    public function profesional()
    {
        return $this->hasOne(Profesional::class, 'id', 'profesional_id');
    }

    public function tipoContrato()
    {
        return $this->hasOne(TipoContratos::class, 'id', 'tipo_contrato');
    }

    public function establecimiento()
    {
        return $this->hasOne(Establecimiento::class, 'id', 'establecimiento_id');
    }

    public function escritura()
    {
        return $this->hasOne(Escritura::class, 'id', 'escritura_id');
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
        static::creating(function ($devolucion) {
            $devolucion->uuid = Str::uuid();
        });
    }

    public function totalDevuelto()
    {
        $dias_en_anio = 365.2;
        $mes_calcular = 30.42;
        $total_devoluciones = 0;

            $fecha_inicio   = Carbon::parse($this->inicio_devolucion);
            $fecha_termino  = Carbon::parse($this->termino_devolucion);
            $diff           = $fecha_inicio->diffInDays($fecha_termino);
            $hora               = $this->tipoContrato->horas;
            $hora_real          = $hora / 44;

            $total_devoluciones = ($diff + 1) * $hora_real;


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
}
