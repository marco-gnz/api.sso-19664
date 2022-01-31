<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etapa extends Model
{
    use HasFactory;

    protected $fillable = ['cod_sirh', 'sigla', 'nombre', 'usuario_add_id', 'usuario_update_id'];
}
