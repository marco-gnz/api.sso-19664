<?php

namespace App\Http\Controllers\Exports;

use App\Http\Controllers\Controller;
use App\Models\Etapa;
use App\Models\Profesional;
use App\Exports\ProfesionalesPao;
use App\Exports\ProfesionalesEdf;
use App\Exports\ProfesionalesExport;
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

        $estados            = ($request->estados) ? $request->estados : [];

        $situaciones        = ($request->situaciones != '') ? $request->situaciones : [];

        $etapasIds          = Etapa::whereIn('id', $etapas)->pluck('id');

        $profesionales = Profesional::etapaProfesional($etapas)
            ->perfeccionamiento($perfecion)
            ->paos($inicio_f_pao, $termino_f_pao)
            ->destinacion($inicio_f_ed, $termino_f_ed)
            ->formacion($inicio_f_ef, $termino_f_ef)
            ->establecimiento($etapas, $establecimiento)
            ->estado($estados)
            ->situacionProfesional($situaciones)
            ->orderBy('apellidos', 'asc')
            ->get();

        if ($profesionales->count() > 0) {
            return response()->json(array(true, $profesionales->pluck('id'), $etapasIds));
        } else {
            return response()->json(false);
        }
    }

    public function exportProfesionales($ids, $etapas)
    {
        try {
            $profesionalesArrayId       = explode(',', $ids);
            $profesionalesArrayEtapa    = explode(',', $etapas);

            $total_pao                          = 0;
            $total_especialidades               = 0;
            $total_destinaciones                = 0;
            $array_users_ids_especialidades     = [];
            $array_users_ids_destinaciones      = [];


            $total_devoluciones = 0;

            $with = [
                'etapa',
                'situacionActual',
                'genero',
                'calidad',
                'especialidades.centroFormador',
                'especialidades.perfeccionamiento',
                'especialidades.paos.devoluciones.tipoContrato',
                'especialidades.paos.devoluciones.establecimiento',
                'especialidades.paos.devoluciones.escritura',
                'especialidades.paos.interrupciones.causal',
                'destinaciones.establecimiento',
                'destinaciones.gradoComplejidadEstablecimiento',
                'destinaciones.unidad',
                'userAdd',
                'userUpdate'
            ];



            $profesionales  = Profesional::whereIn('id', $profesionalesArrayId)->whereIn('etapas_id', $profesionalesArrayEtapa)->get();

            $especialidades = Especialidad::whereIn('profesional_id', $profesionales->pluck('id'))->get();
            $destinaciones  = EtapaDestinacion::whereIn('profesional_id', $profesionales->pluck('id'))->get();


            foreach ($especialidades as $especialidad) {
                array_push($array_users_ids_especialidades, $especialidad->profesional_id);
            }

            foreach ($destinaciones as $destinacion) {
                array_push($array_users_ids_destinaciones, $destinacion->profesional_id);
            }

            $profesional = null;
            $total_users_especialidades = array_count_values($array_users_ids_especialidades);
            $total_users_destinaciones  = array_count_values($array_users_ids_destinaciones);

            //total rows formaciones EDF - PAO


            //total rows devoluciones
            if (count($total_users_especialidades) > 0) {
                arsort($total_users_especialidades);

                $id_user_repetido_especialidad = array_key_first($total_users_especialidades);

                $profesional_especialidad = Profesional::find($id_user_repetido_especialidad);

                if ($profesional_especialidad) {
                    foreach ($profesional_especialidad->especialidades as $especialidad) {
                        $total_pao += $especialidad->paos()->count();
                        foreach ($especialidad->paos as $pao) {
                            $total_devoluciones += $pao->devoluciones()->count();
                        }
                    }
                } else {
                    $total_devoluciones = 0;
                }
            }

            //total rows destinaciones
            if ($total_users_destinaciones) {
                arsort($total_users_destinaciones);

                $id_user_repetido_destinacion = array_key_first($total_users_destinaciones);

                $profesional_destinacion = Profesional::find($id_user_repetido_destinacion);

                if ($profesional_destinacion) {
                    $total_destinaciones = $profesional_destinacion->destinaciones()->count();
                } else {
                    $total_destinaciones = 0;
                }
            }

            /* return view('excel.profesionales', compact('profesionales', 'total_pao', 'total_devoluciones', 'total_destinaciones')); */
            return Excel::download(new ProfesionalesExport($profesionales, $total_pao, $total_devoluciones, $total_destinaciones), 'LEY MEDICA - PROFESIONALES.xlsx');
        } catch (\Exception $error) {
            return $error->getMessage();
        }
    }

    //eliminar*
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
