<?php

namespace Database\Seeders;

use App\Models\RedHospitalaria;
use Illuminate\Database\Seeder;

class RedHospitalariaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RedHospitalaria::truncate(); //evita duplicar datos

        $red_hospitalaria = new RedHospitalaria();
        $red_hospitalaria->cod_sirh = NULL;
        $red_hospitalaria->nombre = 'SERVICIO DE SALUD OSORNO';
        $red_hospitalaria->sigla = 'SSO';
        $red_hospitalaria->save();

        $red_hospitalaria = new RedHospitalaria();
        $red_hospitalaria->cod_sirh = NULL;
        $red_hospitalaria->nombre = 'SERVICIO DE SALUD VALDIVIA';
        $red_hospitalaria->sigla = 'SSV';
        $red_hospitalaria->save();
    }
}
