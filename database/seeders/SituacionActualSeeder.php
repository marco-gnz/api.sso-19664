<?php

namespace Database\Seeders;

use App\Models\SituacionActual;
use Illuminate\Database\Seeder;

class SituacionActualSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SituacionActual::truncate(); //evita duplicar datos

        $situacionActual = new SituacionActual();
        $situacionActual->nombre = 'ART.9°';
        $situacionActual->save();

        $situacionActual = new SituacionActual();
        $situacionActual->nombre = 'ART.9° ESPECIALISTA';
        $situacionActual->save();

        $situacionActual = new SituacionActual();
        $situacionActual->nombre = 'ART.9° SUBESPECIALISTA';
        $situacionActual->save();

        $situacionActual = new SituacionActual();
        $situacionActual->nombre = 'COMISIÓN DE ESTUDIOS°';
        $situacionActual->save();

        $situacionActual = new SituacionActual();
        $situacionActual->nombre = 'EDF';
        $situacionActual->save();

        $situacionActual = new SituacionActual();
        $situacionActual->nombre = 'PAO';
        $situacionActual->save();

        $situacionActual = new SituacionActual();
        $situacionActual->nombre = 'BECARIO';
        $situacionActual->save();

        $situacionActual = new SituacionActual();
        $situacionActual->nombre = 'CICLO CONCLUIDO';
        $situacionActual->save();
    }
}
