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
        $planta->cod_sirh = '0000';
        $planta->nombre = 'DIRECTIVOS';
        $planta->save();

        $planta = new Planta();
        $planta->cod_sirh = '0000';
        $planta->nombre = 'MEDICOS';
        $planta->save();

        $planta = new Planta();
        $planta->cod_sirh = '0000';
        $planta->nombre = 'ODONTOLOGOS';
        $planta->save();

        $planta = new Planta();
        $planta->cod_sirh = '0000';
        $planta->nombre = 'QUÍMICOS';
        $planta->save();
    }
}
