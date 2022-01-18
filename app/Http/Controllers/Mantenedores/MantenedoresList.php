<?php

namespace App\Http\Controllers\Mantenedores;

use App\Http\Controllers\Controller;
use App\Http\Requests\Mantenedores\Causal\StoreCausalRequest;
use App\Http\Requests\Mantenedores\Causal\UpdateCausalRequest;
use App\Http\Requests\Mantenedores\Centro\StoreCentroFormador;
use App\Http\Requests\Mantenedores\Centro\UpdateCentroFormador;
use App\Http\Requests\Mantenedores\Establecimiento\StoreEstablecimientoRequest;
use App\Http\Requests\Mantenedores\Establecimiento\UpdateEstablecimientoRequest;
use App\Http\Requests\Mantenedores\Perfeccionamiento\StorePerfeccionamientoRequest;
use App\Http\Requests\Mantenedores\Perfeccionamiento\UpdatePerfeccionamientoRequest;
use App\Http\Requests\Mantenedores\Red\StoreRedRequest;
use App\Http\Requests\Mantenedores\Red\UpdateRedRequest;
use App\Http\Requests\Mantenedores\Situacion\StoreSituacionRequest;
use App\Http\Requests\Mantenedores\Situacion\UpdateSituacionRequest;
use App\Http\Requests\Mantenedores\Unidad\StoreUnidadRequest;
use App\Http\Requests\Mantenedores\Unidad\UpdateUnidadRequest;
use App\Models\CalidadJuridica;
use App\Models\Causal;
use App\Models\CentroFormador;
use App\Models\Establecimiento;
use App\Models\Etapa;
use App\Models\Genero;
use App\Models\GradoComplejidad;
use App\Models\Perfeccionamiento;
use App\Models\Planta;
use App\Models\RedHospitalaria;
use App\Models\SituacionActual;
use App\Models\SituacionFactura;
use App\Models\TipoContratos;
use App\Models\TipoDocumento;
use App\Models\TipoFactura;
use App\Models\TipoPerfeccionamiento;
use App\Models\Unidad;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MantenedoresList extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum']);
    }

    public function getSituacionesActual()
    {
        try {
            $calidades = SituacionActual::orderBy('nombre', 'asc')->get();
            return response()->json($calidades, 200);
        } catch (\Exception $error) {
            return response()->json($error->getMessage());
        }
    }

    public function getCalidades()
    {
        try {
            $calidades = CalidadJuridica::orderBy('nombre', 'asc')->get();
            return response()->json($calidades, 200);
        } catch (\Exception $error) {
            return response()->json($error->getMessage());
        }
    }

    public function getUnidades(Request $request)
    {
        try {
            $unidades = Unidad::orderBy('nombre', 'asc')->general($request->buscador)->paginate(15);

            return response()->json(
                array(
                    'pagination' => [
                        'total'         => $unidades->total(),
                        'current_page'  => $unidades->currentPage(),
                        'per_page'      => $unidades->perPage(),
                        'last_page'     => $unidades->lastPage(),
                        'from'          => $unidades->firstItem(),
                        'to'            => $unidades->lastPage()
                    ],
                    'unidades' => $unidades
                )
            );
        } catch (\Exception $error) {
            return response()->json($error->getMessage());
        }
    }

    public function getCausales()
    {
        try {
            $causales = Causal::orderBy('nombre', 'asc')->where('estado', true)->get();
            return response()->json($causales, 200);
        } catch (\Exception $error) {
            return response()->json($error->getMessage());
        }
    }

    public function getPlantas()
    {
        try {
            $plantas = Planta::orderBy('nombre', 'asc')->get();
            return response()->json($plantas, 200);
        } catch (\Exception $error) {
            return response()->json($error->getMessage());
        }
    }

    public function getGeneros()
    {
        try {
            $generos = Genero::orderBy('nombre', 'asc')->get();
            return response()->json($generos, 200);
        } catch (\Exception $error) {
            return response()->json($error->getMessage());
        }
    }

    public function getEtapas()
    {
        try {
            $etapas = Etapa::orderBy('nombre', 'asc')->get();
            return response()->json($etapas, 200);
        } catch (\Exception $error) {
            return response()->json($error->getMessage());
        }
    }

    public function getCentrosFormadores(Request $request)
    {
        try {
            $centros_formadores = CentroFormador::orderBy('nombre', 'asc')->general($request->buscador)->paginate(15);

            return response()->json(
                array(
                    'pagination' => [
                        'total'         => $centros_formadores->total(),
                        'current_page'  => $centros_formadores->currentPage(),
                        'per_page'      => $centros_formadores->perPage(),
                        'last_page'     => $centros_formadores->lastPage(),
                        'from'          => $centros_formadores->firstItem(),
                        'to'            => $centros_formadores->lastPage()
                    ],
                    'centros' => $centros_formadores
                )
            );
        } catch (\Exception $error) {
            return response()->json($error->getMessage());
        }
    }

    public function getTipoPerfeccionamientos()
    {
        try {
            $tipo_perfeccionamientos = TipoPerfeccionamiento::orderBy('nombre', 'asc')->get();
            return response()->json($tipo_perfeccionamientos, 200);
        } catch (\Exception $error) {
            return response()->json($error->getMessage());
        }
    }

    public function getPerfeccionamientos(Request $request)
    {
        try {
            $perfeccionamientos = Perfeccionamiento::where('tipo_perfeccionamiento_id', $request->tipo_perfeccionamiento_id)->with('tipo')->orderBy('nombre', 'asc')->get();

            return response()->json($perfeccionamientos, 200);
        } catch (\Exception $error) {
            return response()->json($error->getMessage());
        }
    }

    public function getRedesHospitalarias()
    {
        try {
            $redes_hospitalarias = RedHospitalaria::orderBy('nombre', 'asc')->get();
            return response()->json($redes_hospitalarias, 200);
        } catch (\Exception $error) {
            return response()->json($error->getMessage());
        }
    }

    public function getEstablecimientos(Request $request)
    {
        try {
            $establecimientos = Establecimiento::with('gradoComplejidad')->where('red_hospitalaria_id', $request->red_hospitalaria)->orderBy('nombre', 'asc')->get();

            return response()->json($establecimientos);
        } catch (\Exception $error) {
            return response()->json($error->getMessage());
        }
    }

    public function getEstablecimientosGradoComplejidad(Request $request)
    {
        try {
            $establecimientos = Establecimiento::with('gradoComplejidad')->where('red_hospitalaria_id', $request->red_hospitalaria)->whereNotNull('grado_complejidad_id')->orderBy('nombre', 'asc')->get();

            return response()->json($establecimientos);
        } catch (\Exception $error) {
            return response()->json($error->getMessage());
        }
    }

    public function getTipoContratos()
    {
        try {
            $tipo_contratos = TipoContratos::orderBy('nombre', 'asc')->get();
            return response()->json($tipo_contratos, 200);
        } catch (\Exception $error) {
            return response()->json($error->getMessage());
        }
    }

    public function situacionesFactura()
    {
        try {
            $situaciones_factura = SituacionFactura::orderBy('nombre', 'asc')->get();
            return response()->json($situaciones_factura, 200);
        } catch (\Exception $error) {
            return response()->json($error->getMessage());
        }
    }

    public function tiposFactura()
    {
        try {
            $tipos_factura = TipoFactura::orderBy('nombre', 'asc')->get();
            return response()->json($tipos_factura, 200);
        } catch (\Exception $error) {
            return response()->json($error->getMessage());
        }
    }

    public function redesHospitalariasUserAuth()
    {
        try {
            $redes_hospitalarias = RedHospitalaria::orderBy('nombre', 'asc')->get();
            return response()->json($redes_hospitalarias, 200);
        } catch (\Exception $error) {
            return response()->json($error->getMessage());
        }
    }

    public function tipoDocumentos()
    {
        try {
            $tipo_documentos = TipoDocumento::orderBy('nombre', 'asc')->get();
            return response()->json($tipo_documentos, 200);
        } catch (\Exception $error) {
            return response()->json($error->getMessage());
        }
    }

    public function perfeccionamientoAll(Request $request)
    {
        try {
            $input              = ($request->input != '') ? $request->input : '';

            $perfeccionamientos = Perfeccionamiento::with('tipo')
                ->tipoPerfeccionamiento($request->tipo)
                ->general($input)
                ->orderBy('nombre', 'asc')
                ->paginate(15);

            return response()->json(
                array(
                    'pagination' => [
                        'total'         => $perfeccionamientos->total(),
                        'current_page'  => $perfeccionamientos->currentPage(),
                        'per_page'      => $perfeccionamientos->perPage(),
                        'last_page'     => $perfeccionamientos->lastPage(),
                        'from'          => $perfeccionamientos->firstItem(),
                        'to'            => $perfeccionamientos->lastPage()
                    ],
                    'perfeccionamientos' => $perfeccionamientos
                )
            );
        } catch (\Exception $error) {
            return response()->json($error->getMessage());
        }
    }


    //admin
    public function adminEstablecimientos()
    {
        try {
            $establecimientos = Establecimiento::with('gradoComplejidad', 'redHospitalaria')->orderBy('nombre', 'asc')->get();

            return response()->json($establecimientos);
        } catch (\Exception $error) {
            return response()->json($error->getMessage());
        }
    }

    public function addRed(StoreRedRequest $request)
    {
        try {
            $red = RedHospitalaria::create($request->all());

            if ($red) {
                return response()->json(array(true, $red));
            } else {
                return response()->json(false);
            }
        } catch (\Exception $error) {
            return response()->json($error->getMessage());
        }
    }

    public function editRed(UpdateRedRequest $request, $id)
    {
        try {
            $red = RedHospitalaria::find($id);
            if ($red) {
                $update = $red->update($request->all());

                $red = $red->fresh();

                if ($update) {
                    return response()->json(array(true, $red));
                } else {
                    return response()->json(false);
                }
            }
        } catch (\Exception $error) {
            return response()->json($error->getMessage());
        }
    }

    public function addUnidad(StoreUnidadRequest $request)
    {
        try {
            $unidad = Unidad::create($request->all());

            if ($unidad) {
                return response()->json(array(true, $unidad));
            } else {
                return response()->json(false);
            }
        } catch (\Exception $error) {
            return response()->json($error->getMessage());
        }
    }

    public function editUnidad(UpdateUnidadRequest $request, $id)
    {
        try {
            $unidad = Unidad::find($id);
            if ($unidad) {
                $update = $unidad->update($request->all());

                $unidad = $unidad->fresh();

                if ($update) {
                    return response()->json(array(true, $unidad));
                } else {
                    return response()->json(false);
                }
            }
        } catch (\Exception $error) {
            return response()->json($error->getMessage());
        }
    }

    public function addCentro(StoreCentroFormador $request)
    {
        try {
            $centro = CentroFormador::create($request->all());

            if ($centro) {
                return response()->json(array(true, $centro));
            } else {
                return response()->json(false);
            }
        } catch (\Exception $error) {
            return response()->json($error->getMessage());
        }
    }

    public function editCentro(UpdateCentroFormador $request, $id)
    {
        try {
            $centro = CentroFormador::find($id);
            if ($centro) {
                $update = $centro->update($request->all());

                $centro = $centro->fresh();

                if ($update) {
                    return response()->json(array(true, $centro));
                } else {
                    return response()->json(false);
                }
            }
        } catch (\Exception $error) {
            return response()->json($error->getMessage());
        }
    }

    public function addPerfeccionamiento(StorePerfeccionamientoRequest $request)
    {
        try {
            $perfeccionamiento = Perfeccionamiento::create($request->all());

            $update = $perfeccionamiento->update([
                'usuario_add_id' => auth()->user()->id
            ]);

            $with = ['tipo'];
            $perfeccionamiento = $perfeccionamiento->fresh($with);

            if ($perfeccionamiento && $update) {
                return response()->json(array(true, $perfeccionamiento));
            } else {
                return response()->json(false);
            }
        } catch (\Exception $error) {
            return response()->json($error->getMessage());
        }
    }

    public function editPerfeccionamiento(UpdatePerfeccionamientoRequest $request, $id)
    {
        try {
            $perfeccionamiento = Perfeccionamiento::find($id);
            if ($perfeccionamiento) {
                $update = $perfeccionamiento->update($request->all());

                $with   = ['tipo'];
                $perfeccionamiento = $perfeccionamiento->fresh($with);

                if ($update) {
                    return response()->json(array(true, $perfeccionamiento));
                } else {
                    return response()->json(false);
                }
            }
        } catch (\Exception $error) {
            return response()->json($error->getMessage());
        }
    }

    public function getCausalesAdmin(Request $request)
    {
        try {
            $causales = Causal::orderBy('nombre', 'asc')->general($request->buscador)->paginate(15);

            return response()->json(
                array(
                    'pagination' => [
                        'total'         => $causales->total(),
                        'current_page'  => $causales->currentPage(),
                        'per_page'      => $causales->perPage(),
                        'last_page'     => $causales->lastPage(),
                        'from'          => $causales->firstItem(),
                        'to'            => $causales->lastPage()
                    ],
                    'causales' => $causales
                )
            );
        } catch (\Exception $error) {
            return response()->json($error->getMessage());
        }
    }

    public function addCausal(StoreCausalRequest $request)
    {
        try {
            $causal = Causal::create($request->all());

            $update = $causal->update([
                'usuario_add_id' => auth()->user()->id,
                'fecha_add'      => Carbon::now()
            ]);


            $causal = $causal->fresh();

            if ($causal && $update) {
                return response()->json(array(true, $causal));
            } else {
                return response()->json(false);
            }
        } catch (\Exception $error) {
            return response()->json($error->getMessage());
        }
    }

    public function statusCausal($id)
    {
        try {
            $causal = Causal::find($id);

            if ($causal) {
                $update = $causal->update([
                    'estado' => !$causal->estado
                ]);

                $causal = $causal->fresh();

                if ($update) {
                    return response()->json(array(true, $causal));
                } else {
                    return response()->json(false);
                }
            }
        } catch (\Exception $error) {
            return response()->json($error->getMessage());
        }
    }

    public function editCausal(UpdateCausalRequest $request, $id)
    {
        try {
            $causal = Causal::find($id);
            if ($causal) {
                $update = $causal->update($request->all());

                $causal = $causal->fresh();

                if ($update) {
                    return response()->json(array(true, $causal));
                } else {
                    return response()->json(false);
                }
            }
        } catch (\Exception $error) {
            return response()->json($error->getMessage());
        }
    }

    public function getGradoComplejidad()
    {
        try {
            $grado_complejidad = GradoComplejidad::orderBy('grado', 'asc')->get();
            return response()->json($grado_complejidad, 200);
        } catch (\Exception $error) {
            return response()->json($error->getMessage());
        }
    }

    public function addEstablecimiento(StoreEstablecimientoRequest $request)
    {
        try {
            $establecimiento = Establecimiento::create($request->all());

            $with = ['redHospitalaria', 'gradoComplejidad'];

            $establecimiento = $establecimiento->fresh($with);

            if ($establecimiento) {
                return response()->json(array(true, $establecimiento));
            } else {
                return response()->json(false);
            }
        } catch (\Exception $error) {
            return response()->json($error->getMessage());
        }
    }

    public function editEstablecimiento(UpdateEstablecimientoRequest $request, $id)
    {
        try {
            $establecimiento = Establecimiento::find($id);
            if ($establecimiento) {
                $update = $establecimiento->update($request->all());

                $with = ['redHospitalaria', 'gradoComplejidad'];

                $establecimiento = $establecimiento->fresh($with);

                if ($update) {
                    return response()->json(array(true, $establecimiento));
                } else {
                    return response()->json(false);
                }
            }
        } catch (\Exception $error) {
            return response()->json($error->getMessage());
        }
    }

    public function addSituacion(StoreSituacionRequest $request)
    {
        try {
            $situacion = SituacionActual::create($request->all());

            $update = $situacion->update([
                'usuario_add_id' => auth()->user()->id,
                'fecha_add'      => Carbon::now()
            ]);


            $situacion = $situacion->fresh();

            if ($situacion && $update) {
                return response()->json(array(true, $situacion));
            } else {
                return response()->json(false);
            }
        } catch (\Exception $error) {
            return response()->json($error->getMessage());
        }
    }

    public function statusSituacion($id)
    {
        try {
            $situacion = SituacionActual::find($id);

            if ($situacion) {
                $update = $situacion->update([
                    'estado' => !$situacion->estado
                ]);

                $situacion = $situacion->fresh();

                if ($update) {
                    return response()->json(array(true, $situacion));
                } else {
                    return response()->json(false);
                }
            }
        } catch (\Exception $error) {
            return response()->json($error->getMessage());
        }
    }

    public function editSituacion(UpdateSituacionRequest $request, $id)
    {
        try {
            $situacion = SituacionActual::find($id);
            if ($situacion) {
                $update = $situacion->update($request->all());

                $otros = $situacion->update([
                    'usuario_update_id' => auth()->user()->id,
                    'fecha_update'      => Carbon::now()
                ]);

                $situacion = $situacion->fresh();

                if ($update && $otros) {
                    return response()->json(array(true, $situacion));
                } else {
                    return response()->json(false);
                }
            }
        } catch (\Exception $error) {
            return response()->json($error->getMessage());
        }
    }
}
