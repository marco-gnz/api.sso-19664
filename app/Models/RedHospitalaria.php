<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RedHospitalaria extends Model
{
    use HasFactory;

    protected $fillable = ['cod_sirh', 'sigla','nombre', 'descripcion'];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function establecimientos()
    {
        return $this->belongsToMany(Establecimiento::class);
    }
}
