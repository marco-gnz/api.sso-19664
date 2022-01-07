<?php

namespace App\Http\Controllers\Perfiles;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PerfilesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum']);
    }

    public function getPerfiles()
    {
        try {
            $perfiles = Role::orderBy('name', 'ASC')->get();

            return response()->json($perfiles);
        } catch (\Exception $error) {
            return response()->json($error->getMessage());
        }
    }

    public function getPermisosToPerfil(Request $request)
    {
        try {
            $perfil = Role::where('id', $request->id_perfil)->first();

            if($perfil){
                $permisos = $perfil->permissions->pluck('name');

                return response()->json($permisos);
            }
        } catch (\Exception $error) {
            return response()->json($error->getMessage());
        }
    }

    public function getPermisosExtras(Request $request)
    {
        try {
            $perfil = Role::where('id', $request->id_perfil)->first();

            if($perfil){
                $permisosExtras = Permission::whereNotIn('id', $perfil->permissions->pluck('id'))->get();

                return response()->json($permisosExtras);
            }
        } catch (\Exception $error) {
            return response()->json($error->getMessage());
        }
    }
}
