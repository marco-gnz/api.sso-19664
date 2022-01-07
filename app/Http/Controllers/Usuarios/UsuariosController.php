<?php

namespace App\Http\Controllers\Usuarios;

use App\Http\Controllers\Controller;
use App\Http\Requests\Usuario\StoreUsuarioRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;

class UsuariosController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum']);
    }

    public function existUsuario(Request $request)
    {
        try {
            $rut            = $request->rut;
            $dv             = $request->dv;
            $rut_completo   = $rut . '-' . $dv;

            $usuario = User::where('rut_completo', $rut_completo)->first();

            if ($usuario) {
                return response()->json(array(true, $usuario));
            } else {
                return response()->json(false);
            }
        } catch (\Exception $error) {
            return response()->json($error->getMessage());
        }
    }

    public function getUsuarios(Request $request)
    {
        //crear validación para listar todos los usuarios de la red que administra
        try {
            $input              = ($request->input != '') ? $request->input : '';
            $perfil             = ($request->perfil != '') ? $request->perfil : '';
            //crear resource
            $usuarios = User::general($input)
            ->perfil($perfil)
            ->with('roles', 'redesHospitalarias')
            ->orderBy('apellido_paterno', 'asc')
            ->paginate(10);

            return response()->json(
                array(
                    'pagination' => [
                        'total'         => $usuarios->total(),
                        'current_page'  => $usuarios->currentPage(),
                        'per_page'      => $usuarios->perPage(),
                        'last_page'     => $usuarios->lastPage(),
                        'from'          => $usuarios->firstItem(),
                        'to'            => $usuarios->lastPage()
                    ],
                    'usuarios' => $usuarios
                )
            );
        } catch (\Exception $error) {
            return response()->json($error->getMessage());
        }
    }

    public function changeStatus($uuid)
    {
        try {
            $usuario = User::where('uuid', $uuid)->first();

            if ($usuario) {
                $update = $usuario->update([
                    'estado' => !$usuario->estado
                ]);

                $with = ['roles', 'redesHospitalarias'];
                $usuario = $usuario->fresh($with);

                if ($update) {
                    return response()->json(array(true, $usuario));
                } else {
                    return response()->json(false);
                }
            }
        } catch (\Exception $error) {
            return response()->json($error->getMessage());
        }
    }

    public function restablecerContrasena($uuid)
    {
        try {
            $usuario = User::where('uuid', $uuid)->first();

            if ($usuario) {

                $update = $usuario->update([
                    'password' => bcrypt(substr($usuario->rut, 0, 5))
                ]);

                $usuario = $usuario->refresh();

                //enviar email a $usuario indicando que se reestablecio su pass!
                if ($update) {
                    return response()->json(true);
                } else {
                    return response()->json(false);
                }
            }
        } catch (\Exception $error) {
            return response()->json($error->getMessage());
        }
    }

    public function storeUsuario(StoreUsuarioRequest $request)
    {
        try {
            $form = ['rut', 'dv', 'rut_completo', 'primer_nombre', 'segundo_nombre', 'apellido_materno', 'apellido_paterno', 'email', 'genero_id'];

            $usuario = User::create($request->only($form));

            $segundo_nombre = ($usuario->segundo_nombre != null || $usuario->segundo_nombre != '') ? substr($usuario->segundo_nombre, 0, 1) : '';
            $sigla          = substr($usuario->primer_nombre, 0, 1) . '' . substr($usuario->segundo_nombre, 0, 1) . '' . substr($usuario->apellido_paterno, 0, 1) . '' . substr($usuario->apellido_materno, 0, 1);
            $otros_datos = $usuario->update([
                'password'                  => bcrypt(substr($usuario->rut, 0, 5)),
                'sigla'                     => $sigla,
                'usuario_add_id'            => auth()->user()->id,
                'fecha_add'                 => Carbon::now()->toDateTimeString()
            ]);

            $store_roles = $usuario->syncRoles($request->rol);

            if ($request->filled('permisos_extras')) {
                $usuario->syncPermissions($request->permisos_extras);
            }

            $usuario->redesHospitalarias()->attach($request->red_admin);

            $store_token = $usuario->createToken('19664');

            $with       = ['genero', 'userAdd'];

            $usuario    = $usuario->fresh($with);

            if ($usuario && $otros_datos && $store_roles && $store_token) {
                return response()->json(array(true, $usuario));
            } else {
                return response()->json(false);
            }
        } catch (\Exception $error) {
            return response()->json($error->getMessage());
        }
    }
}
