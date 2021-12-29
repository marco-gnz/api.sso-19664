<?php

namespace App\Http\Controllers\Profesional;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profesional\StoreProfesionalRequest;
use App\Http\Requests\Profesional\UpdateProfesionalRequest;
use App\Models\Profesional;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ProfesionalController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth:sanctum']);
    }

    public function existProfesional(Request $request)
    {
        try {
            $rut            = $request->rut;
            $dv             = $request->dv;
            $rut_completo   = $rut . '-' . $dv;

            $profesional = Profesional::where('rut_completo', $rut_completo)->first();

            if ($profesional) {
                return response()->json(array(true, $profesional));
            } else {
                return response()->json(false);
            }
        } catch (\Exception $error) {
            return response()->json($error->getMessage());
        }
    }

    public function getProfesional(Request $request, $uuid)
    {
        $profesional = Profesional::where('uuid', $uuid)->first();

        return response()->json($profesional);
    }

    public function getProfesionales()
    {
        $profesionales = Profesional::with('etapa', 'calidad')->orderBy('id', 'asc')->get();

        if ($profesionales->count() > 0) {
            return response()->json($profesionales, 200);
        }
    }

    public function addProfesional(StoreProfesionalRequest $request)
    {
        try {
            $profesional = Profesional::create($request->all());

            $profesional->update([
                'usuario_add_id'  => auth()->user()->id,
                'fecha_add'       => Carbon::now()->toDateTimeString()
            ]);

            if ($profesional) {
                return response()->json(array(true, $profesional));
            } else {
                return response()->json(false);
            }
        } catch (\Exception $error) {
            return response()->json($error->getMessage());
        }
    }

    public function updateDatosPersonales(UpdateProfesionalRequest $request, $id)
    {
        try {
            $profesional = Profesional::find($id);

            $update = $profesional->update($request->all());

            $profesional = $profesional->fresh();

            if ($update) {
                return response()->json(array(true, $profesional));
            } else {
                return response()->json(false);
            }
        } catch (\Exception $error) {
            return response()->json($error->getMessage());
        }
    }

    public function changeStatus(Request $request, $uuid)
    {
        try {

            $profesional = Profesional::where('uuid', $uuid)->first();

            if ($profesional) {
                $update = $profesional->update([
                    'estado' => $request->estado
                ]);

                $with = ['etapa', 'calidad'];

                $profesional = $profesional->fresh($with);

                if ($update) {
                    return response()->json(array(true, $profesional));
                } else {
                    return response()->json(false);
                }
            }
        } catch (\Exception $error) {
            return response()->json($error->getMessage());
        }
    }
}
