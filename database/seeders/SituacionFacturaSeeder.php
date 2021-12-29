<?php

namespace Database\Seeders;

use App\Models\SituacionFactura;
use Illuminate\Database\Seeder;

class SituacionFacturaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SituacionFactura::truncate(); //evita duplicar datos

        $situacion = new SituacionFactura();
        $situacion->cod_sirh = 0;
        $situacion->nombre = 'Proceso de firma';
        $situacion->save();

        $situacion = new SituacionFactura();
        $situacion->cod_sirh = 0;
        $situacion->nombre = 'Proceso de pago';
        $situacion->save();

        $situacion = new SituacionFactura();
        $situacion->cod_sirh = 0;
        $situacion->nombre = 'Pagada';
        $situacion->save();
    }
}
