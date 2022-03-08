<?php

namespace App\Http\Controllers\Edf;

use App\Http\Controllers\Controller;
use App\Http\Requests\Edf\Destinacion\StoreDestinacionRequest;
use App\Http\Requests\Edf\Destinacion\UpdateDestinacionRequest;
use App\Models\EtapaDestinacion;
use App\Models\Profesional;
use App\Models\Especialidad;
use Illuminate\Http\Request;
use Carbon\Carbon;

class EtapaDestinacionController extends Controller
{
    //validación total EDF (10 AÑOS)
    private function validateTotalEdf($profesional, $request)
    {
        $max_days_validate = false;
        $total_days_nueve_años = 3650 + 122;
        $total_days = 0;

        //request-add-destinacion
        $inicio_destinacion     = Carbon::parse(($request->inicio_periodo != null) ? $request->inicio_periodo : '');
        $termino_destinacion    = Carbon::parse(($request->termino_periodo != null) ? $request->termino_periodo : '');
        $diff_days_destinacion  = $inicio_destinacion->diffInDays($termino_destinacion);
        $total_days            += $diff_days_destinacion;

        $destinaciones = EtapaDestinacion::where('profesional_id', $profesional->id)->get();
        $formaciones   = Especialidad::where('profesional_id', $profesional->id)->where('origen', 'EDF')->get();

        foreach ($formaciones as $formacion) {
            $inicio     = Carbon::parse($formacion->inicio_formacion);
            $termino    = Carbon::parse($formacion->termino_formacion);
            $diff_days  = $inicio->diffInDays($termino);
            $total_days += $diff_days;
        }

        foreach ($destinaciones as $destinacion) {
            $inicio     = Carbon::parse($destinacion->inicio_periodo);
            $termino    = Carbon::parse($destinacion->termino_periodo);
            $diff_days  = $inicio->diffInDays($termino);
            $total_days += $diff_days;
        }

        if ($total_days > $total_days_nueve_años) {
            $max_days_validate = true;
        }

        return array($max_days_validate, $total_days);
    }

    //VALIDACIÓN MÍNIMA 3 AÑOS, VALIDACIÓN MAX 6 AÑOS
    private function validateMaxAnosDestinacion($profesional, $request)
    {
        $max_anos       = false;
        $total_days_max = 2190;
        $total_days     = 0;

        if ($request->aumentar === true) {
            $total_days_max = $total_days_max + 122;
        }

        $inicio_destinacion     = Carbon::parse(($request->inicio_periodo != null) ? $request->inicio_periodo : '');
        $termino_destinacion    = Carbon::parse(($request->termino_periodo != null) ? $request->termino_periodo : '');
        $diff_days_destinacion  = $inicio_destinacion->diffInDays($termino_destinacion);
        $total_days             += $diff_days_destinacion;

        $destinaciones = EtapaDestinacion::where('profesional_id', $profesional->id)->get();

        foreach ($destinaciones as $destinacion) {
            $inicio     = Carbon::parse($destinacion->inicio_periodo);
            $termino    = Carbon::parse($destinacion->termino_periodo);
            $diff_days  = $inicio->diffInDays($termino);
            $total_days += $diff_days;
        }

        if ($total_days > $total_days_max) {
            $max_anos = true;
        }

        return array($max_anos, $total_days);
    }

    private function validateFormacion($request, $profesional_id)
    {
        $existe = false;

        $newformat_fecha_ini = Carbon::parse($request->inicio_periodo)->format('Y-m-d');
        $newformat_fecha_fin = Carbon::parse($request->termino_periodo)->format('Y-m-d');

        $validacion1 = Especialidad::where('profesional_id', $profesional_id)
            ->where('inicio_formacion', '<=', $newformat_fecha_ini)
            ->where('termino_formacion', '>=', $newformat_fecha_ini)
            ->count();
        if ($validacion1 > 0) {
            $existe = true;
        }

        $validacion2 = Especialidad::where('profesional_id', $profesional_id)
            ->where('inicio_formacion', '<=', $newformat_fecha_fin)
            ->where('termino_formacion', '>=', $newformat_fecha_fin)
            ->count();
        if ($validacion2 > 0) {
            $existe = true;
        }

        $validacion3 = Especialidad::where('profesional_id', $profesional_id)
            ->where('inicio_formacion', '>=', $newformat_fecha_ini)
            ->where('termino_formacion', '<=', $newformat_fecha_fin)
            ->count();
        if ($validacion3 > 0) {
            $existe = true;
        }

        return $existe;
    }

