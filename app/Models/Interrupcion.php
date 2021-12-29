<?php

namespace App\Models;

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
        return $this->hasOne(Pao::class, 'id','pao_id');
    }

    public function causal()
    {
        return $this->hasOne(Causal::class, 'id','causal_id');
    }

    public function devolucion()
    {
        return $this->hasOne(Devolucion::class, 'id','devolucion_id');
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
        static::creating(function ($interrupcion) {
            $interrupcion->uuid = Str::uuid();
        });
    }
}
