<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Especialidad extends Model
{
    use HasFactory;

    protected $table = "especialidads";
    protected $primaryKey = 'id';

    protected $fillable = ['uuid', 'fecha_registro', 'inicio_formacion', 'termino_formacion', 'contabilizar_periodo', 'aumentar', 'aumentar_observacion', 'observacion', 'origen', 'profesional_id', 'centro_formador_id', 'perfeccionamiento_id', 'campo_clinico_id', 'situacion_profesional_id', 'usuario_add_id', 'fecha_add', 'usuario_update_id', 'fecha_update'];

    protected $guarded = ['id'];

    public function profesional()
    {
        return $this->hasOne(Profesional::class, 'id', 'profesional_id');
    }

    public function campoClinico()
    {
        return $this->hasOne(CampoClinico::class, 'id', 'campo_clinico_id');
    }

    public function centroFormador()
    {
        return $this->hasOne(CentroFormador::class, 'id', 'centro_formador_id');
    }

    public function situacionProfesional()
    {
        return $this->hasOne(SituacionActual::class, 'id', 'situacion_profesional_id');
    }

    public function perfeccionamiento()
    {
        return $this->hasOne(Perfeccionamiento::class, 'id', 'perfeccionamiento_id');
    }

    public function paos()
    {
        return $this->hasMany(Pao::class);
    }

    public function escrituras()
    {
        return $this->hasMany(Escritura::class);
    }

    public function convenios()
    {
        return $this->hasMany(Convenio::class);
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
        static::creating(function ($especialidad) {
            $especialidad->uuid = Str::uuid();
        });
    }

    public function totalDevolver()
    {
        $fecha_inicio   = Carbon::parse($this->inicio_formacion);
        $fecha_termino  = Carbon::parse($this->termino_formacion)->addDays(1);

        $diferencia = $fecha_inicio->diff($fecha_termino);

        // Duplicar la diferencia
        $doble_anios = $diferencia->y * 2;
        $doble_meses = $diferencia->m * 2;
        $doble_dias = $diferencia->d * 2;

        // Ajustar días y meses si es necesario
        while ($doble_dias >= 30) {
            $doble_meses++;
            $doble_dias -= 30;
        }

        while ($doble_meses >= 12) {
            $doble_anios++;
            $doble_meses -= 12;
        }

        // Formatear la salida
        $resultado = sprintf(
            '%d años, %d meses y %d días',
            $doble_anios,
            $doble_meses,
            $doble_dias
        );

        return $resultado;
    }
}
