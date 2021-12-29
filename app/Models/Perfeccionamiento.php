<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perfeccionamiento extends Model
{
    use HasFactory;

    protected $fillable = ['cod_sirh', 'nombre', 'descripcion', 'tipo_perfeccionamiento_id', 'usuario_add_id', 'usuario_update_id'];

    public function tipo()
    {
        return $this->hasOne(TipoPerfeccionamiento::class, 'id', 'tipo_perfeccionamiento_id');
    }

    public function userAdd()
    {
        return $this->hasOne(User::class, 'id','usuario_add_id');
    }

    public function userUpdate()
    {
        return $this->hasOne(User::class, 'id','usuario_update_id');
    }

}
