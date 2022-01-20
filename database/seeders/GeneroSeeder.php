<?php

namespace Database\Seeders;

use App\Models\Genero;
use Illuminate\Database\Seeder;

class GeneroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Genero::truncate(); //evita duplicar datos

        $genero = new Genero();
        $genero->cod_sirh = NULL;
        $genero->sigla = 'F';
        $genero->nombre = 'Femenino';
        $genero->save();

        $genero = new Genero();
        $genero->cod_sirh = NULL;
        $genero->sigla = 'M';
        $genero->nombre = 'Masculino';
        $genero->save();
    }
}
