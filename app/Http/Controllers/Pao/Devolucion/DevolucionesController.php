<?php

namespace App\Http\Controllers\Pao\Devolucion;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pao\Devolucion\StoreDevolucionController;
use App\Http\Requests\Pao\Devolucion\UpdateDevolucionRequest;
use App\Models\Devolucion;
use App\Models\Escritura;
use App\Models\Interrupcion;
use App\Models\Pao;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DevolucionesController extends Controller
{
    private function validateDevolucionStore($request)
    {
        $existe = false;

        $newformat_fecha_ini = Carbon::parse($request->inicio_devolucion)->format('Y-m-d');
        $newformat_fecha_fin = Carbon::parse($request->termino_devolucion)->format('Y-m-d');
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

    private function validateDevolucionUpdate($request, $devolucion_id)
    {
        $existe = false;

        $newformat_fecha_ini = Carbon::parse($request->inicio_devolucion)->format('Y-m-d');
        $newformat_fecha_fin = Carbon::parse($request->termino_devolucion)->format('Y-m-d');
        $profesional_id      = $request->profesional_id;

        $validacion1 = Devolucion::where('id', '!=', $devolucion_id)
            ->where('inicio_devolucion', '<=', $newformat_fecha_ini)
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

        $validacion2 = Devolucion::where('id', '!=', $devolucion_id)
            ->where('inicio_devolucion', '<=', $newformat_fecha_fin)
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

        $validacion3 = Devolucion::where('id', '!=', $devolucion_id)
            ->where('inicio_devolucion', '>=', $newformat_fecha_ini)
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

    private function validateInterrupcionStore($request)
    {
        $existe = false;

        $newformat_fecha_ini = Carbon::parse($request->inicio_devolucion)->format('Y-m-d');
        $newformat_fecha_fin = Carbon::parse($request->termino_devolucion)->format('Y-m-d');
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
        if ($validacion3 > 0) {
            $existe = true;
        }

        return $existe;
    }

    public function storeDevolucion(StoreDevolucionController $request)
    {
        try {
            $form_request = ['inicio_devolucion', 'termino_devolucion', 'observacion', 'color', 'tipo_contrato', 'pao_id', 'establecimiento_id', 'profesional_id'];
            $pao = Pao::find($request->pao_id);
            $escritura = Escritura::find($request->escritura_id);

            $id_escritura = ($escritura) ? $escritura->id : NULL;
            if ($pao) {
                $existe_devolucion      = $this->validateDevolucionStore($request);
                $existe_interrupcion    = $this->validateInterrupcionStore($request);
                if ($existe_devolucion) {
                    return response()->json('existe-devolucion');
                } else if ($existe_interrupcion) {
                    return response()->json('existe-interrupcion');
                } else {
                    $devolucion = Devolucion::create($request->only($form_request));

                    $update = $devolucion->update([
                        'escritura_id'      => $id_escritura,
                        'usuario_add_id'    => auth()->user()->id,
                        'fecha_add'         => Carbon::now()->toDateTimeString()
                    ]);

                    $with = ['tipoContrato', 'establecimiento', 'establecimiento.redHospitalaria', 'escritura', 'interrupciones', 'pao.especialidad'];

                    $devolucion = $devolucion->fresh($with);

                    if ($devolucion) {
                        return response()->json(array(true, $devolucion));
                    } else {
                        return response()->json(false);
                    }
                }
            }
        } catch (\Exception $error) {
            return response()->json($error->getMessage());
        }
    }

    public function updateDevolucion(UpdateDevolucionRequest $request, $uuid)
    {
        try {
            $devolucion = Devolucion::where('uuid', $uuid)->first();

            if ($devolucion) {
                $existe_devolucion      = $this->validateDevolucionUpdate($request, $devolucion->id);
                $existe_interrupcion    = $this->validateInterrupcionStore($request);
                if ($existe_devolucion) {
                    return response()->json('existe-devolucion');
                } else if ($existe_interrupcion) {
                    return response()->json('existe-interrupcion');
                } else {
                    $update = $devolucion->update($request->all());

                    $with = ['tipoContrato', 'establecimiento', 'establecimiento.redHospitalaria', 'escritura', 'interrupciones', 'pao.especialidad'];

                    $devolucion = $devolucion->fresh($with);

                    if ($update) {
                        return response()->json(array(true, $devolucion));
                    } else {
                        return response()->json(false);
                    }
                }
            }
        } catch (\Exception $error) {
            return response()->json($error->getMessage());
        }
    }

    public function removeDevolucion($uuid)
    {
        try {
            $devolucion = Devolucion::where('uuid', $uuid)->first();
            if ($devolucion) {
                $delete = $devolucion->delete();
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
