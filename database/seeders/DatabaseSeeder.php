<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;'); //invalido revición de foreign key para hacer pruebas mas flexibles

        $this->call(PermisosRoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(UnidadSeeder::class);
        $this->call(CalidadJuridicaSeeder::class);
        $this->call(CausalSeeder::class);
        $this->call(RedHospitalariaSeeder::class);
        $this->call(GradoComplejidadSeeder::class);
        $this->call(EstablecimientoSeeder::class);
        $this->call(EtapaSeeder::class);
        $this->call(GeneroSeeder::class);
        $this->call(PlantaSeeder::class);
        $this->call(TipoContratoSeeder::class);
        $this->call(TipoPerfeccionamientoSeeder::class);
        $this->call(PerfeccionamientoSeeder::class);
        $this->call(CentroFormadorSeeder::class);
        $this->call(ProfesionalSeeder::class);
        $this->call(SituacionFacturaSeeder::class);
        $this->call(TipoFacturaSeeder::class);
        $this->call(TipoDocumentoSeeder::class);
        $this->call(SituacionActualSeeder::class);
        $this->call(TipoConvenioSeeder::class);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
