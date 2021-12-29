<?php

namespace App\Http\Controllers\Facturas;

use App\Http\Controllers\Controller;
use App\Http\Requests\Factura\StoreFacturaRequest;
use App\Http\Requests\Factura\UpdateFacturaRequest;
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

            $facturas = $profesional->facturas()->with('profesional', 'tipoContratoProfesional', 'situacionActual', 'convenio', 'centroFormador', 'redHospitalaria', 'perfeccionamiento.tipo', 'userAdd', 'userUpdate')->get();

            return response()->json($facturas);
        } catch (\Exception $error) {
            return response()->json($error->getMessage());
        }
    }

    public function storeFactura(StoreFacturaRequest $request)
    {
        try {
            /* return json_encode($request->ip()); */
            $form           = ['n_resolucion', 'fecha_resolucion', 'n_factura', 'fecha_emision_factura', 'fecha_vencimiento_factura', 'cargo_item', 'anios_pago', 'monto_total', 'tipo_contrado_id', 'situacion_factura_id', 'convenio_id', 'red_hospitalaria_id', 'observacion'];
            $convenio       = Convenio::find($request->convenio_id);

            if ($convenio) {
                $factura    = Factura::create($request->all());

                $update = $factura->update([
                    'profesional_id'            => $convenio->especialidad->profesional->id,
                    'centro_formador_id'        => $convenio->especialidad->centroFormador->id,
                    'perfeccionamiento_id'      => $convenio->especialidad->perfeccionamiento->id,
                    'ip_user_add'               => $request->ip(),
                    'profesional_id'            => $convenio->especialidad->profesional->id,
                    'usuario_add_id'            => auth()->user()->id,
                    'fecha_add'                 => Carbon::now()->toDateTimeString()
                ]);

                $with          = ['profesional', 'tipoContratoProfesional', 'situacionActual', 'convenio', 'centroFormador', 'redHospitalaria', 'perfeccionamiento.tipo', 'userAdd', 'userUpdate'];
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

                $with          = ['profesional', 'tipoContratoProfesional', 'situacionActual', 'convenio', 'centroFormador', 'redHospitalaria', 'perfeccionamiento.tipo', 'userAdd', 'userUpdate'];
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
