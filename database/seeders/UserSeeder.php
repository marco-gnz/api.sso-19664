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
        $user->primer_nombre = 'MARCO';
        $user->segundo_nombre = 'IGNACIO';
        $user->apellido_materno = 'AZÓCAR';
        $user->apellido_paterno = 'GONZÁLEZ';
        $user->nombre_completo  = $user->primer_nombre.' '.$user->segundo_nombre.' '.$user->apellido_paterno.' '.$user->apellido_materno;
        $user->email = 'marcoi.gonzalez@redsalud.gob.cl';
        $user->password = bcrypt(substr($user->rut, 0, 5));
        $user->genero_id = 2;
        $user->save();

        $user->update([
            'sigla' => substr($user->primer_nombre, 0, 1).''.substr($user->segundo_nombre, 0, 1).''.substr($user->apellido_paterno, 0, 1).''.substr($user->apellido_materno, 0, 1),

        ]);

        $user->createToken('19664');

        $user->assignRole('SUPER-ADMIN');
    }
}
