<?php

namespace App\Http\Controllers\Profesional;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profesional\StoreProfesionalRequest;
use App\Http\Requests\Profesional\UpdateProfesionalRequest;
use App\Http\Resources\ProfesionalesResource;
use App\Models\Profesional;
use App\Models\ProfesionalEstablecimiento;
use App\Models\TipoContratos;
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

    public function cartolaPdf($uuid, $horas)
    {
        try {
            $profesional = Profesional::where('uuid', $uuid)->first();
            $horas       = TipoContratos::where('nombre', $horas)->firstOrFail();

            $timeLine = $profesional->especialidades->flatMap(function ($especialidad) {
                return $especialidad->paos->flatMap(function ($pao) {
                    // Procesar devoluciones
                    $devoluciones = collect($pao->devoluciones ?? [])
                        ->map(function ($devolucion) {
                            return [
                                'color'             => 'rgb(13, 105, 179, 0.2)',
                                'dev_inte_value'    => "D",
                                'dev_inte'          => 'Devolución',
                                'tipo'              => $devolucion->pao->especialidad->perfeccionamiento->tipo->nombre,
                                'perfeccionamiento' => $devolucion->pao->especialidad->perfeccionamiento->nombre,
                                'fecha_inicio_not_format'      => $devolucion->inicio_devolucion,
                                'fecha_inicio'      => Carbon::parse($devolucion->inicio_devolucion)->format('d/m/Y'),
                                'fecha_termino'     => Carbon::parse($devolucion->termino_devolucion)->format('d/m/Y'),
                                'hor_mot'           => $devolucion->tipoContrato->horas,
                                'total'             => $devolucion->totalDevuelto()
                            ];
                        });

                    // Procesar interrupciones
                    $interrupciones = collect($pao->interrupciones ?? [])
                        ->map(function ($interrupcion) {
                            return [
                                'color'             => 'rgb(238, 58, 68, 0.2)',
                                'dev_inte_value'    => "I",
                                'dev_inte'          => 'Interrupción',
                                'tipo'              => $interrupcion->pao->especialidad->perfeccionamiento->tipo->nombre,
                                'perfeccionamiento' => $interrupcion->pao->especialidad->perfeccionamiento->nombre,
                                'fecha_inicio_not_format'      => $interrupcion->inicio_interrupcion,
                                'fecha_inicio'      => Carbon::parse($interrupcion->inicio_interrupcion)->format('d/m/Y'),
                                'fecha_termino'     => Carbon::parse($interrupcion->termino_interrupcion)->format('d/m/Y'),
                                'hor_mot'           => $interrupcion->causal->nombre,
                                'total'             => $interrupcion->totalInterrupciones()
                            ];
                        });

                    // Combinar ambos arrays
                    return $devoluciones->merge($interrupciones);
                });
            })->sortBy('fecha_inicio_not_format')
                ->values()
                ->all();

            $pdf = \PDF::loadView(
                'pdf.profesional.cartola',
                [
                    'profesional' => $profesional,
                    'timeLine'      => $timeLine,
                    'horas'         => $horas->horas
                ]
            );
            $pdf->setPaper('a4', 'landscape');
            $pdf->output();
            $domPdf = $pdf->getDomPDF();

            $canvas = $domPdf->get_canvas();
            $canvas->page_text(500, 800, "Pagina {PAGE_NUM} de {PAGE_COUNT}", null, 8, [0, 0, 0]);

            return $pdf->stream("S19 - PRUEBA_CARTOLA_MEDICO.pdf");
        } catch (\Exception $error) {
            return response()->json($error->getMessage());
        }
    }

    public function getProfesional(Request $request, $uuid)
    {
        try {
            $paos_count = 0;
            $with = ['especialidades', 'destinaciones', 'etapa', 'establecimiento', 'establecimientos', 'comunas'];
            $profesional = Profesional::with($with)->withCount('destinaciones', 'especialidades', 'establecimientos', 'comunas')->where('uuid', $uuid)->first();

            foreach ($profesional->especialidades as $especialidad) {
                if ($especialidad->paos) {
                    $paos_count += $especialidad->paos->count();
                }
            }

            $profesional['paos_count'] = $paos_count;

            if ($profesional) {
                return response()->json($profesional);
            } else {
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

        $situaciones        = ($request->situaciones != '') ? $request->situaciones : [];

        $todas              = ($request->exist_perfeccionamiento === 'true') ? true : false;

        $establecimientos_profesional   = ($request->establecimientos != '') ? $request->establecimientos : [];
        $comunas_profesional            = ($request->comunas != '') ? $request->comunas : [];

        $profesionales = Profesional::general($input)
            ->etapaProfesional($etapas)
            ->perfeccionamiento($perfecion)
            ->tieneEspecialidades($todas)
            ->paos($inicio_f_pao, $termino_f_pao)
            ->destinacion($inicio_f_ed, $termino_f_ed)
            ->formacion($inicio_f_ef, $termino_f_ef)
            ->estado($estados)
            ->situacionProfesional($situaciones)
            ->establecimi($establecimiento)
            ->establecimientoProfesional($establecimientos_profesional)
            ->comunaProfesional($comunas_profesional)
            ->with('etapa', 'calidad', 'situacionActual', 'establecimientos', 'comunas')
            ->orderBy('apellidos', 'asc')
            ->paginate(50);

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
                'profesionales' => ProfesionalesResource::collection($profesionales)
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

            if ($request->establecimientos) {
                $profesional->establecimientos()->attach($request->establecimientos);
            }

            if ($request->comunas) {
                $profesional->comunas()->attach($request->comunas);
            }

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
            $paos_count = 0;

            $with = ['especialidades', 'destinaciones', 'etapa', 'establecimiento', 'establecimientos', 'comunas'];
            $profesional = Profesional::with($with)->withCount('destinaciones', 'especialidades', 'establecimientos', 'comunas')->find($id);

            $update = $profesional->update($request->all());



            $profesional->establecimientos()->sync($request->establecimientos);
            $profesional->comunas()->sync($request->comunas);

            foreach ($profesional->especialidades as $especialidad) {
                if ($especialidad->paos) {
                    $paos_count += $especialidad->paos->count();
                }
            }
            $profesional['paos_count'] = $paos_count;

            $profesional = $profesional->fresh($with);

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
                    'estado' => !$profesional->estado
                ]);
                $with = ['etapa', 'calidad', 'situacionActual', 'establecimientos', 'comunas'];

                $profesional = $profesional->fresh($with);

                if ($update) {
                    return response()->json(array(true, ProfesionalesResource::make($profesional)));
                } else {
                    return response()->json(false);
                }
            }
        } catch (\Exception $error) {
            return response()->json($error->getMessage());
        }
    }
}
