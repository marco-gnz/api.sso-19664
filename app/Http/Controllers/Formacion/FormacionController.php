<?php

namespace App\Http\Controllers\Formacion;

use App\Http\Controllers\Controller;
use App\Http\Requests\Formacion\StoreFormacionRequest;
use App\Http\Requests\Formacion\UpdateFormacionRequest;
use App\Models\Especialidad;
use App\Models\Profesional;
use App\Models\Perfeccionamiento;
use Illuminate\Http\Request;
use Carbon\Carbon;

class FormacionController extends Controller
{
    private function validateFormacion($request)
    {
        $existe = false;

        if ($request->inicio_formacion || $request->termino_formacion) {
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
        }

        return $existe;
    }

    private function validateFormacionUpdate($request, $formacion_id, $profesional_id)
    {
        $existe = false;

        if ($request->inicio_formacion || $request->termino_formacion) {
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
        }

        return $existe;
    }

    public function getFormaciones(Request $request)
    {
        try {
            $profesional = Profesional::where('uuid', $request->uuid)->first();

            if ($profesional) {
                $with = ['profesional', 'centroFormador', 'perfeccionamiento', 'perfeccionamiento.tipo', 'situacionProfesional', 'campoClinico', 'userAdd', 'userUpdate'];
                $especialidades = $profesional->especialidades()->where('origen', 'PAO')->with($with)->orderBy('id', 'asc')->get();
                return response()->json($especialidades);
            }
        } catch (\Exception $error) {
            return response()->json($error->getMessage());
        }
    }

    public function storeFormacion(StoreFormacionRequest $request)
    {
        try {
            $validacionFechas = $this->validateFormacion($request);
            if ($validacionFechas) {
                return response()->json('fechas-entrelazadas');
            } else {
                $profesional = Profesional::find($request->profesional_id);
                if ($profesional) {
                    $form = [
                        'profesional_id',
                        'fecha_registro',
                        'origen',
                        'situacion_profesional_id',
                        'inicio_formacion',
                        'termino_formacion',
                        'contabilizar_periodo',
                        'observacion',
                        'centro_formador_id',
                        'perfeccionamiento_id',
                        'campo_clinico_id'
                    ];
                    $formacion = Especialidad::create($request->only($form));

                    $update = $formacion->update([
                        'usuario_add_id' => auth()->user()->id,
                        'fecha_add'      => Carbon::now()->toDateTimeString()
                    ]);

                    $with = ['profesional', 'centroFormador', 'perfeccionamiento', 'perfeccionamiento.tipo', 'paos', 'situacionProfesional', 'campoClinico', 'userAdd', 'userUpdate'];

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
                $validacionFechas = $this->validateFormacionUpdate($request, $formacion->id, $formacion->profesional->id);

                if ($validacionFechas) {
                    return response()->json('fechas-entrelazadas');
                } else {

                    $form = [
                        'fecha_registro',
                        'origen',
                        'situacion_profesional_id',
                        'inicio_formacion',
                        'termino_formacion',
                        'contabilizar_periodo',
                        'observacion',
                        'centro_formador_id',
                        'perfeccionamiento_id',
                        'campo_clinico_id'
                    ];
                    $update = $formacion->update($request->only($form));

                    $formacion->update([
                        'usuario_update_id' => auth()->user()->id,
                        'fecha_update'      => Carbon::now()->toDateTimeString()
                    ]);

                    $with = ['profesional', 'centroFormador', 'perfeccionamiento', 'perfeccionamiento.tipo', 'paos', 'situacionProfesional', 'campoClinico', 'userAdd', 'userUpdate'];

                    $formacion = $formacion->fresh($with);

                    if ($update) {
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

    public function removeFormacion($id)
    {
        try {
            $formacion = Especialidad::find($id);

            if ($formacion) {
                if ($formacion->escrituras != null && $formacion->escrituras()->count() > 0) {
                    return response()->json('passing_escrituras');
                } else if ($formacion->convenios != null && $formacion->convenios()->count() > 0) {
                    return response()->json('passing_convenios');
                } else if ($formacion->paos != null && $formacion->paos()->count() > 0) {
                    return response()->json('paos');
                } else {
                    $delete = $formacion->delete();
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

    public function getFormacionesProfesional(Request $request)
    {
        try {
            $profesional = Profesional::where('uuid', $request->uuid)->first();

            if ($profesional) {
                $with = ['profesional', 'centroFormador', 'perfeccionamiento', 'perfeccionamiento.tipo', 'paos', 'situacionProfesional', 'campoClinico', 'userAdd', 'userUpdate'];
                $formaciones = $profesional->especialidades()->with($with)->orderBy('id', 'asc')->get();

                return response()->json($formaciones);
            }
        } catch (\Exception $error) {
            return response()->json($error->getMessage());
        }
    }

    public function getFormacionesProfesionalDocument(Request $request)
    {
        try {
            $profesional = Profesional::where('uuid', $request->uuid)->first();
            if ($profesional) {
                $perfeccinamientos = Perfeccionamiento::where('tipo_perfeccionamiento_id', $request->tipo)->get();
                $especialidades_profesional = Especialidad::with('perfeccionamiento')->whereIn('perfeccionamiento_id', $perfeccinamientos->pluck('id'))->where('profesional_id', $profesional->id)->get();

                return response()->json($especialidades_profesional);
            }
        } catch (\Exception $error) {
            return response()->json($error->getMessage());
        }
    }

    public function getAniosEspecialidadProfesional(Request $request)
    {
        try {
            $especialidad = Especialidad::find($request->especialidad_id);

            $primera_fecha  = Carbon::parse($especialidad->inicio_formacion);
            $primer_ano     = $primera_fecha->year;

            $ultima_fecha  = Carbon::parse($especialidad->termino_formacion);
            $ultimo_ano    = $ultima_fecha->year;

            $anios = array();
            for ($i = $primer_ano; $i <= $ultimo_ano; $i++) {
                array_push($anios, $i);
            }
            return response()->json($anios);
        } catch (\Exception $error) {
            return response()->json($error->getMessage());
        }
    }
}
