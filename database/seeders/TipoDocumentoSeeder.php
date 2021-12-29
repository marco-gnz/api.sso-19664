<?php

namespace Database\Seeders;

use App\Models\TipoDocumento;
use Illuminate\Database\Seeder;

class TipoDocumentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoDocumento::truncate(); //evita duplicar datos

        $tipo_documento = new TipoDocumento();
        $tipo_documento->cod_sirh = 0;
        $tipo_documento->nombre = 'ASIGNACIÓN';
        $tipo_documento->save();

        $tipo_documento = new TipoDocumento();
        $tipo_documento->cod_sirh = 1;
        $tipo_documento->nombre = 'ENCOMENDACIÓN';
        $tipo_documento->save();
    }
}
