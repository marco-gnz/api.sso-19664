<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SituacionFactura extends Model
{
    use HasFactory;

    protected $table = "situacion_facturas";
    protected $primaryKey = 'id';

    protected $fillable = ['cod_sirh', 'nombre'];

    protected $guarded = ['id'];

    public $timestamps = false;
}
