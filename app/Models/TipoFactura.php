<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoFactura extends Model
{
    use HasFactory;

    protected $fillable = ['cod_sirh', 'nombre'];

    public $timestamps = false;

    public function facturas(){
        return $this->belongsToMany(Factura::class); // Muchos a muchos
    }
}
