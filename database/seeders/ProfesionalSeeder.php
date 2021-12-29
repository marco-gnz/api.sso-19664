<?php

namespace Database\Seeders;

use App\Models\Profesional;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class ProfesionalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Profesional::truncate(); //evita duplicar datos   

        $profesional                        = new Profesional();
        $profesional->uuid                  = Str::uuid();
        $profesional->rut                   = '18904336';
        $profesional->dv                    = '8';
        $profesional->rut_completo          = $profesional->rut.'-'.$profesional->dv;
        $profesional->nombres               = 'NESTOR NICOLAS';
        $profesional->apellidos             = 'ABARZUA AVILES';
        $profesional->nombre_completo       = $profesional->nombres.' '.$profesional->apellidos;
        $profesional->ciudad                = 'SANTIAGO';
        $profesional->etapas_id             = 1;
        $profesional->calidad_juridica_id   = 1;
        $profesional->planta_id             = 2;
        $profesional->genero_id             = 2;
        $profesional->save();
    }
}
