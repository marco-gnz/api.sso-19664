<?php

namespace App\Http\Controllers\Documentos;

use App\Http\Controllers\Controller;
use App\Http\Requests\Documentos\Generico\StoreDocumentoGenericoRequest;
use App\Http\Requests\Documentos\Generico\UpdateDocumentoGenericoRequest;
use App\Models\DocumentoGenerico;
use App\Models\Profesional;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DocumentoGenericoController extends Controller
{

    public function getDocumentosGenericos(Request $request)
    {
        try {
            $profesional = Profesional::where('uuid', $request->uuid)->first();
            if ($profesional) {
                $documento_genericos = DocumentoGenerico::with('tipoDocumento', 'profesional', 'userAdd', 'userUpdate')->where('profesional_id', $profesional->id)->get();

                return response()->json($documento_genericos);
            }
        } catch (\Exception $error) {
            return response()->json($error->getMessage());
        }
    }

    public function storeDocumentoGenerico(StoreDocumentoGenericoRequest $request)
    {
        try {
            $profesional = Profesional::where('uuid', $request->profesional_uuid)->first();
            $form = ['n_documento', 'fecha_documento', 'observacion', 'tipo_documento_id'];

            if ($profesional) {
                $documento_generico = DocumentoGenerico::create($request->only($form));

                $update = $documento_generico->update([
                    'profesional_id' => $profesional->id,
                    'usuario_add_id' => auth()->user()->id,
                    'fecha_add'      => Carbon::now()->toDateTimeString()
                ]);

                $with                   = ['tipoDocumento', 'profesional', 'userAdd', 'userUpdate'];
                $documento_generico     = $documento_generico->fresh($with);

                if ($documento_generico && $update) {
                    return response()->json(array(true, $documento_generico));
                } else {
                    return response()->json(false);
                }
            }
        } catch (\Exception $error) {
            return response()->json($error->getMessage());
        }
    }

    public function updateDocumentoGenerico(UpdateDocumentoGenericoRequest $request, $id)
    {
        try {
            $documento_generico = DocumentoGenerico::find($id);

            if ($documento_generico) {
                $form = ['n_documento', 'fecha_documento', 'observacion', 'tipo_documento_id'];

                $update = $documento_generico->update($request->only($form));

                $documento_generico->update([
                    'usuario_update_id' => auth()->user()->id,
                    'fecha_update'      => Carbon::now()->toDateTimeString()
                ]);

                $with                   = ['tipoDocumento', 'profesional', 'userAdd', 'userUpdate'];
                $documento_generico     = $documento_generico->fresh($with);

                if ($documento_generico && $update) {
                    return response()->json(array(true, $documento_generico));
                } else {
                    return response()->json(false);
                }
            }
        } catch (\Exception $error) {
            return response()->json($error->getMessage());
        }
    }

    public function deleteDocumentoGenerico($uuid)
    {
        try {
            $documento_generico = DocumentoGenerico::where('uuid', $uuid)->first();

            if ($documento_generico) {
                $delete = $documento_generico->delete();

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
