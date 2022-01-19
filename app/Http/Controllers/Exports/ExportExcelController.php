<?php

namespace App\Http\Controllers\Exports;

use App\Http\Controllers\Controller;
use App\Models\Etapa;
use App\Models\Profesional;
use App\Exports\ProfesionalesPao;
use App\Exports\ProfesionalesEdf;
use App\Models\Especialidad;
use App\Models\EtapaDestinacion;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportExcelController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum']);
    }

    public function getProfesionales(Request $request)
    {
        $etapas             = isset($request->checkedEtapas) ? $request->checkedEtapas : [];
        $perfecion          = isset($request->perfeccion) ? $request->perfeccion : [];
        $inicio_f_ed        = isset($request->f_ed) ? $request->f_ed[0] : [];
        $termino_f_ed       = isset($request->f_ed) ? $request->f_ed[1] : [];

        $inicio_f_ef        = isset($request->f_ef) ? $request->f_ef[0] : [];
        $termino_f_ef       = isset($request->f_ef) ? $request->f_ef[1] : [];

        $inicio_f_pao       = isset($request->f_pao) ? $request->f_pao[0] : [];
        $termino_f_pao      = isset($request->f_pao) ? $request->f_pao[1] : [];

        $establecimiento    = isset($request->establecimiento) ? $request->establecimiento : [];

        $etapaFirst         = Etapa::whereIn('id', $etapas)->first();

        $profesionales = Profesional::etapaProfesional($etapas)
            ->perfeccionamiento($perfecion)
            ->paos($inicio_f_pao, $termino_f_pao)
            ->destinacion($inicio_f_ed, $termino_f_ed)
            ->formacion($inicio_f_ef, $termino_f_ef)
            ->establecimiento($etapas, $establecimiento)
            ->with('etapa', 'calidad')
            ->orderBy('apellidos', 'asc')
            ->get();

        if ($profesionales->count() > 0) {
            return response()->json(array(true, $profesionales->pluck('id'), $etapaFirst->id));
        } else {
            return response()->json(false);
        }
    }

    public function export($ids, $etapa)
    {
        try {
            $cantidad = 0;
            $cantidad_devo = 0;
            $profesionalesArray = explode(',', $ids);
            $ids = [];
            $e = intval($etapa);
            $cantidad_destinacion = 0;
            $cantidad_formacion   = 0;

            //por etapa
            if ($e === 1) {
                $profesionales = Profesional::whereIn('id', $profesionalesArray)
                    ->where('estado', true)
                    ->with('etapa', 'calidad', 'especialidades.paos.devoluciones.tipoContrato')->get();

                $especialidades = Especialidad::whereIn('profesional_id', $profesionales->pluck('id'))->get();

                foreach ($especialidades as $especialidad) {
                    array_push($ids, $especialidad->profesional_id);
                }
            } else if ($e === 2) {
                //edf
                $profesionales = Profesional::whereIn('id', $profesionalesArray)
                    ->where('estado', true)
                    ->with(
                        'destinaciones.establecimiento',
                        'destinaciones.gradoComplejidadEstablecimiento',
                        'destinaciones.unidad',
                        'especialidades.centroFormador',
                        'especialidades.perfeccionamiento.tipo'
                    )->get();

                $destinaciones = EtapaDestinacion::whereIn('profesional_id', $profesionales->pluck('id'))->get();

                $especialidades = Especialidad::whereIn('profesional_id', $profesionales->pluck('id'))->where('origen', 'EDF')->get();

                foreach ($destinaciones as $destinacion) {
                    array_push($ids, $destinacion->profesional_id);
                }

                foreach ($especialidades as $especialidad) {
                    array_push($ids, $especialidad->profesional_id);
                }
            }

            $profesional = null;
            $valores = array_count_values($ids);
            if (count($valores) > 0) {
                arsort($valores);

                $id_mas_repetido = array_key_first($valores);

                $profesional = Profesional::find($id_mas_repetido);
            }

            if ($e == 1) {
                if ($profesional) {
                    foreach ($profesional->especialidades as $especialidad) {
                        $cantidad += $especialidad->paos()->count();
                        foreach ($especialidad->paos as $pao) {
                            $cantidad_devo += $pao->devoluciones()->count();
                        }
                    }
                } else {
                    $cantidad_devo = 0;
                }
            } else if ($e == 2) {
                if ($profesional) {
                    $cantidad_destinacion   = $profesional->destinaciones()->count();

                    $cantidad_formacion     = $profesional->especialidades()->where('origen', 'EDF')->count();
                } else {
                    $cantidad_destinacion   = 0;
                    $cantidad_formacion     = 0;
                }
            }

            if ($e === 1) {
                //PAO
                /* return view('excel.pao', compact('profesionales', 'cantidad', 'cantidad_devo')); */
                return Excel::download(new ProfesionalesPao($profesionales, $cantidad, $cantidad_devo), 'PAO - Profesionales.xlsx');
            } else if ($e == 2) {
                //EDF
                /* return view('excel.edf', compact('profesionales', 'cantidad_destinacion', 'cantidad_formacion')); */
                return Excel::download(new ProfesionalesEdf($profesionales, $cantidad_destinacion, $cantidad_formacion), 'EDF - Profesionales.xlsx');
            } else {
                return false;
            }

            //PLANTA DIRECTIVA

            //PLANTA SUPERIOR
        } catch (\Exception $error) {
            return $error->getMessage();
        }
    }
}
