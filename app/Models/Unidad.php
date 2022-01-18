<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unidad extends Model
{
    use HasFactory;

    protected $fillable = ['cod_sirh', 'nombre'];

    public function scopeGeneral($query, $search)
    {
        if ($search)
            return $query->where('cod_sirh', 'like', '%' . $search . '%')->orWhere('nombre', 'like', '%' . $search . '%');
    }
}
