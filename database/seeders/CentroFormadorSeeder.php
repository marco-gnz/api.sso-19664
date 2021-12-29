<?php

namespace Database\Seeders;

use App\Models\CentroFormador;
use Illuminate\Database\Seeder;

class CentroFormadorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CentroFormador::truncate(); //evita duplicar datos   

        $centro_formador = new CentroFormador();
        $centro_formador->cod_sirh = 0;
        $centro_formador->nombre = 'UNIVERSIDAD AUSTRAL DE CHILE';
        $centro_formador->save();

        $centro_formador = new CentroFormador();
        $centro_formador->cod_sirh = 0;
        $centro_formador->nombre = 'UNIVERSIDAD DE CHILE';
        $centro_formador->save();

        $centro_formador = new CentroFormador();
        $centro_formador->cod_sirh = 0;
        $centro_formador->nombre = 'UNIVERSIDAD CATOLICA DE CHILE';
        $centro_formador->save();

        $centro_formador = new CentroFormador();
        $centro_formador->cod_sirh = 0;
        $centro_formador->nombre = 'UNIVERSIDAD DE LA FRONTERA';
        $centro_formador->save();
    }
}
