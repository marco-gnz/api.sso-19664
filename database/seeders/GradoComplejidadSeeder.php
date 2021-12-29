<?php

namespace Database\Seeders;

use App\Models\GradoComplejidad;
use Illuminate\Database\Seeder;

class GradoComplejidadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        GradoComplejidad::truncate(); //evita duplicar datos

        $grado_complejidad = new GradoComplejidad();
        $grado_complejidad->cod_sirh = 0;
        $grado_complejidad->grado = 'A';
        $grado_complejidad->save();

        $grado_complejidad = new GradoComplejidad();
        $grado_complejidad->cod_sirh = 0;
        $grado_complejidad->grado = 'B';
        $grado_complejidad->save();

        $grado_complejidad = new GradoComplejidad();
        $grado_complejidad->cod_sirh = 0;
        $grado_complejidad->grado = 'C';
        $grado_complejidad->save();

        $grado_complejidad = new GradoComplejidad();
        $grado_complejidad->cod_sirh = 0;
        $grado_complejidad->grado = 'D';
        $grado_complejidad->save();

        $grado_complejidad = new GradoComplejidad();
        $grado_complejidad->cod_sirh = 0;
        $grado_complejidad->grado = 'E';
        $grado_complejidad->save();
    }
}
