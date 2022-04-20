<?php

namespace App\Http\Controllers\Pao\Interrupciones;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pao\Interrupcion\StoreInterrupcionRequest;
use App\Http\Requests\Pao\Interrupcion\UpdateInterrupcionRequest;
use Illuminate\Http\Request;
use App\Models\Pao;
use App\Models\Devolucion;
use Carbon\Carbon;
use App\Models\Interrupcion;

class InterrupcionesController extends Controller
{
    private function validateInterrupcionStore($request)
    {
        $existe = false;

        $newformat_fecha_ini = Carbon::parse($request->inicio_interrupcion)->format('Y-m-d');
        $newformat_fecha_fin = Carbon::parse($request->termino_interrupcion)->format('Y-m-d');
        $profesional_id      = $request->profesional_id;

        $validacion1 = Interrupcion::where('inicio_interrupcion', '<=', $newformat_fecha_ini)
            ->where('termino_interrupcion', '>=', $newformat_fecha_ini)
            ->where(function ($query) use ($profesional_id) {
                $query->whereHas('pao.especialidad.profesional', function ($query) use ($profesional_id) {
                    $query->where('id', $profesional_id);
                });
            })
            ->count();
        if ($validacion1 > 0) {
            $existe = true;
        }

        $validacion2 = Interrupcion::where('inicio_interrupcion', '<=', $newformat_fecha_fin)
            ->where('termino_interrupcion', '>=', $newformat_fecha_fin)
            ->where(function ($query) use ($profesional_id) {
                $query->whereHas('pao.especialidad.profesional', function ($query) use ($profesional_id) {
                    $query->where('id', $profesional_id);
                });
            })
            ->count();
        if ($validacion2 > 0) {
            $existe = true;
        }

        $validacion3 = Interrupcion::where('inicio_interrupcion', '>=', $newformat_fecha_ini)
            ->where('termino_interrupcion', '<=', $newformat_fecha_fin)
            ->where(function ($query) use ($profesional_id) {
                $query->whereHas('pao.especialidad.profesional', function ($query) use ($profesional_id) {
                    $query->where('id', $profesional_id);
                });
            })
            ->count();
        if ($validacion3) {
            $existe = true;
        }

        return $existe;
    }

    private function validateInterrupcionUpdate($request, $interrupcion_id, $profesional_id)
    {
        $existe = false;

        $newformat_fecha_ini = Carbon::parse($request->inicio_interrupcion)->format('Y-m-d');
        $newformat_fecha_fin = Carbon::parse($request->termino_interrupcion)->format('Y-m-d');



        $validacion1 = Interrupcion::where('id', '!=', $interrupcion_id)
            ->where('inicio_interrupcion', '<=', $newformat_fecha_ini)
            ->where('termino_interrupcion', '>=', $newformat_fecha_ini)
            ->where(function ($query) use ($profesional_id) {
                $query->whereHas('pao.especialidad.profesional', function ($query) use ($profesional_id) {
                    $query->where('id', $profesional_id);
                });
            })
            ->count();
        if ($validacion1 > 0) {
            $existe = true;
        }

        $validacion2 = Interrupcion::where('id', '!=', $interrupcion_id)
            ->where('inicio_interrupcion', '<=', $newformat_fecha_fin)
            ->where('termino_interrupcion', '>=', $newformat_fecha_fin)
            ->where(function ($query) use ($profesional_id) {
                $query->whereHas('pao.especialidad.profesional', function ($query) use ($profesional_id) {
                    $query->where('id', $profesional_id);
                });
            })
            ->count();
        if ($validacion2 > 0) {
            $existe = true;
        }

        $validacion3 = Interrupcion::where('id', '!=', $interrupcion_id)
            ->where('inicio_interrupcion', '>=', $newformat_fecha_ini)
            ->where('termino_interrupcion', '<=', $newformat_fecha_fin)
            ->where(function ($query) use ($profesional_id) {
                $query->whereHas('pao.especialidad.profesional', function ($query) use ($profesional_id) {
                    $query->where('id', $profesional_id);
                });
            })
            ->count();
        if ($validacion3) {
            $existe = true;
        }

        return $existe;
    }

