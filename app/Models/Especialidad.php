<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Especialidad extends Model
{
    use HasFactory;

    protected $table = "especialidads";
    protected $primaryKey = 'id';

    protected $fillable = ['uuid', 'fecha_registro','inicio_formacion', 'termino_formacion', 'observacion', 'origen', 'profesional_id', 'centro_formador_id', 'perfeccionamiento_id', 'usuario_add_id', 'fecha_add', 'usuario_update_id', 'fecha_update'];

    protected $guarded = ['id'];

    public function profesional()
    {
        return $this->hasOne(Profesional::class, 'id','profesional_id');
    }

    public function centroFormador()
    {
        return $this->hasOne(CentroFormador::class, 'id','centro_formador_id');
    }

    public function perfeccionamiento()
    {
        return $this->hasOne(Perfeccionamiento::class, 'id','perfeccionamiento_id');
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
        return $this->hasOne(User::class, 'id','usuario_add_id');
    }

    public function userUpdate()
    {
        return $this->hasOne(User::class, 'id','usuario_update_id');
    }

    public static function booted()
    {
        static::creating(function ($especialidad) {
            $especialidad->uuid = Str::uuid();
        });
    }
}
