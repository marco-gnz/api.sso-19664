<?php

namespace Database\Seeders;

use App\Models\CalidadJuridica;
use Illuminate\Database\Seeder;

class CalidadJuridicaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CalidadJuridica::truncate(); //evita duplicar datos   

        $calidad_juridica = new CalidadJuridica();
        $calidad_juridica->cod_sirh = 0;
        $calidad_juridica->nombre = 'CONTRATADOS';
        $calidad_juridica->save();

        $calidad_juridica = new CalidadJuridica();
        $calidad_juridica->cod_sirh = 0;
        $calidad_juridica->nombre = 'TITULARES';
        $calidad_juridica->save();
    }
}
