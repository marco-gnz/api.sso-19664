<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Resources\UserResource;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/user', function (Request $request) {
    /* return request()->user(); */
    /* return User::with(['roles.permissions', 'permissions'])->find(request()->user()->id); */
    return response()->json(UserResource::make(User::with(['roles.permissions', 'permissions', 'redesHospitalarias'])->find(request()->user()->id)));

});

/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
}); */

Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::post('/logout', [App\Http\Controllers\Auth\LogoutController::class, 'logout']);
Route::patch('/changepassword', [App\Http\Controllers\Auth\ChangePasswordController::class, 'changePasswordAuth']);

Route::get('/perfiles', [App\Http\Controllers\Perfiles\PerfilesController::class, 'getPerfiles']);
Route::get('/perfil/get-permisos', [App\Http\Controllers\Perfiles\PerfilesController::class, 'getPermisosToPerfil']);
Route::get('/perfil/get-permisos-extras', [App\Http\Controllers\Perfiles\PerfilesController::class, 'getPermisosExtras']);

Route::get('/usuarios', [App\Http\Controllers\Usuarios\UsuariosController::class, 'getUsuarios']);
Route::get('/usuarios/usuario/exist', [App\Http\Controllers\Usuarios\UsuariosController::class, 'existUsuario']);
Route::post('/usuarios/usuario/add-usuario', [App\Http\Controllers\Usuarios\UsuariosController::class, 'storeUsuario']);
Route::put('/usuarios/change-status/{uuid}', [App\Http\Controllers\Usuarios\UsuariosController::class, 'changeStatus']);
Route::put('/usuarios/restablecer-contrasena/{uuid}', [App\Http\Controllers\Usuarios\UsuariosController::class, 'restablecerContrasena']);
Route::get('/usuarios/usuario/{uuid}', [App\Http\Controllers\Usuarios\UsuariosController::class, 'getUsuario']);
Route::put('/usuarios/usuario/edit-usuario/{id}', [App\Http\Controllers\Usuarios\UsuariosController::class, 'updateUsuario']);

    //profesional
    Route::get('/profesionales/profesional/exist', [App\Http\Controllers\Profesional\ProfesionalController::class, 'existProfesional']);
    Route::put('/profesionales/profesional/change-status/{uuid}', [App\Http\Controllers\Profesional\ProfesionalController::class, 'changeStatus']);
    Route::get('/profesionales/profesional/get-profesionales', [App\Http\Controllers\Profesional\ProfesionalController::class, 'getProfesionales']);
    Route::post('/profesionales/profesional/add-profesional', [App\Http\Controllers\Profesional\ProfesionalController::class, 'addProfesional']);
    Route::get('/profesionales/profesional/get-profesional/{uuid}', [App\Http\Controllers\Profesional\ProfesionalController::class, 'getProfesional']);
    Route::put('/profesionales/profesional/update-datos-personales/{id}', [App\Http\Controllers\Profesional\ProfesionalController::class, 'updateDatosPersonales']);

    //excel-report
    Route::get('/profesionales/excel-search', [App\Http\Controllers\Exports\ExportExcelController::class, 'getProfesionales']);
    Route::get('/profesionales/excel-report/{ids}/{etapa}', [App\Http\Controllers\Exports\ExportExcelController::class, 'export']);

    //especialidades
    Route::post('/profesionales/profesional/add-formacion', [App\Http\Controllers\Formacion\FormacionController::class, 'storeFormacion']);
    Route::get('/profesionales/profesional/get-formaciones', [App\Http\Controllers\Formacion\FormacionController::class, 'getFormaciones']);
    Route::delete('/profesionales/profesional/remove-formacion/{id}', [App\Http\Controllers\Formacion\FormacionController::class, 'removeFormacion']);
    Route::get('/profesionales/profesional/get-formaciones', [App\Http\Controllers\Formacion\FormacionController::class, 'getFormacionesProfesional']);
    Route::get('/profesionales/profesional/get-formaciones-doc', [App\Http\Controllers\Formacion\FormacionController::class, 'getFormacionesProfesionalDocument']);
    Route::get('/profesionales/profesional/get-formaciones-doc/anios', [App\Http\Controllers\Formacion\FormacionController::class, 'getAniosEspecialidadProfesional']);


    //profesional-calculo-pao
    Route::post('/profesionales/profesional/add-calculo-pao', [App\Http\Controllers\Pao\CalculoPaoController::class, 'storeCalculoPao']);
    Route::put('/profesionales/profesional/update-status/{uuid}', [App\Http\Controllers\Pao\CalculoPaoController::class, 'updateStatus']);
    Route::delete('/profesionales/profesional/delete-calculo-pao/{uuid}', [App\Http\Controllers\Pao\CalculoPaoController::class, 'deletePao']);
    Route::get('/profesionales/profesional/historial', [App\Http\Controllers\Pao\CalculoPaoController::class, 'getHistorial']);
    Route::get('/profesionales/profesional/get-paos', [App\Http\Controllers\Pao\CalculoPaoController::class, 'getPaos']);
    Route::post('/profesionales/profesional/pao/add-devolucion', [App\Http\Controllers\Pao\Devolucion\DevolucionesController::class, 'storeDevolucion']);
    Route::put('/profesionales/profesional/pao/edit-devolucion/{uuid}', [App\Http\Controllers\Pao\Devolucion\DevolucionesController::class, 'updateDevolucion']);
    Route::delete('/profesionales/profesional/pao/remove-devlucion/{uuid}', [App\Http\Controllers\Pao\Devolucion\DevolucionesController::class, 'removeDevolucion']);
    Route::post('/profesionales/profesional/pao/add-interrupcion', [App\Http\Controllers\Pao\Interrupciones\InterrupcionesController::class, 'storeInterrupcion']);
    Route::put('/profesionales/profesional/pao/edit-interrupcion/{uuid}', [App\Http\Controllers\Pao\Interrupciones\InterrupcionesController::class, 'updateInterrupcion']);
    Route::delete('/profesionales/profesional/pao/remove-interrupcion/{uuid}', [App\Http\Controllers\Pao\Interrupciones\InterrupcionesController::class, 'removeInterrupcion']);
    Route::get('/profesionales/profesional/add-devolucion/get-escrituras', [App\Http\Controllers\Pao\CalculoPaoController::class, 'getEscrituras']);

    //profesional-edf
    Route::get('/profesionales/profesional/edf/get-destinaciones', [App\Http\Controllers\Edf\EtapaDestinacionController::class, 'getDestinaciones']);
    Route::post('/profesionales/profesional/edf/add-destinacion', [App\Http\Controllers\Edf\EtapaDestinacionController::class, 'storeDestinacion']);
    Route::delete('/profesionales/profesional/edf/delete-destinacion/{uuid}', [App\Http\Controllers\Edf\EtapaDestinacionController::class, 'deleteDestinacion']);

    Route::get('/profesionales/profesional/edf/get-formaciones', [App\Http\Controllers\Edf\EtapaFormacionController::class, 'getFormaciones']);
    Route::post('/profesionales/profesional/edf/add-formacion', [App\Http\Controllers\Edf\EtapaFormacionController::class, 'storeFormacion']);
    Route::delete('/profesionales/profesional/edf/delete-formacion/{uuid}', [App\Http\Controllers\Edf\EtapaFormacionController::class, 'deleteFormacion']);

    //convenios
    Route::get('/profesionales/profesional/documentos/get-convenios', [App\Http\Controllers\Documentos\ConveniosController::class, 'getConvenios']);
    Route::post('/profesionales/profesional/documentos/add-convenio', [App\Http\Controllers\Documentos\ConveniosController::class, 'storeConvenio']);
    Route::delete('/profesionales/profesional/documentos/delete-convenio/{uuid}', [App\Http\Controllers\Documentos\ConveniosController::class, 'deleteConvenio']);
    Route::put('/profesionales/profesional/documentos/update-convenio/{id}', [App\Http\Controllers\Documentos\ConveniosController::class, 'updateConvenio']);

    //escrituras
    Route::get('/profesionales/profesional/documentos/get-escrituras', [App\Http\Controllers\Documentos\EscriturasController::class, 'getEscrituras']);
    Route::post('/profesionales/profesional/documentos/add-escritura', [App\Http\Controllers\Documentos\EscriturasController::class, 'storeEscritura']);
    Route::put('/profesionales/profesional/documentos/update-escritura/{id}', [App\Http\Controllers\Documentos\EscriturasController::class, 'updateEscritura']);
    Route::delete('/profesionales/profesional/documentos/delete-escritura/{uuid}', [App\Http\Controllers\Documentos\EscriturasController::class, 'deleteEscritura']);

    //facturas
    Route::get('/profesionales/profesional/documentos/factura/get-facturas', [App\Http\Controllers\Facturas\FacturasController::class, 'getFacturas']);
    Route::post('/profesionales/profesional/documentos/factura/add-factura', [App\Http\Controllers\Facturas\FacturasController::class, 'storeFactura']);
    Route::delete('/profesionales/profesional/documentos/factura/delete-factura/{uuid}', [App\Http\Controllers\Facturas\FacturasController::class, 'deleteFactura']);
    Route::put('/profesionales/profesional/documentos/factura/edit-factura/{uuid}', [App\Http\Controllers\Facturas\FacturasController::class, 'editSituacion']);

    //genericos
    Route::get('/profesionales/profesional/documentos/generico/get-docs-generico', [App\Http\Controllers\Documentos\DocumentoGenericoController::class, 'getDocumentosGenericos']);
    Route::post('/profesionales/profesional/documentos/generico/add-doc-generico', [App\Http\Controllers\Documentos\DocumentoGenericoController::class, 'storeDocumentoGenerico']);
    Route::put('/profesionales/profesional/documentos/generico/edit-doc-generico/{id}', [App\Http\Controllers\Documentos\DocumentoGenericoController::class, 'updateDocumentoGenerico']);
    Route::delete('/profesionales/profesional/documentos/generico/delete-doc-generico/{uuid}', [App\Http\Controllers\Documentos\DocumentoGenericoController::class, 'deleteDocumentoGenerico']);

    //mantenedores-list
    Route::get('/mantenedores/plantas', [App\Http\Controllers\Mantenedores\MantenedoresList::class, 'getPlantas']);
    Route::get('/mantenedores/unidades', [App\Http\Controllers\Mantenedores\MantenedoresList::class, 'getUnidades']);
    Route::get('/mantenedores/calidades', [App\Http\Controllers\Mantenedores\MantenedoresList::class, 'getCalidades']);
    Route::get('/mantenedores/causales', [App\Http\Controllers\Mantenedores\MantenedoresList::class, 'getCausales']);
    Route::get('/mantenedores/generos', [App\Http\Controllers\Mantenedores\MantenedoresList::class, 'getGeneros']);
    Route::get('/mantenedores/etapas', [App\Http\Controllers\Mantenedores\MantenedoresList::class, 'getEtapas']);
    Route::get('/mantenedores/centros-formadores', [App\Http\Controllers\Mantenedores\MantenedoresList::class, 'getCentrosFormadores']);
    Route::get('/mantenedores/tipo-perfeccionamientos', [App\Http\Controllers\Mantenedores\MantenedoresList::class, 'getTipoPerfeccionamientos']);
    Route::get('/mantenedores/tipo-perfeccionamientos/perfeccionamientos', [App\Http\Controllers\Mantenedores\MantenedoresList::class, 'getPerfeccionamientos']);
    Route::get('/mantenedores/redes-hospitalarias', [App\Http\Controllers\Mantenedores\MantenedoresList::class, 'getRedesHospitalarias']);
    Route::get('/mantenedores/redes-hospitalarias/establecimientos', [App\Http\Controllers\Mantenedores\MantenedoresList::class, 'getEstablecimientos']);
    Route::get('/mantenedores/redes-hospitalarias/establecimientos-grado-complejidad', [App\Http\Controllers\Mantenedores\MantenedoresList::class, 'getEstablecimientosGradoComplejidad']);
    Route::get('/mantenedores/tipo-contratos', [App\Http\Controllers\Mantenedores\MantenedoresList::class, 'getTipoContratos']);
    Route::get('/mantenedores/situaciones-factura', [App\Http\Controllers\Mantenedores\MantenedoresList::class, 'situacionesFactura']);
    Route::get('/mantenedores/tipos-factura', [App\Http\Controllers\Mantenedores\MantenedoresList::class, 'tiposFactura']);
    Route::get('/mantenedores/redes-hospitalarias/auth-user', [App\Http\Controllers\Mantenedores\MantenedoresList::class, 'redesHospitalariasUserAuth']);
    Route::get('/mantenedores/tipo-documentos', [App\Http\Controllers\Mantenedores\MantenedoresList::class, 'tipoDocumentos']);
    Route::get('/mantenedores/perfeccionamiento-all', [App\Http\Controllers\Mantenedores\MantenedoresList::class, 'perfeccionamientoAll']);
    Route::get('/mantenedores/grado-complejidad', [App\Http\Controllers\Mantenedores\MantenedoresList::class, 'getGradoComplejidad']);
    Route::get('/mantenedores/situaciones-actual', [App\Http\Controllers\Mantenedores\MantenedoresList::class, 'getSituacionesActual']);

    //routes admin mantenedores
    Route::get('/admin/mantenedores/establecimientos', [App\Http\Controllers\Mantenedores\MantenedoresList::class, 'adminEstablecimientos']);

    Route::post('/admin/mantenedores/red/add-red', [App\Http\Controllers\Mantenedores\MantenedoresList::class, 'addRed']);
    Route::put('/admin/mantenedores/red/edit-red/{id}', [App\Http\Controllers\Mantenedores\MantenedoresList::class, 'editRed']);

    Route::post('/admin/mantenedores/unidad/add-unidad', [App\Http\Controllers\Mantenedores\MantenedoresList::class, 'addUnidad']);
    Route::put('/admin/mantenedores/unidad/edit-unidad/{id}', [App\Http\Controllers\Mantenedores\MantenedoresList::class, 'editUnidad']);

    Route::post('/admin/mantenedores/centro/add-centro', [App\Http\Controllers\Mantenedores\MantenedoresList::class, 'addCentro']);
    Route::put('/admin/mantenedores/centro/edit-centro/{id}', [App\Http\Controllers\Mantenedores\MantenedoresList::class, 'editCentro']);

    Route::post('/admin/mantenedores/perfeccionamiento/add-perfeccionamiento', [App\Http\Controllers\Mantenedores\MantenedoresList::class, 'addPerfeccionamiento']);
    Route::put('/admin/mantenedores/perfeccionamiento/edit-perfeccionamiento/{id}', [App\Http\Controllers\Mantenedores\MantenedoresList::class, 'editPerfeccionamiento']);

    Route::get('/mantenedores/causales-admin', [App\Http\Controllers\Mantenedores\MantenedoresList::class, 'getCausalesAdmin']);
    Route::post('/admin/mantenedores/causal/add-causal', [App\Http\Controllers\Mantenedores\MantenedoresList::class, 'addCausal']);
    Route::put('/admin/mantenedores/causal/estado-causal/{id}', [App\Http\Controllers\Mantenedores\MantenedoresList::class, 'statusCausal']);
    Route::put('/admin/mantenedores/causal/edit-causal/{id}', [App\Http\Controllers\Mantenedores\MantenedoresList::class, 'editCausal']);

    Route::post('/admin/mantenedores/establecimiento/add-establecimiento', [App\Http\Controllers\Mantenedores\MantenedoresList::class, 'addEstablecimiento']);
    Route::put('/admin/mantenedores/establecimiento/edit-establecimiento/{id}', [App\Http\Controllers\Mantenedores\MantenedoresList::class, 'editEstablecimiento']);

    Route::post('/admin/mantenedores/situacion/add-situacion', [App\Http\Controllers\Mantenedores\MantenedoresList::class, 'addSituacion']);
    Route::put('/admin/mantenedores/situacion/estado-situacion/{id}', [App\Http\Controllers\Mantenedores\MantenedoresList::class, 'statusSituacion']);
    Route::put('/admin/mantenedores/situacion/edit-situacion/{id}', [App\Http\Controllers\Mantenedores\MantenedoresList::class, 'editSituacion']);
