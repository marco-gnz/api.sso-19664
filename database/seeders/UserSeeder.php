<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate(); //evita duplicar datos

        $user = new User();
        $user->uuid = Str::uuid();
        $user->rut = 19270290;
        $user->dv = '9';
        $user->rut_completo = $user->rut.'-'.$user->dv;
        $user->primer_nombre = 'Marco';
        $user->segundo_nombre = 'Ignacio';
        $user->apellido_materno = 'González';
        $user->apellido_paterno = 'Azócar';
        $user->email = 'marcoignacio.9637@gmail.com';
        $user->password = bcrypt('mamasa20');
        $user->genero_id = 1;
        $user->save();

        $user->update([
            'sigla' => substr($user->primer_nombre, 0, 1).''.substr($user->segundo_nombre, 0, 1).''.substr($user->apellido_materno, 0, 1).''.substr($user->apellido_paterno, 0, 1)
        ]);

        $user->createToken('test');
    }
}
