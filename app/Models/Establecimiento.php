<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Establecimiento extends Model
{
    use HasFactory;

    protected $fillable = ['cod_sirh', 'sigla','nombre', 'descripcion', 'red_hospitalaria_id', 'grado_complejidad_id'];

    public function redHospitalaria()
    {
        return $this->belongsTo(RedHospitalaria::class);
    }

    public function gradoComplejidad()
    {
        return $this->belongsTo(GradoComplejidad::class, 'grado_complejidad_id');
    }
}
