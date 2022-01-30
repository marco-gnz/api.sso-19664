<?php

namespace Database\Seeders;

use App\Models\TipoConvenio;
use Illuminate\Database\Seeder;

class TipoConvenioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoConvenio::truncate(); //evita duplicar datos

        $tipo_convenio = new TipoConvenio();
        $tipo_convenio->cod_sirh = NULL;
        $tipo_convenio->nombre = 'COLABORATIVO';
        $tipo_convenio->save();

        $tipo_convenio = new TipoConvenio();
        $tipo_convenio->cod_sirh = NULL;
        $tipo_convenio->nombre = 'VIÁTICO';
        $tipo_convenio->save();

        $tipo_convenio = new TipoConvenio();
        $tipo_convenio->cod_sirh = NULL;
        $tipo_convenio->nombre = 'ARRIENDO';
        $tipo_convenio->save();
    }
}
