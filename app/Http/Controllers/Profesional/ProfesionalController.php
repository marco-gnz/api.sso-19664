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
        try {
            $profesional = Profesional::with('especialidades', 'destinaciones')->where('uuid', $uuid)->first();

            if($profesional){
                return response()->json($profesional);
            }else{
                return false;
            }


        } catch (\Exception $error) {
            return response()->json($error->getMessage());
        }
    }

    public function getProfesionales(Request $request)
    {
        $input              = ($request->input != '') ? $request->input : '';
        $etapas             = ($request->checkedEtapas != '') ? $request->checkedEtapas : [];
        $perfecion          = ($request->perfeccion != '') ? $request->perfeccion : [];
        $inicio_f_ed        = ($request->f_ed != '') ? $request->f_ed[0] : [];
        $termino_f_ed       = ($request->f_ed != '') ? $request->f_ed[1] : [];

        $inicio_f_ef        = ($request->f_ef != '') ? $request->f_ef[0] : [];
        $termino_f_ef       = ($request->f_ef != '') ? $request->f_ef[1] : [];

        $inicio_f_pao       = ($request->f_pao != '') ? $request->f_pao[0] : [];
        $termino_f_pao      = ($request->f_pao != '') ? $request->f_pao[1] : [];

        $establecimiento    = ($request->establecimiento != '') ? $request->establecimiento : [];

        $estados            = ($request->estados != '') ? $request->estados : [];

        $profesionales = Profesional::general($input)
            ->etapaProfesional($etapas)
            ->perfeccionamiento($perfecion)
            ->paos($inicio_f_pao, $termino_f_pao)
            ->destinacion($inicio_f_ed, $termino_f_ed)
            ->formacion($inicio_f_ef, $termino_f_ef)
            ->establecimiento($etapas, $establecimiento)
            ->estado($estados)
            ->with('etapa', 'calidad')
            ->orderBy('apellidos', 'asc')
            ->paginate(10);

        return response()->json(
            array(
                'pagination' => [
                    'total'         => $profesionales->total(),
                    'current_page'  => $profesionales->currentPage(),
                    'per_page'      => $profesionales->perPage(),
                    'last_page'     => $profesionales->lastPage(),
                    'from'          => $profesionales->firstItem(),
                    'to'            => $profesionales->lastPage()
                ],
                'profesionales' => $profesionales
            )
        );
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
