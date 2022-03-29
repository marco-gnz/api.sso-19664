<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampoClinico extends Model
{
    use HasFactory;

    protected $fillable = ['cod_sirh', 'nombre', 'estado'];
}
