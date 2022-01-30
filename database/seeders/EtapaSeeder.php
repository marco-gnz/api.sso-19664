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
        $etapa->nombre = 'Planta superior nivel 1';
        $etapa->sigla = 'PS NIV. 1';
        $etapa->save();

        $etapa = new Etapa();
        $etapa->cod_sirh = NULL;
        $etapa->nombre = 'Planta superior nivel 2';
        $etapa->sigla = 'PS NIV. 2';
        $etapa->save();

        $etapa = new Etapa();
        $etapa->cod_sirh = NULL;
        $etapa->nombre = 'Planta superior nivel 3';
        $etapa->sigla = 'PS NIV. 3';
        $etapa->save();

        $etapa = new Etapa();
        $etapa->cod_sirh = NULL;
        $etapa->nombre = 'Becario';
        $etapa->sigla = 'Becario';
        $etapa->save();
    }
}
