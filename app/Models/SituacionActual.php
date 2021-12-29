<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SituacionActual extends Model
{
    use HasFactory;

    protected $fillable = ['cod_sirh', 'nombre'];
}
