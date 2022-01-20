<?php

namespace Database\Seeders;

use App\Models\Establecimiento;
use Illuminate\Database\Seeder;

class EstablecimientoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Establecimiento::truncate(); //evita duplicar datos

        $establecimiento = new Establecimiento();
        $establecimiento->cod_sirh = 1041;
        $establecimiento->nombre = 'HOSPITAL PUERTO OCTAY';
        $establecimiento->sigla = 'HPO';
        $establecimiento->red_hospitalaria_id = 1;
        $establecimiento->grado_complejidad_id = 1;
        $establecimiento->save();

        $establecimiento = new Establecimiento();
        $establecimiento->cod_sirh = 1040;
        $establecimiento->nombre = 'HOSPITAL PURRANQUE';
        $establecimiento->sigla = 'HPU';
        $establecimiento->red_hospitalaria_id = 1;
        $establecimiento->grado_complejidad_id = 1;
        $establecimiento->save();

        $establecimiento = new Establecimiento();
        $establecimiento->cod_sirh = 1042;
        $establecimiento->nombre = 'HOSPITAL RIO NEGRO';
        $establecimiento->sigla = 'HRN';
        $establecimiento->red_hospitalaria_id = 1;
        $establecimiento->grado_complejidad_id = 3;
        $establecimiento->save();

        $establecimiento = new Establecimiento();
        $establecimiento->cod_sirh = 1043;
        $establecimiento->nombre = 'HOSPITAL FUTA SRUKA LAWENCHE';
        $establecimiento->sigla = 'HFSL';
        $establecimiento->red_hospitalaria_id = 1;
        $establecimiento->grado_complejidad_id = 1;
        $establecimiento->save();

        $establecimiento = new Establecimiento();
        $establecimiento->cod_sirh = 1044;
        $establecimiento->nombre = 'HOSPITAL PU MULEN';
        $establecimiento->sigla = 'HPMULEN';
        $establecimiento->red_hospitalaria_id = 1;
        $establecimiento->grado_complejidad_id = 2;
        $establecimiento->save();

        $establecimiento = new Establecimiento();
        $establecimiento->cod_sirh = 1027;
        $establecimiento->nombre = 'HOSPITAL BASE SAN JOSÉ OSORNO';
        $establecimiento->sigla = 'HBSJO';
        $establecimiento->red_hospitalaria_id = 1;
        $establecimiento->save();

        $establecimiento = new Establecimiento();
        $establecimiento->cod_sirh = NULL;
        $establecimiento->nombre = 'HOSPITAL BASE VALDIVIA';
        $establecimiento->sigla = 'HBV';
        $establecimiento->red_hospitalaria_id = 2;
        $establecimiento->save();

        /* $establecimiento = new Establecimiento();
        $establecimiento->cod_sirh = '0000';
        $establecimiento->nombre = 'HOSPITAL FELIX BULNES';
        $establecimiento->save();

        $establecimiento = new Establecimiento();
        $establecimiento->cod_sirh = '0000';
        $establecimiento->nombre = 'INSTITUTO PSIQUIATRICO';
        $establecimiento->save();

        $establecimiento = new Establecimiento();
        $establecimiento->cod_sirh = '0000';
        $establecimiento->nombre = 'HOSPITAL EL SALVADOR';
        $establecimiento->save();

        $establecimiento = new Establecimiento();
        $establecimiento->cod_sirh = '0000';
        $establecimiento->nombre = 'HOSPITAL CLINICO UC';
        $establecimiento->save();

        $establecimiento = new Establecimiento();
        $establecimiento->cod_sirh = '0000';
        $establecimiento->nombre = 'HOSPITAL BARROS LUCO TRUDEAU';
        $establecimiento->save();

        $establecimiento = new Establecimiento();
        $establecimiento->cod_sirh = '0000';
        $establecimiento->nombre = 'HOSPITAL CLINICO U.DE CHILE';
        $establecimiento->save();

        $establecimiento = new Establecimiento();
        $establecimiento->cod_sirh = '0000';
        $establecimiento->nombre = 'HOSPITAL GUILLERMO GRANT BENAVENTE';
        $establecimiento->save();

        $establecimiento = new Establecimiento();
        $establecimiento->cod_sirh = '0000';
        $establecimiento->nombre = 'HOSPITAL PADRE HURTADO';
        $establecimiento->save(); */
    }
}
