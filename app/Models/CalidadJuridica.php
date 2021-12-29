<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalidadJuridica extends Model
{
    use HasFactory;

    protected $fillable = ['cod_sirh', 'nombre'];
}
