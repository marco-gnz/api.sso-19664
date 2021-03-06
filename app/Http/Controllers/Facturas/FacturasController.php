<?php

namespace App\Http\Controllers\Facturas;

use App\Http\Controllers\Controller;
use App\Http\Requests\Factura\StoreFacturaRequest;
use App\Http\Requests\Factura\UpdateFacturaRequest;
use App\Http\Requests\Factura\UpdateHallFacturaRequest;
use App\Models\Convenio;
use App\Models\Factura;
use App\Models\Profesional;
use Illuminate\Http\Request;
use Carbon\Carbon;

class FacturasController extends Controller
{

    public function getFacturas(Request $request)
    {
        try {
            $profesional = Profesional::where('uuid', $request->uuid)->first();

            $facturas = $profesional->facturas()->with('profesional', 'tipos', 'tipoContratoProfesional', 'situacionActual', 'convenio', 'centroFormador', 'redHospitalaria', 'perfeccionamiento.tipo', 'userAdd', 'userUpdate')->get();

            return response()->json($facturas);
        } catch (\Exception $error) {
            return response()->json($error->getMessage());
        }
    }

    public function storeFactura(StoreFacturaRequest $request)
    {
        try {
            $perfeccionamiento_id = NULL;
            $form           = ['n_resolucion', 'fecha_resolucion', 'n_resolucion_convenio', 'centro_formador_id', 'fecha_convenio', 'envio_finanza', 'fecha_pago', 'anio_academico', 'n_factura', 'fecha_emision_factura', 'fecha_vencimiento_factura', 'cargo_item', 'anios_pago', 'monto_total', 'tipo_contrado_id', 'situacion_factura_id', 'tipo_factura', 'convenio_id', 'red_hospitalaria_id', 'observacion'];

            $profesional = Profesional::where('uuid', $request->profesional_uuid)->first();
            if ($profesional) {
                $convenio = Convenio::find($request->convenio_id);

                if ($convenio) {
                    $perfeccionamiento_id = $convenio->especialidad != null ? $convenio->especialidad->perfeccionamiento->id : NULL;
                }

                $factura    = Factura::create($request->all());

                $update = $factura->update([
                    'profesional_id'            => $profesional->id,
                    'perfeccionamiento_id'      => $perfeccionamiento_id,
                    'ip_user_add'               => $request->ip(),
                    'usuario_add_id'            => auth()->user()->id,
                    'fecha_add'                 => Carbon::now()->toDateTimeString()
                ]);

                if ($request->tipo_factura) {
                    $factura->tipos()->attach($request->tipo_factura);
                }

                $with          = ['profesional', 'tipos', 'tipoContratoProfesional', 'situacionActual', 'convenio', 'centroFormador', 'redHospitalaria', 'perfeccionamiento.tipo', 'userAdd', 'userUpdate'];
                $factura       = $factura->fresh($with);

                if ($factura && $update) {
                    return response()->json(array(true, $factura));
                } else {
                    return response()->json(false);
                }
            } else {
                return response()->json('no-profesional');
            }
        } catch (\Exception $error) {
            return response()->json($error->getMessage());
        }
    }

    public function editFactura(UpdateHallFacturaRequest $request, $uuid)
    {
        try {
            $perfeccionamiento_id = NULL;
            $form    = ['n_resolucion', 'fecha_resolucion', 'n_resolucion_convenio', 'fecha_convenio', 'centro_formador_id', 'envio_finanza', 'fecha_pago', 'anio_academico', 'n_factura', 'fecha_emision_factura', 'fecha_vencimiento_factura', 'cargo_item', 'anios_pago', 'monto_total', 'tipo_contrado_id', 'situacion_factura_id', 'tipo_factura', 'convenio_id', 'red_hospitalaria_id', 'observacion'];
            $factura = Factura::where('uuid', $uuid)->first();

            if ($factura) {
                $convenio = Convenio::find($request->convenio_id);

                if ($convenio) {
                    $perfeccionamiento_id = $convenio->especialidad != null ? $convenio->especialidad->perfeccionamiento->id : NULL;
                }

                $update = $factura->update($request->only($form));

                $factura->update([
                    'perfeccionamiento_id'         => $perfeccionamiento_id,
                    'ip_user_update'               => $request->ip(),
                    'usuario_update_id'            => auth()->user()->id,
                    'fecha_update'                 => Carbon::now()->toDateTimeString()
                ]);

                if ($request->tipo_factura) {
                    $factura->tipos()->sync($request->tipo_factura);
                }

                $with          = ['profesional', 'tipos', 'tipoContratoProfesional', 'situacionActual', 'convenio', 'centroFormador', 'redHospitalaria', 'perfeccionamiento.tipo', 'userAdd', 'userUpdate'];
                $factura       = $factura->fresh($with);

                if ($factura && $update) {
                    return response()->json(array(true, $factura));
                } else {
                    return response()->json(false);
                }
            } else {
                return response()->json('no-factura');
            }
        } catch (\Exception $error) {
            return response()->json($error->getMessage());
        }
    }

    public function editSituacion(UpdateFacturaRequest $request, $uuid)
    {
        try {
            $factura = Factura::where('uuid', $uuid)->first();
            $form = ['situacion_factura_id'];
            if ($factura) {
                $update = $factura->update($request->only($form));

                $factura->update([
                    'ip_user_update'               => $request->ip(),
                    'usuario_update_id'            => auth()->user()->id,
                    'fecha_update'                 => Carbon::now()->toDateTimeString()
                ]);

                $with          = ['profesional', 'tipos', 'tipoContratoProfesional', 'situacionActual', 'convenio', 'centroFormador', 'redHospitalaria', 'perfeccionamiento.tipo', 'userAdd', 'userUpdate'];
                $factura       = $factura->fresh($with);

                if ($factura && $update) {
                    return response()->json(array(true, $factura));
                } else {
                    return response()->json(false);
                }
            }
        } catch (\Exception $error) {
            return response()->json($error->getMessage());
        }
    }

    public function deleteFactura($uuid)
    {
        try {
            $factura = Factura::where('uuid', $uuid)->first();

            if ($factura) {
                $factura->tipos()->detach();
                $delete = $factura->delete();
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
