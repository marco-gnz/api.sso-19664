<?php

namespace Database\Seeders;

use App\Models\Perfeccionamiento;
use Illuminate\Database\Seeder;

class PerfeccionamientoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Perfeccionamiento::truncate(); //evita duplicar datos   

        $perfeccionamiento = new Perfeccionamiento();
        $perfeccionamiento->cod_sirh = 0;
        $perfeccionamiento->nombre = 'Cirugía';
        $perfeccionamiento->tipo_perfeccionamiento_id = 2;
        $perfeccionamiento->save();

        $perfeccionamiento = new Perfeccionamiento();
        $perfeccionamiento->cod_sirh = 0;
        $perfeccionamiento->nombre = 'Medicina Interna';
        $perfeccionamiento->tipo_perfeccionamiento_id = 2;
        $perfeccionamiento->save();

        $perfeccionamiento = new Perfeccionamiento();
        $perfeccionamiento->cod_sirh = 0;
        $perfeccionamiento->nombre = 'Pediatría';
        $perfeccionamiento->tipo_perfeccionamiento_id = 2;
        $perfeccionamiento->save();

        $perfeccionamiento = new Perfeccionamiento();
        $perfeccionamiento->cod_sirh = 0;
        $perfeccionamiento->nombre = 'Urología';
        $perfeccionamiento->tipo_perfeccionamiento_id = 2;
        $perfeccionamiento->save();

        $perfeccionamiento = new Perfeccionamiento();
        $perfeccionamiento->cod_sirh = 0;
        $perfeccionamiento->nombre = 'Hematología';
        $perfeccionamiento->tipo_perfeccionamiento_id = 3;
        $perfeccionamiento->save();

        $perfeccionamiento = new Perfeccionamiento();
        $perfeccionamiento->cod_sirh = 0;
        $perfeccionamiento->nombre = 'Infectología adulto';
        $perfeccionamiento->tipo_perfeccionamiento_id = 3;
        $perfeccionamiento->save();
    }
}
