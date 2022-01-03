<?php

namespace App\Http\Controllers\Mantenedores;

use App\Http\Controllers\Controller;
use App\Models\CalidadJuridica;
use App\Models\Causal;
use App\Models\CentroFormador;
use App\Models\Establecimiento;
use App\Models\Etapa;
use App\Models\Genero;
use App\Models\Perfeccionamiento;
use App\Models\Planta;
use App\Models\RedHospitalaria;
use App\Models\SituacionFactura;
use App\Models\TipoContratos;
use App\Models\TipoDocumento;
use App\Models\TipoFactura;
use App\Models\TipoPerfeccionamiento;
use App\Models\Unidad;
use Illuminate\Http\Request;

class MantenedoresList extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum']);
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

    public function getUnidades()
    {
        try {
            $unidades = Unidad::orderBy('nombre', 'asc')->get();
            return response()->json($unidades, 200);
        } catch (\Exception $error) {
            return response()->json($error->getMessage());
        }
    }

    public function getCausales()
    {
        try {
            $causales = Causal::orderBy('nombre', 'asc')->get();
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

    public function getCentrosFormadores()
    {
        try {
            $centros_formadores = CentroFormador::orderBy('nombre', 'asc')->get();
            return response()->json($centros_formadores, 200);
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
            $perfeccionamientos = Perfeccionamiento::where('tipo_perfeccionamiento_id', $request->tipo_perfeccionamiento_id)->orderBy('nombre', 'asc')->get();

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

    public function perfeccionamientoAll()
    {
        try {
            $perfeccionamientos = Perfeccionamiento::with('tipo')->orderBy('nombre', 'asc')->get();
            return response()->json($perfeccionamientos, 200);
        } catch (\Exception $error) {
            return response()->json($error->getMessage());
        }
    }
}
