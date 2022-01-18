<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Causal extends Model
{
    use HasFactory;

    protected $fillable = ['cod_sirh', 'nombre', 'estado', 'usuario_add_id', 'fecha_add', 'usuario_update_id', 'usuario_update_id'];

    public function scopeGeneral($query, $search)
    {
        if ($search)
            return $query->where('cod_sirh', 'like', '%' . $search . '%')->orWhere('nombre', 'like', '%' . $search . '%');
    }
}
