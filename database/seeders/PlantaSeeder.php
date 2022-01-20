<?php

namespace Database\Seeders;

use App\Models\Planta;
use Illuminate\Database\Seeder;

class PlantaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Planta::truncate(); //evita duplicar datos

        $planta = new Planta();
        $planta->cod_sirh = NULL;
        $planta->nombre = 'DIRECTIVOS';
        $planta->save();

        $planta = new Planta();
        $planta->cod_sirh = NULL;
        $planta->nombre = 'MEDICOS';
        $planta->save();

        $planta = new Planta();
        $planta->cod_sirh = NULL;
        $planta->nombre = 'ODONTOLOGOS';
        $planta->save();

        $planta = new Planta();
        $planta->cod_sirh = NULL;
        $planta->nombre = 'QUÍMICOS';
        $planta->save();
    }
}