    private function validateDestinacion($request)
    {
        $existe = false;

        $newformat_fecha_ini = Carbon::parse($request->inicio_periodo)->format('Y-m-d');
        $newformat_fecha_fin = Carbon::parse($request->termino_periodo)->format('Y-m-d');

        $validacion1 = EtapaDestinacion::where('profesional_id', $request->profesional_id)
            ->where('inicio_periodo', '<=', $newformat_fecha_ini)
            ->where('termino_periodo', '>=', $newformat_fecha_ini)
            ->count();
        if ($validacion1 > 0) {
            $existe = true;
        }

        $validacion2 = EtapaDestinacion::where('profesional_id', $request->profesional_id)
            ->where('inicio_periodo', '<=', $newformat_fecha_fin)
            ->where('termino_periodo', '>=', $newformat_fecha_fin)
            ->count();
        if ($validacion2 > 0) {
            $existe = true;
        }

        $validacion3 = EtapaDestinacion::where('profesional_id', $request->profesional_id)
            ->where('inicio_periodo', '>=', $newformat_fecha_ini)
            ->where('termino_periodo', '<=', $newformat_fecha_fin)
            ->count();
        if ($validacion3 > 0) {
            $existe = true;
        }

        return $existe;
    }





    //EDIT VALIDACIONES
    private function validateTotalEdfEdit($request, $destinacion_id, $profesional_id)
    {
        $max_days_validate = false;
        $total_days_nueve_años = 3650 + 122;
        $total_days = 0;

        //request-add-destinacion
        $inicio_destinacion     = Carbon::parse(($request->inicio_periodo != null) ? $request->inicio_periodo : '');
        $termino_destinacion    = Carbon::parse(($request->termino_periodo != null) ? $request->termino_periodo : '');
        $diff_days_destinacion  = $inicio_destinacion->diffInDays($termino_destinacion);
        $total_days            += $diff_days_destinacion;

        $destinaciones = EtapaDestinacion::where('id', '!=', $destinacion_id)->where('profesional_id', $profesional_id)->get();
        $formaciones   = Especialidad::where('profesional_id', $profesional_id)->where('origen', 'EDF')->get();

        foreach ($formaciones as $formacion) {
            $inicio     = Carbon::parse($formacion->inicio_formacion);
            $termino    = Carbon::parse($formacion->termino_formacion);
            $diff_days  = $inicio->diffInDays($termino);
            $total_days += $diff_days;
        }

        foreach ($destinaciones as $destinacion) {
            $inicio     = Carbon::parse($destinacion->inicio_periodo);
            $termino    = Carbon::parse($destinacion->termino_periodo);
            $diff_days  = $inicio->diffInDays($termino);
            $total_days += $diff_days;
        }

        if ($total_days > $total_days_nueve_años) {
            $max_days_validate = true;
        }

        return array($max_days_validate, $total_days);
    }

    private function validateDestinacionEdit($request, $destinacion_id, $profesional_id)
    {
        $existe = false;

        $newformat_fecha_ini = Carbon::parse($request->inicio_periodo)->format('Y-m-d');
        $newformat_fecha_fin = Carbon::parse($request->termino_periodo)->format('Y-m-d');

        $validacion1 = EtapaDestinacion::where('id', '!=', $destinacion_id)
            ->where('profesional_id', $profesional_id)
            ->where('inicio_periodo', '<=', $newformat_fecha_ini)
            ->where('termino_periodo', '>=', $newformat_fecha_ini)
            ->count();
        if ($validacion1 > 0) {
            $existe = true;
        }

        $validacion2 = EtapaDestinacion::where('id', '!=', $destinacion_id)
            ->where('profesional_id', $profesional_id)
            ->where('inicio_periodo', '<=', $newformat_fecha_fin)
            ->where('termino_periodo', '>=', $newformat_fecha_fin)
            ->count();
        if ($validacion2 > 0) {
            $existe = true;
        }

        $validacion3 = EtapaDestinacion::where('id', '!=', $destinacion_id)
            ->where('profesional_id', $profesional_id)
            ->where('inicio_periodo', '>=', $newformat_fecha_ini)
            ->where('termino_periodo', '<=', $newformat_fecha_fin)
            ->count();
        if ($validacion3 > 0) {
            $existe = true;
        }

        return $existe;
    }

    private function validateMaxAnosDestinacionEdit($request, $profesional_id, $destinacion_id)
    {
        $max_anos       = false;
        $total_days_max = 2190;
        $total_days     = 0;

        if ($request->aumentar === true) {
            $total_days_max = $total_days_max + 122;
        }

        $inicio_destinacion     = Carbon::parse(($request->inicio_periodo != null) ? $request->inicio_periodo : '');
        $termino_destinacion    = Carbon::parse(($request->termino_periodo != null) ? $request->termino_periodo : '');
        $diff_days_destinacion  = $inicio_destinacion->diffInDays($termino_destinacion);
        $total_days             += $diff_days_destinacion;

        $destinaciones = EtapaDestinacion::where('id', '!=', $destinacion_id)->where('profesional_id', $profesional_id)->get();

        foreach ($destinaciones as $destinacion) {
            $inicio     = Carbon::parse($destinacion->inicio_periodo);
            $termino    = Carbon::parse($destinacion->termino_periodo);
            $diff_days  = $inicio->diffInDays($termino);
            $total_days += $diff_days;
        }

        if ($total_days > $total_days_max) {
            $max_anos = true;
        }

        return array($max_anos, $total_days);
    }


