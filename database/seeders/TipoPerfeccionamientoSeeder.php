<?php

namespace Database\Seeders;

use App\Models\TipoPerfeccionamiento;
use Illuminate\Database\Seeder;

class TipoPerfeccionamientoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoPerfeccionamiento::truncate(); //evita duplicar datos

        $tipo_perfeccionamiento = new TipoPerfeccionamiento();
        $tipo_perfeccionamiento->cod_sirh = NULL;
        $tipo_perfeccionamiento->nombre = 'FELLOWSHIP';
        $tipo_perfeccionamiento->save();

        $tipo_perfeccionamiento = new TipoPerfeccionamiento();
        $tipo_perfeccionamiento->cod_sirh = NULL;
        $tipo_perfeccionamiento->nombre = 'ESPECIALIDAD';
        $tipo_perfeccionamiento->save();

        $tipo_perfeccionamiento = new TipoPerfeccionamiento();
        $tipo_perfeccionamiento->cod_sirh = NULL;
        $tipo_perfeccionamiento->nombre = 'SUBESPECIALIDAD';
        $tipo_perfeccionamiento->save();
    }
}
