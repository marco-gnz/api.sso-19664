<?php

namespace App\Models;

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
}
