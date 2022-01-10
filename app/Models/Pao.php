<?php

namespace App\Models;

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
}
