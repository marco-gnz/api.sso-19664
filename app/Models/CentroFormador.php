<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CentroFormador extends Model
{
    use HasFactory;

    protected $fillable = ['cod_sirh', 'nombre', 'descripcion', 'usuario_add_id', 'usuario_update_id'];
}
