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
        $etapa->cod_sirh = NULL;
        $etapa->nombre = 'Periodo asistencial obligatorio';
        $etapa->sigla = 'PAO';
        $etapa->save();

        $etapa = new Etapa();
        $etapa->cod_sirh = NULL;
        $etapa->nombre = 'Destinación y formación';
        $etapa->sigla = 'EDF';
        $etapa->save();

        $etapa = new Etapa();
        $etapa->cod_sirh = NULL;
        $etapa->nombre = 'Planta directiva';
        $etapa->sigla = 'PD';
        $etapa->save();

        $etapa = new Etapa();
        $etapa->cod_sirh = NULL;
        $etapa->nombre = 'Planta superior';
        $etapa->sigla = 'PS';
        $etapa->save();
    }
}
