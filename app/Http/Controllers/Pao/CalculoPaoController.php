<?php

namespace App\Http\Controllers\Pao;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pao\StorePaoCalculoRequest;
use App\Http\Resources\DevolucionesResource;
use App\Http\Resources\InterrupcionesResource;
use App\Models\Devolucion;
use App\Models\Escritura;
use App\Models\Especialidad;
use App\Models\Pao;
use App\Models\Profesional;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CalculoPaoController extends Controller
{
    public function getPaos(Request $request)
    {
        try {
            $profesional = Profesional::where('uuid', $request->uuid)->first();
            if ($profesional) {
                $especialidades = $profesional->especialidades()->get();
                $with = [
                    'especialidad',
                    'especialidad.perfeccionamiento.tipo',
                    'devoluciones.tipoContrato',
                    'devoluciones.establecimiento',
                    'devoluciones.establecimiento.redHospitalaria',
                    'devoluciones.pao.especialidad',
                    'devoluciones.pao.devoluciones.tipoContrato',
                    'devoluciones.pao.interrupciones',
                    'devoluciones.interrupciones',
                    'devoluciones.escritura',
                    'devoluciones.userAdd',
                    'devoluciones.userUpdate',

                    'interrupciones.causal',
                    'interrupciones.devolucion.establecimiento',
                    'interrupciones.devolucion.tipoContrato',
                    'interrupciones.devolucion.interrupciones',
                    'interrupciones.pao.devoluciones.establecimiento',
                    'interrupciones.pao.devoluciones.tipoContrato',
                    'interrupciones.userAdd',
                    'interrupciones.userUpdate',

                    'userAdd'
                ];

                $paos = Pao::whereIn('especialidad_id', $especialidades->pluck('id'))->with($with)->get();

                return response()->json($paos);
            }
        } catch (\Exception $error) {
            return response()->json($error->getMessage());
        }
    }

    public function getHistorial(Request $request)
    {
        try {
            $pao = Pao::find($request->pao_id);
            if ($pao) {
                $devoluciones   = DevolucionesResource::collection($pao->devoluciones);
                $interrupciones = InterrupcionesResource::collection($pao->interrupciones);

                $procesos = $devoluciones->merge($interrupciones);
                $especialidad = $pao->especialidad->perfeccionamiento->nombre;
                $tipo_especialidad = $pao->especialidad->perfeccionamiento->tipo->nombre;

                return response()->json(array($procesos, $especialidad, $tipo_especialidad));
            }
        } catch (\Exception $error) {
            return response()->json($error->getMessage());
        }
    }

    public function storeCalculoPao(StorePaoCalculoRequest $request)
    {
        try {
            $formacion = Especialidad::find($request->especialidad_id);
            if ($formacion) {
                $calculo_pao = Pao::create($request->all());
                $calculo_pao->update([
                    'usuario_add_id'    => auth()->user()->id,
                    'fecha_add'         => Carbon::now()->toDateTimeString()
                ]);
                $with = [
                    'especialidad',
                    'especialidad.perfeccionamiento.tipo',
                    'devoluciones.userAdd',
                    'devoluciones.userUpdate',
                    'devoluciones.tipoContrato',
                    'devoluciones.establecimiento',
                    'devoluciones.establecimiento.redHospitalaria',
                    'devoluciones.pao.especialidad',
                    'interrupciones.userAdd',
                    'interrupciones.userUpdate',
                    'interrupciones.causal',
                    'devoluciones.interrupciones',
                    'devoluciones.escritura',
                    'interrupciones.devolucion.establecimiento',
                    'interrupciones.devolucion.tipoContrato',
                    'interrupciones.pao.devoluciones.establecimiento',
                    'interrupciones.pao.devoluciones.tipoContrato',
                    'devoluciones.pao.devoluciones.tipoContrato',
                    'devoluciones.pao.interrupciones',
                    'userAdd'
                ];
                $calculo_pao  = $calculo_pao->fresh($with);
                if ($calculo_pao) {
                    return response()->json(array(true, $calculo_pao));
                } else {
                    return response()->json(false);
                }
            }
        } catch (\Exception $error) {
            return response()->json($error->getMessage());
        }
    }

    public function deletePao($uuid)
    {
        try {
            $pao = Pao::where('uuid', $uuid)->first();
            if ($pao) {
                if ($pao->devoluciones()->count() > 0) {
                    return response()->json('max-devoluciones');
                } else if ($pao->interrupciones()->count() > 0) {
                    return response()->json('max-interrupciones');
                } else {
                    $delete = $pao->delete();
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

    public function getEscrituras(Request $request)
    {
        try {
            $especialidad = Especialidad::find($request->especialidad_id);
            if ($especialidad) {
                $escrituras = Escritura::with('especialidad.perfeccionamiento.tipo', 'especialidad.centroFormador')->where('especialidad_id', $especialidad->id)->get();

                return response()->json($escrituras);
            }
        } catch (\Exception $error) {
            return response()->json($error->getMessage());
        }
    }

    public function updateStatus($uuid)
    {
        try {
            $pao = Pao::where('uuid', $uuid)->first();

            if ($pao) {
                $update = $pao->update([
                    'estado' => !$pao->estado
                ]);

                $with = [
                    'especialidad',
                    'especialidad.perfeccionamiento.tipo',
                    'devoluciones.userAdd',
                    'devoluciones.userUpdate',
                    'devoluciones.tipoContrato',
                    'devoluciones.establecimiento',
                    'devoluciones.establecimiento.redHospitalaria',
                    'devoluciones.pao.especialidad',
                    'interrupciones.userAdd',
                    'interrupciones.userUpdate',
                    'interrupciones.causal',
                    'devoluciones.interrupciones',
                    'devoluciones.escritura',
                    'interrupciones.devolucion.establecimiento',
                    'interrupciones.devolucion.tipoContrato',
                    'interrupciones.pao.devoluciones.establecimiento',
                    'interrupciones.pao.devoluciones.tipoContrato',
                    'devoluciones.pao.devoluciones.tipoContrato',
                    'devoluciones.pao.interrupciones',
                    'userAdd'
                ];

                $pao = $pao->fresh($with);

                if ($pao && $update) {
                    return response()->json(array(true, $pao));
                } else {
                    return response()->json(false);
                }
            }
        } catch (\Exception $error) {
            return response()->json($error->getMessage());
        }
    }
}
