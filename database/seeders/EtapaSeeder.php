<?php

namespace Database\Seeders;

use App\Models\Etapa;
use Illuminate\Database\Seeder;

class EtapaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Etapa::truncate(); //evita duplicar datos

        $etapa = new Etapa();
        $etapa->cod_sirh = '0000';
        $etapa->nombre = 'Periodo asistencial obligatorio';
        $etapa->save();

        $etapa = new Etapa();
        $etapa->cod_sirh = '0000';
        $etapa->nombre = 'Destinación y formación';
        $etapa->save();

        $etapa = new Etapa();
        $etapa->cod_sirh = '0000';
        $etapa->nombre = 'Planta directiva';
        $etapa->save();

        $etapa = new Etapa();
        $etapa->cod_sirh = '0000';
        $etapa->nombre = 'Planta superior';
        $etapa->save();
    }
}