    public function getDestinaciones(Request $request)
    {
        try {
            $profesional = Profesional::where('uuid', $request->uuid)->first();
            if ($profesional) {
                $with = ['profesional', 'establecimiento.redHospitalaria', 'gradoComplejidadEstablecimiento', 'unidad', 'situacionProfesional', 'userAdd', 'userUpdate'];
                $destinaciones = EtapaDestinacion::with($with)->where('profesional_id', $profesional->id)->get();

                return response()->json($destinaciones);
            }
        } catch (\Exception $error) {
            return response()->json($error->getMessage());
        }
    }

    public function storeDestinacion(StoreDestinacionRequest $request)
    {
        try {
            $request_form                       = ['inicio_periodo', 'termino_periodo', 'aumentar', 'aumentar_observacion', 'observacion', 'profesional_id', 'establecimiento_id', 'grado_complejidad_establecimiento_id', 'unidad_id', 'situacion_profesional_id'];
            $profesional                        = Profesional::find($request->profesional_id);
            if ($profesional) {
                $profesional_id = $profesional->id;
                $validacion_fechas_formacion    = $this->validateFormacion($request, $profesional_id);
                $validacion_fechas_destinacion  = $this->validateDestinacion($request);

                if ($request->aumentar) {
                    $passing_max_total_edf[0]          = false;
                    $max_total_destinacion[0]          = false;
                } else {
                    $passing_max_total_edf             = $this->validateTotalEdf($profesional, $request);
                    $max_total_destinacion             = $this->validateMaxAnosDestinacion($profesional, $request);
                }

                if ($passing_max_total_edf[0]) {
                    return response()->json(array('max-days', $passing_max_total_edf[1]));
                } else if ($validacion_fechas_formacion) {
                    return response()->json('fechas-entrelazadas-formacion');
                } else if ($validacion_fechas_destinacion) {
                    return response()->json('fechas-entrelazadas-destinacion');
                } else if ($max_total_destinacion[0]) {
                    return response()->json(array('max-destinacion', $max_total_destinacion[1]));
                } else {
                    $etapaDestinacion = EtapaDestinacion::create($request->only($request_form));

                    $etapaDestinacion->update([
                        'usuario_add_id' => auth()->user()->id,
                        'fecha_add'      => Carbon::now()->toDateTimeString()
                    ]);

                    $with = ['profesional', 'establecimiento.redHospitalaria', 'gradoComplejidadEstablecimiento', 'unidad', 'situacionProfesional', 'userAdd', 'userUpdate'];
                    $etapaDestinacion = $etapaDestinacion->fresh($with);

                    if ($etapaDestinacion) {
                        return response()->json(array(true, $etapaDestinacion));
                    } else {
                        return response()->json(false);
                    }
                }
            }
        } catch (\Exception $error) {
            return response()->json($error->getMessage());
        }
    }

    public function updateDestinacion(UpdateDestinacionRequest $request, $id)
    {
        try {
            $destinacion        = EtapaDestinacion::find($id);
            if ($destinacion) {
                $profesional_id = $destinacion->profesional_id;
                $destinacion_id = $destinacion->id;

                $validacion_fechas_formacion         = $this->validateFormacion($request, $profesional_id);
                $validacion_fechas_destinacion       = $this->validateDestinacionEdit($request, $destinacion_id, $profesional_id);

                if($request->aumentar){
                    $passing_max_total_edf_edit[0]      = false;
                    $max_total_destinacion[0]           = false;
                }else{
                    $passing_max_total_edf_edit          = $this->validateTotalEdfEdit($request, $destinacion_id, $profesional_id);
                    $max_total_destinacion               = $this->validateMaxAnosDestinacionEdit($request, $profesional_id, $destinacion_id);
                }

                if ($passing_max_total_edf_edit[0]) {
                    return response()->json(array('max-days', $passing_max_total_edf_edit[1]));
                } else if ($validacion_fechas_formacion) {
                    return response()->json('fechas-entrelazadas-formacion');
                } else if ($validacion_fechas_destinacion) {
                    return response()->json('fechas-entrelazadas-destinacion');
                } else if ($max_total_destinacion[0]) {
                    return response()->json(array('max-destinacion', $max_total_destinacion[1]));
                } else {
                    $update      = $destinacion->update($request->all());

                    $destinacion->update([
                        'usuario_update_id' => auth()->user()->id,
                        'fecha_update'      => Carbon::now()->toDateTimeString()
                    ]);

                    $with = ['profesional', 'establecimiento.redHospitalaria', 'gradoComplejidadEstablecimiento', 'unidad', 'situacionProfesional', 'userAdd', 'userUpdate'];
                    $destinacion = $destinacion->fresh($with);

                    if ($update) {
                        return response()->json(array(true, $destinacion));
                    } else {
                        return response()->json(false);
                    }
                }
            }
        } catch (\Exception $error) {
            return response()->json($error->getMessage());
        }
    }

    public function deleteDestinacion($uuid)
    {
        try {
            $destinacion = EtapaDestinacion::where('uuid', $uuid)->first();
            if ($destinacion) {
                $delete = $destinacion->delete();

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
