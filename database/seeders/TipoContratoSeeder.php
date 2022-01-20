<?php

namespace Database\Seeders;

use App\Models\TipoContratos;
use Illuminate\Database\Seeder;

class TipoContratoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //selección de antecedentes

        TipoContratos::truncate(); //evita duplicar datos

        $tipo_contrato = new TipoContratos();
        $tipo_contrato->cod_sirh = NULL;
        $tipo_contrato->horas = 11;
        $tipo_contrato->nombre = '11';
        $tipo_contrato->save();

        $tipo_contrato = new TipoContratos();
        $tipo_contrato->cod_sirh = NULL;
        $tipo_contrato->horas = 22;
        $tipo_contrato->nombre = '22';
        $tipo_contrato->save();

        $tipo_contrato = new TipoContratos();
        $tipo_contrato->cod_sirh = NULL;
        $tipo_contrato->horas = 28;
        $tipo_contrato->nombre = '28';
        $tipo_contrato->save();

        $tipo_contrato = new TipoContratos();
        $tipo_contrato->cod_sirh = NULL;
        $tipo_contrato->horas = 33;
        $tipo_contrato->nombre = '33';
        $tipo_contrato->save();

        $tipo_contrato = new TipoContratos();
        $tipo_contrato->cod_sirh = NULL;
        $tipo_contrato->horas = 44;
        $tipo_contrato->nombre = '44';
        $tipo_contrato->save();

        $tipo_contrato = new TipoContratos();
        $tipo_contrato->cod_sirh = NULL;
        $tipo_contrato->horas = 44;
        $tipo_contrato->nombre = '22 y 28 (44 hrs.)';
        $tipo_contrato->save();
    }
}
