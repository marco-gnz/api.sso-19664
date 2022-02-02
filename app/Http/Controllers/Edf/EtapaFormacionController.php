<?php

namespace App\Http\Controllers\Edf;

use App\Http\Controllers\Controller;
use App\Http\Requests\Edf\Formacion\UpdateFormacionRequest;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Requests\Formacion\StoreFormacionRequest;
use App\Models\Especialidad;
use App\Models\Profesional;
use App\Models\EtapaDestinacion;

class EtapaFormacionController extends Controller
{
    private function validateTotalEdf($profesional, $request)
    {
        $max_days_validate = false;
        $total_days_nueve_años = 3285;
        $total_days = 0;

        //request-add-destinacion
        $inicio_destinacion     = Carbon::parse(($request->inicio_formacion != null) ? $request->inicio_formacion : '');
        $termino_destinacion    = Carbon::parse(($request->termino_formacion != null) ? $request->termino_formacion : '');
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

    private function validateFormacion($request)
    {
        $existe = false;

        $newformat_fecha_ini = Carbon::parse($request->inicio_formacion)->format('Y-m-d');
        $newformat_fecha_fin = Carbon::parse($request->termino_formacion)->format('Y-m-d');

        $validacion1 = Especialidad::where('profesional_id', $request->profesional_id)
            ->where('inicio_formacion', '<=', $newformat_fecha_ini)
            ->where('termino_formacion', '>=', $newformat_fecha_ini)
            ->count();
        if ($validacion1 > 0) {
            $existe = true;
        }

        $validacion2 = Especialidad::where('profesional_id', $request->profesional_id)
            ->where('inicio_formacion', '<=', $newformat_fecha_fin)
            ->where('termino_formacion', '>=', $newformat_fecha_fin)
            ->count();
        if ($validacion2 > 0) {
            $existe = true;
        }

        $validacion3 = Especialidad::where('profesional_id', $request->profesional_id)
            ->where('inicio_formacion', '>=', $newformat_fecha_ini)
            ->where('termino_formacion', '<=', $newformat_fecha_fin)
            ->count();
        if ($validacion3 > 0) {
            $existe = true;
        }

        return $existe;
    }

    private function validateDestinacion($request, $profesional_id)
    {
        $existe = false;

        $newformat_fecha_ini = Carbon::parse($request->inicio_formacion)->format('Y-m-d');
        $newformat_fecha_fin = Carbon::parse($request->termino_formacion)->format('Y-m-d');

        $validacion1 = EtapaDestinacion::where('profesional_id', $profesional_id)
            ->where('inicio_periodo', '<=', $newformat_fecha_ini)
            ->where('termino_periodo', '>=', $newformat_fecha_ini)
            ->count();
        if ($validacion1 > 0) {
            $existe = true;
        }

        $validacion2 = EtapaDestinacion::where('profesional_id', $profesional_id)
            ->where('inicio_periodo', '<=', $newformat_fecha_fin)
            ->where('termino_periodo', '>=', $newformat_fecha_fin)
            ->count();
        if ($validacion2 > 0) {
            $existe = true;
        }

        $validacion3 = EtapaDestinacion::where('profesional_id', $profesional_id)
            ->where('inicio_periodo', '>=', $newformat_fecha_ini)
            ->where('termino_periodo', '<=', $newformat_fecha_fin)
            ->count();
        if ($validacion3 > 0) {
            $existe = true;
        }

        return $existe;
    }

    //VALIDACIÓN MAX 4 AÑOS
    private function validateMaxAnosFormacion($profesional, $request)
    {
        $max_anos       = false;
        $total_days_max = 1460;
        $total_days     = 0;

        $inicio_destinacion     = Carbon::parse(($request->inicio_periodo != null) ? $request->inicio_periodo : '');
        $termino_destinacion    = Carbon::parse(($request->termino_periodo != null) ? $request->termino_periodo : '');
        $diff_days_destinacion  = $inicio_destinacion->diffInDays($termino_destinacion);
        $total_days             += $diff_days_destinacion;

        $formaciones = Especialidad::where('profesional_id', $profesional->id)->where('origen', 'EDF')->get();

        foreach ($formaciones as $formacion) {
            $inicio     = Carbon::parse($formacion->inicio_formacion);
            $termino    = Carbon::parse($formacion->termino_formacion);
            $diff_days  = $inicio->diffInDays($termino);
            $total_days += $diff_days;
        }

        if ($total_days > $total_days_max) {
            $max_anos = true;
        }

        return array($max_anos, $total_days);
    }




    //edit validate
    private function validateTotalEdfEdit($profesional, $request, $formacion_id)
    {
        $max_days_validate = false;
        $total_days_nueve_años = 3285;
        $total_days = 0;

        //request-add-destinacion
        $inicio_destinacion     = Carbon::parse(($request->inicio_formacion != null) ? $request->inicio_formacion : '');
        $termino_destinacion    = Carbon::parse(($request->termino_formacion != null) ? $request->termino_formacion : '');
        $diff_days_destinacion  = $inicio_destinacion->diffInDays($termino_destinacion);
        $total_days            += $diff_days_destinacion;

        $destinaciones = EtapaDestinacion::where('profesional_id', $profesional->id)->get();
        $formaciones   = Especialidad::where('id', '!=', $formacion_id)->where('profesional_id', $profesional->id)->where('origen', 'EDF')->get();

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

    private function validateFormacionEdit($request, $profesional_id, $formacion_id)
    {
        $existe = false;

        $newformat_fecha_ini = Carbon::parse($request->inicio_formacion)->format('Y-m-d');
        $newformat_fecha_fin = Carbon::parse($request->termino_formacion)->format('Y-m-d');

        $validacion1 = Especialidad::where('id', '!=', $formacion_id)
            ->where('profesional_id', $profesional_id)
            ->where('inicio_formacion', '<=', $newformat_fecha_ini)
            ->where('termino_formacion', '>=', $newformat_fecha_ini)
            ->count();
        if ($validacion1 > 0) {
            $existe = true;
        }

        $validacion2 = Especialidad::where('id', '!=', $formacion_id)
            ->where('profesional_id', $profesional_id)
            ->where('inicio_formacion', '<=', $newformat_fecha_fin)
            ->where('termino_formacion', '>=', $newformat_fecha_fin)
            ->count();
        if ($validacion2 > 0) {
            $existe = true;
        }

        $validacion3 = Especialidad::where('id', '!=', $formacion_id)
            ->where('profesional_id', $profesional_id)
            ->where('inicio_formacion', '>=', $newformat_fecha_ini)
            ->where('termino_formacion', '<=', $newformat_fecha_fin)
            ->count();
        if ($validacion3 > 0) {
            $existe = true;
        }

        return $existe;
    }

    private function validateMaxAnosFormacionEdit($request, $profesional_id, $especialidad_id)
    {
        $max_anos       = false;
        $total_days_max = 1460;
        $total_days     = 0;

        $inicio_destinacion     = Carbon::parse(($request->inicio_periodo != null) ? $request->inicio_periodo : '');
        $termino_destinacion    = Carbon::parse(($request->termino_periodo != null) ? $request->termino_periodo : '');
        $diff_days_destinacion  = $inicio_destinacion->diffInDays($termino_destinacion);
        $total_days             += $diff_days_destinacion;

        $formaciones = Especialidad::where('id', '!=', $especialidad_id)->where('profesional_id', $profesional_id)->where('origen', 'EDF')->get();

        foreach ($formaciones as $formacion) {
            $inicio     = Carbon::parse($formacion->inicio_formacion);
            $termino    = Carbon::parse($formacion->termino_formacion);
            $diff_days  = $inicio->diffInDays($termino);
            $total_days += $diff_days;
        }

        if ($total_days > $total_days_max) {
            $max_anos = true;
        }

        return array($max_anos, $total_days);
    }

    public function getFormaciones(Request $request)
    {
        try {
            $profesional = Profesional::where('uuid', $request->uuid)->first();
            if ($profesional) {
                $formaciones = Especialidad::with('centroFormador', 'perfeccionamiento.tipo')->where('profesional_id', $profesional->id)->where('origen', 'EDF')->orderBy('id', 'asc')->get();
                return response()->json($formaciones);
            }
        } catch (\Exception $error) {
            return response()->json($error->getMessage());
        }
    }

    public function storeFormacion(StoreFormacionRequest $request)
    {
        try {
            $request_form                   = ['fecha_registro', 'inicio_formacion', 'termino_formacion', 'observacion', 'profesional_id', 'centro_formador_id', 'perfeccionamiento_id'];
            $profesional = Profesional::find($request->profesional_id);

            if ($profesional) {
                $passing_max_total_edf          = $this->validateTotalEdf($profesional, $request);
                $validacion_fechas_formacion    = $this->validateFormacion($request);
                $validacion_fechas_destinacion  = $this->validateDestinacion($request, $profesional->id);
                $max_total_formacion            = $this->validateMaxAnosFormacion($profesional, $request);

                if ($passing_max_total_edf[0]) {
                    return response()->json(array('max-days', $passing_max_total_edf[1]));
                } else if ($validacion_fechas_formacion) {
                    return response()->json('fechas-entrelazadas-formacion');
                } else if ($validacion_fechas_destinacion) {
                    return response()->json('fechas-entrelazadas-destinacion');
                } else if ($max_total_formacion[0]) {
                    return response()->json(array('max-formacion', $max_total_formacion[1]));
                } else {
                    $formacion = Especialidad::create($request->only($request_form));

                    $update = $formacion->update([
                        'origen'         => 'EDF',
                        'usuario_add_id' => auth()->user()->id,
                        'fecha_add'      => Carbon::now()->toDateTimeString()
                    ]);

                    $with = ['profesional', 'centroFormador', 'perfeccionamiento', 'perfeccionamiento.tipo'];

                    $formacion = $formacion->fresh($with);

                    if ($formacion && $update) {
                        return response()->json(array(true, $formacion));
                    } else {
                        return response()->json(false);
                    }
                }
            }
        } catch (\Exception $error) {
            return response()->json($error->getMessage());
        }
    }

    public function updateFormacion(UpdateFormacionRequest $request, $id)
    {
        try {
            $formacion = Especialidad::find($id);

            if ($formacion) {
                $request_form = ['fecha_registro', 'inicio_formacion', 'termino_formacion', 'observacion', 'centro_formador_id', 'perfeccionamiento_id'];

                $profesional = $formacion->profesional;
                $passing_max_total_edf           = $this->validateTotalEdfEdit($profesional, $request, $formacion->id);
                $validacion_fechas_formacion     = $this->validateFormacionEdit($request, $profesional->id, $formacion->id);
                $validacion_fechas_destinacion   = $this->validateDestinacion($request, $profesional->id);
                $max_total_formacion             = $this->validateMaxAnosFormacionEdit($request, $profesional->id, $formacion->id);

                if ($passing_max_total_edf[0]) {
                    return response()->json(array('max-days', $passing_max_total_edf[1]));
                } else if ($validacion_fechas_formacion) {
                    return response()->json('fechas-entrelazadas-formacion');
                } else if ($validacion_fechas_destinacion) {
                    return response()->json('fechas-entrelazadas-destinacion');
                } else if ($max_total_formacion[0]) {
                    return response()->json(array('max-formacion', $max_total_formacion[1]));
                } else {
                    $update = $formacion->update($request->only($request_form));

                    $update = $formacion->update([
                        'usuario_update_id' => auth()->user()->id,
                        'fecha_update'      => Carbon::now()->toDateTimeString()
                    ]);

                    $with = ['profesional', 'centroFormador', 'perfeccionamiento', 'perfeccionamiento.tipo'];

                    $formacion = $formacion->fresh($with);

                    if ($formacion && $update) {
                        return response()->json(array(true, $formacion));
                    } else {
                        return response()->json(false);
                    }
                }
            }
        } catch (\Exception $error) {
            return response()->json($error->getMessage());
        }
    }

    public function deleteFormacion($uuid)
    {
        try {
            $formacion = Especialidad::where('uuid', $uuid)->first();
            if ($formacion) {
                $delete = $formacion->delete();

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
