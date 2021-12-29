<?php

namespace Database\Seeders;

use App\Models\TipoFactura;
use Illuminate\Database\Seeder;

class TipoFacturaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoFactura::truncate(); //evita duplicar datos

        $tipo_factura = new TipoFactura();
        $tipo_factura->cod_sirh = 0;
        $tipo_factura->nombre = 'MATRICULA';
        $tipo_factura->save();

        $tipo_factura = new TipoFactura();
        $tipo_factura->cod_sirh = 0;
        $tipo_factura->nombre = 'ARANCEL';
        $tipo_factura->save();
    }
}
