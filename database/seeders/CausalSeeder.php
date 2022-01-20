<?php

namespace Database\Seeders;

use App\Models\Causal;
use Illuminate\Database\Seeder;

class CausalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Causal::truncate(); //evita duplicar datos

        $causal = new Causal();
        $causal->cod_sirh = NULL;
        $causal->nombre = 'LICENCIA MEDICA - ENFERMEDAD';
        $causal->save();

        $causal = new Causal();
        $causal->cod_sirh = NULL;
        $causal->nombre = 'CURSANDO SUBESPECIALIDAD';
        $causal->save();

        $causal = new Causal();
        $causal->cod_sirh = NULL;
        $causal->nombre = 'LICENCIA MEDICA - ACCIDENTE DE TRABAJO';
        $causal->save();
    }
}
