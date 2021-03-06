<?php

namespace App\Http\Controllers\Documentos;

use App\Http\Controllers\Controller;
use App\Http\Requests\Documentos\Convenio\StoreConvenioRequest;
use App\Http\Requests\Documentos\Convenio\UpdateConvenioRequest;
use App\Models\Convenio;
use App\Models\Especialidad;
use App\Models\Profesional;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ConveniosController extends Controller
{
    public function getConvenios(Request $request)
    {
        try {
            $profesional = Profesional::where('uuid', $request->uuid)->first();
            if ($profesional) {
                $convenios = $profesional->convenios()->with('especialidad.perfeccionamiento.tipo', 'especialidad.centroFormador', 'especialidad.profesional', 'tipo', 'userAdd', 'userUpdate')->orderBy('created_at', 'desc')->get();

                return response()->json($convenios);
            }
        } catch (\Exception $error) {
            return response()->json($error->getMessage());
        }
    }
    public function storeConvenio(StoreConvenioRequest $request)
    {
        try {
            $request_form   = ['profesional_id', 'anios_arancel', 'valor_arancel', 'n_resolucion', 'fecha_resolucion', 'observacion', 'especialidad_id', 'tipo_convenio_id'];

            $profesional = Profesional::find($request->profesional_id);

            if ($profesional) {
                $convenio = Convenio::create($request->only($request_form));

                $update = $convenio->update([
                    'usuario_add_id' => auth()->user()->id,
                    'fecha_add'      => Carbon::now()
                ]);

                $with         = ['especialidad.perfeccionamiento.tipo', 'especialidad.centroFormador', 'especialidad.profesional', 'tipo', 'userAdd'];
                $convenio     = $convenio->fresh($with);

                if ($convenio && $update) {
                    return response()->json(array(true, $convenio));
                } else {
                    return response()->json(false);
                }
            }
        } catch (\Exception $error) {
            return response()->json($error->getMessage());
        }
    }

    public function updateConvenio(UpdateConvenioRequest $request, $id_convenio)
    {
        try {
            $request_form   = ['anios_arancel', 'valor_arancel', 'n_resolucion', 'fecha_resolucion', 'observacion', 'especialidad_id', 'tipo_convenio_id'];

            $convenio = Convenio::find($id_convenio);

            if ($convenio) {

                $update = $convenio->update($request->only($request_form));

                $convenio->update([
                    'usuario_update_id' => auth()->user()->id,
                    'fecha_update'      => Carbon::now()->toDateTimeString()
                ]);

                $with = ['especialidad.perfeccionamiento.tipo', 'especialidad.centroFormador', 'especialidad.profesional', 'tipo', 'userAdd', 'userUpdate'];

                $convenio = $convenio->fresh($with);

                if ($update) {
                    return response()->json(array(true, $convenio));
                } else {
                    return response()->json(false);
                }
            }
        } catch (\Exception $error) {
            return response()->json($error->getMessage());
        }
    }

    public function deleteConvenio($uuid)
    {
        try {
            $convenio = Convenio::where('uuid', $uuid)->first();
            if ($convenio) {

                if ($convenio->facturas != null && $convenio->facturas()->count() > 0) {
                    return response()->json('passing_facturas');
                } else {
                    $delete = $convenio->delete();
                    if ($delete) {
                        return response()->json(true);
                    } else {
                        return response()->json(false);
                    }
                }
            }
        } catch (\Exception $error) {
            return response()->json($error->getMessage());
        }
    }
}
