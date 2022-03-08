<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class EtapaDestinacion extends Model
{
    use HasFactory;

    protected $table = "etapa_destinacions";
    protected $primaryKey = 'id';

    protected $fillable = ['uuid', 'inicio_periodo', 'termino_periodo', 'aumentar', 'aumentar_observacion', 'observacion', 'profesional_id', 'establecimiento_id', 'grado_complejidad_establecimiento_id', 'unidad_id', 'situacion_profesional_id', 'usuario_add_id', 'aumentar', 'fecha_add', 'usuario_update_id', 'fecha_update'];

    public function profesional()
    {
        return $this->hasOne(Profesional::class, 'id', 'profesional_id');
    }

    public function establecimiento()
    {
        return $this->hasOne(Establecimiento::class, 'id', 'establecimiento_id');
    }

    public function gradoComplejidadEstablecimiento()
    {
        return $this->hasOne(GradoComplejidad::class, 'id', 'grado_complejidad_establecimiento_id');
    }

    public function unidad()
    {
        return $this->hasOne(Unidad::class, 'id', 'unidad_id');
    }

    public function situacionProfesional()
    {
        return $this->hasOne(SituacionActual::class, 'id', 'situacion_profesional_id');
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
        static::creating(function ($etapaDestinacion) {
            $etapaDestinacion->uuid = Str::uuid();
        });
    }
}
