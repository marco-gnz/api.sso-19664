<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Profesional extends Model
{
    use HasFactory;

    protected $table = "profesionals";
    protected $primaryKey = 'id';

    protected $fillable = ['uuid', 'rut', 'dv', 'rut_completo', 'nombres', 'apellidos', 'nombre_completo', 'email', 'n_contacto', 'ciudad', 'etapas_id', 'situacion_actual_id', 'calidad_juridica_id', 'planta_id', 'estado', 'genero_id', 'usuario_add_id', 'fecha_add', 'usuario_update_id', 'fecha_update'];

    protected $guarded = ['id'];

    public function etapa()
    {
        return $this->hasOne(Etapa::class, 'id', 'etapas_id');
    }

    public function calidad()
    {
        return $this->hasOne(CalidadJuridica::class, 'id', 'calidad_juridica_id');
    }

    public function especialidades()
    {
        return $this->hasMany(Especialidad::class);
    }

    public function facturas()
    {
        return $this->hasMany(Factura::class);
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
        static::creating(function ($profesional) {
            $profesional->uuid = Str::uuid();
        });
    }
}
