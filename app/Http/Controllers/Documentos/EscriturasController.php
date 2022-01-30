<?php

namespace App\Http\Controllers\Documentos;

use App\Http\Controllers\Controller;
use App\Http\Requests\Documentos\Escritura\StoreEscrituraRequest;
use App\Http\Requests\Documentos\Escritura\UpdateEscriturRequest;
use App\Models\Escritura;
use App\Models\Especialidad;
use App\Models\Profesional;
use Illuminate\Http\Request;
use Carbon\Carbon;

class EscriturasController extends Controller
{
    public function getEscrituras(Request $request)
    {
        try {
            $profesional = Profesional::where('uuid', $request->uuid)->first();

            if ($profesional) {
                $especialidades = Especialidad::where('profesional_id', $profesional->id)->get();
                $escrituras     = Escritura::with('especialidad.perfeccionamiento.tipo', 'especialidad.centroFormador', 'userAdd', 'userUpdate')->whereIn('especialidad_id', $especialidades->pluck('id'))->orderBy('fecha_resolucion', 'desc')->get();

                return response()->json($escrituras);
            }
        } catch (\Exception $error) {
            return response()->json($error->getMessage());
        }
    }

    public function storeEscritura(StoreEscrituraRequest $request)
    {
        try {
            $especialidad = Especialidad::find($request->especialidad_id);

            if ($especialidad) {
                $escritura = Escritura::create($request->all());

                $update = $escritura->update([
                    'usuario_add_id' => auth()->user()->id,
                    'fecha_add'      => Carbon::now()
                ]);

                $with = ['especialidad.perfeccionamiento.tipo', 'especialidad.centroFormador', 'userAdd'];

                $escritura = $escritura->fresh($with);

                if ($escritura && $update) {
                    return response()->json(array(true, $escritura));
                } else {
                    return response()->json(false);
                }
            }
        } catch (\Exception $error) {
            return response()->json($error->getMessage());
        }
    }

    public function updateEscritura(UpdateEscriturRequest $request, $id)
    {
        try {
            $escritura = Escritura::find($id);

            if ($escritura) {
                $update = $escritura->update($request->all());

                $escritura->update([
                    'usuario_update_id' => auth()->user()->id,
                    'fecha_update'      => Carbon::now()->toDateTimeString()
                ]);

                $with = ['especialidad.perfeccionamiento.tipo', 'especialidad.centroFormador', 'userAdd', 'userUpdate'];

                $escritura = $escritura->fresh($with);

                if ($update) {
                    return response()->json(array(true, $escritura));
                } else {
                    return response()->json(false);
                }
            }
        } catch (\Exception $error) {
            return response()->json($error->getMessage());
        }
    }

    public function deleteEscritura($uuid)
    {
        try {
            $escritura = Escritura::where('uuid', $uuid)->first();
            if($escritura){
                $delete = $escritura->delete();
                if($delete){
                    return response()->json(true);
                }else{
                    return response()->json(false);
                }
            }
        } catch (\Exception $error) {
            return response()->json($error->getMessage());
        }
    }
}