    private function validateDevolucionStore($request)
    {
        $existe = false;

        $newformat_fecha_ini = Carbon::parse($request->inicio_interrupcion)->format('Y-m-d');
        $newformat_fecha_fin = Carbon::parse($request->termino_interrupcion)->format('Y-m-d');
        $profesional_id      = $request->profesional_id;

        $validacion1 = Devolucion::where('inicio_devolucion', '<=', $newformat_fecha_ini)
            ->where('termino_devolucion', '>=', $newformat_fecha_ini)
            ->where(function ($query) use ($profesional_id) {
                $query->whereHas('pao.especialidad.profesional', function ($query) use ($profesional_id) {
                    $query->where('id', $profesional_id);
                });
            })
            ->count();
        if ($validacion1 > 0) {
            $existe = true;
        }

        $validacion2 = Devolucion::where('inicio_devolucion', '<=', $newformat_fecha_fin)
            ->where('termino_devolucion', '>=', $newformat_fecha_fin)
            ->where(function ($query) use ($profesional_id) {
                $query->whereHas('pao.especialidad.profesional', function ($query) use ($profesional_id) {
                    $query->where('id', $profesional_id);
                });
            })
            ->count();
        if ($validacion2 > 0) {
            $existe = true;
        }

        $validacion3 = Devolucion::where('inicio_devolucion', '>=', $newformat_fecha_ini)
            ->where('termino_devolucion', '<=', $newformat_fecha_fin)
            ->where(function ($query) use ($profesional_id) {
                $query->whereHas('pao.especialidad.profesional', function ($query) use ($profesional_id) {
                    $query->where('id', $profesional_id);
                });
            })
            ->count();
        if ($validacion3 > 0) {
            $existe = true;
        }

        return $existe;
    }

    public function storeInterrupcion(StoreInterrupcionRequest $request)
    {
        try {
            $request_form   = ['inicio_interrupcion', 'termino_interrupcion', 'devolucion_id', 'observacion', 'pao_id', 'causal_id'];
            $calculo_pao    = Pao::find($request->pao_id);

            if ($calculo_pao) {
                $existe_interrupcion = $this->validateInterrupcionStore($request);
                $existe_devolucion   = $this->validateDevolucionStore($request);
                if ($existe_interrupcion) {
                    return response()->json('existe-interrupcion');
                } else if ($existe_devolucion) {
                    return response()->json('existe-devolucion');
                } else {
                    $interrupcion = Interrupcion::create($request->only($request_form));

                    $interrupcion->update([
                        'usuario_add_id' => auth()->user()->id,
                        'fecha_add'      => Carbon::now()->toDateTimeString()
                    ]);

                    $with = [
                        'causal',
                        'devolucion.tipoContrato',
                        'devolucion.establecimiento',
                        'devolucion.interrupciones',
                        'pao.devoluciones.establecimiento',
                        'pao.devoluciones.tipoContrato',
                        'userAdd',
                        'userUpdate'
                    ];

                    $interrupcion = $interrupcion->fresh($with);

                    if ($interrupcion) {
                        return response()->json(array(true, $interrupcion));
                    } else {
                        return response()->json(false);
                    }
                }
            }
        } catch (\Exception $error) {
            return response()->json($error->getMessage());
        }
    }

    public function updateInterrupcion(UpdateInterrupcionRequest $request, $uuid)
    {
        try {
            $interrupcion = Interrupcion::where('uuid', $uuid)->first();
            $request_form = ['inicio_interrupcion', 'termino_interrupcion', 'devolucion_id', 'observacion', 'causal_id'];
            $existe_interrupcion = $this->validateInterrupcionUpdate($request, $interrupcion->id, $interrupcion->pao->especialidad->profesional->id);
            $existe_devolucion   = $this->validateDevolucionStore($request);
            if ($interrupcion) {
                if ($existe_interrupcion) {
                    return response()->json('existe-interrupcion');
                } else if ($existe_devolucion) {
                    return response()->json('existe-devolucion');
                } else {
                    $update = $interrupcion->update($request->only($request_form));

                    $interrupcion->update([
                        'usuario_update_id' => auth()->user()->id,
                        'fecha_update'      => Carbon::now()->toDateTimeString()
                    ]);

                    $with = [
                        'causal',
                        'devolucion.tipoContrato',
                        'devolucion.establecimiento',
                        'devolucion.interrupciones',
                        'pao.devoluciones.establecimiento',
                        'pao.devoluciones.tipoContrato',
                        'userAdd',
                        'userUpdate'
                    ];
                    $interrupcion = $interrupcion->fresh($with);

                    if ($update) {
                        return response()->json(array(true, $interrupcion));
                    } else {
                        return response()->json(false);
                    }
                }
            }
        } catch (\Exception $error) {
            return response()->json($error->getMessage());
        }
    }

    public function removeInterrupcion($uuid)
    {
        try {
            $interrupcion = Interrupcion::where('uuid', $uuid)->first();
            if ($interrupcion) {
                $delete = $interrupcion->delete();
                if ($delete) {
                    return response()->json(true);
                } else {
                    return response()->json(false);
                }
            }
        } catch (\Exception $error) {
            return response()->json($error->getMessage());
        }
    }
}
