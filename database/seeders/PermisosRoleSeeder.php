<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermisosRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::truncate();

        $superAdmin     = Role::create(['name' => 'SUPER-ADMIN']);
        $admin          = Role::create(['name' => 'ADMIN']);
        $auditor        = Role::create(['name' => 'AUDITOR']);


        Permission::truncate();

        //PERMISOS ORIENTADO A LAS FUNCIONALIDADES DEL SISTEMA

        //USUARIOS DEL SISTEMA
        $ingresarUser                   = Permission::create(['name' => 'ingresar-usuario']);
        $editarUser                     = Permission::create(['name' => 'editar-usuario']);
        $estadoUser                     = Permission::create(['name' => 'estado-usuario']);
        $regenerarContrasena            = Permission::create(['name' => 'regenerar-contrasena-usuario']);


        //PERMISOS ORIENTADOS A LOS MANTENEDORES (datos maestros)

        //DATOS MAESTROS
        $verDatoMaestro                 = Permission::create(['name' => 'ver-dato-maestro']);
        $ingresarDatoMaestro            = Permission::create(['name' => 'ingresar-dato-maestro']);
        $editarDatoMaestro              = Permission::create(['name' => 'editar-dato-maestro']);
        $estadoDatoMaestro              = Permission::create(['name' => 'estado-dato-maestro']);


        //PERMISOS ORIENTADO A PROFESIONALES

        //PROFESIONAL
        $verProfesional                 = Permission::create(['name' => 'ver-profesional']);
        $ingresarProfesional            = Permission::create(['name' => 'ingresar-profesional']);
        $editarProfesional              = Permission::create(['name' => 'editar-profesional']); //datos-personales
        $estadoProfesional              = Permission::create(['name' => 'estado-profesional']);
        $buscarProfesional              = Permission::create(['name' => 'buscar-profesional']);

        //FORMACIONES-PROFESIONAL
        $ingresarFormacion              = Permission::create(['name' => 'ingresar-formacion']);
        $editarFormacion                = Permission::create(['name' => 'editar-formacion']);
        $eliminarFormacion              = Permission::create(['name' => 'eliminar-formacion']);

        //PAO - CALCULO-PAO-PROFESIONAL
        $ingresarCalculoPao             = Permission::create(['name' => 'ingresar-calculo-pao']);
        $eliminarCalculoPao             = Permission::create(['name' => 'eliminar-calculo-pao']);

        //PAO - DEVOLUCION-PAO-PROFESIONAL
        $ingresarDevolucionPao          = Permission::create(['name' => 'ingresar-devolucion-pao']);
        $editarDevolucionPao            = Permission::create(['name' => 'editar-devolucion-pao']);
        $eliminarDevolucionPao          = Permission::create(['name' => 'eliminar-devolucion-pao']);

        //PAO - INTERRUPCION-PAO-PROFESIONAL
        $ingresarInterrupcionPao        = Permission::create(['name' => 'ingresar-interrupcion-pao']);
        $editarInterrupcionPao          = Permission::create(['name' => 'editar-interrupcion-pao']);
        $eliminarInterrupcionPao        = Permission::create(['name' => 'eliminar-interrupcion-pao']);


        //PERMISOS ORIENTADOS A EDF (ETAPA DESTINACIÓN Y FORMACIÓN)

        //ED
        $ingresarEtapaDestinacion       = Permission::create(['name' => 'ingresar-etapa-destinacion']);
        $editarEtapaDestinacion         = Permission::create(['name' => 'editar-etapa-destinacion']);
        $eliminarEtapaDestinacion       = Permission::create(['name' => 'eliminar-etapa-destinacion']);

        //EF
        $ingresarEtapaFormacion         = Permission::create(['name' => 'ingresar-etapa-formacion']);
        $editarEtapaFormacion           = Permission::create(['name' => 'editar-etapa-formacion']);
        $eliminarEtapaFormacion         = Permission::create(['name' => 'eliminar-etapa-formacion']);

        //DOCUMENTOS - PROFESIONAL

        //CONVENIOS
        $verConvenio                     = Permission::create(['name' => 'ver-convenio']);
        $ingresarConvenio                = Permission::create(['name' => 'ingresar-convenio']);
        $editarConvenio                  = Permission::create(['name' => 'editar-convenio']);
        $eliminarConvenio                = Permission::create(['name' => 'eliminar-convenio']);

        //ESCRITURAS
        $verEscritura                     = Permission::create(['name' => 'ver-escritura']);
        $ingresarEscritura                = Permission::create(['name' => 'ingresar-escritura']);
        $editarEscritura                  = Permission::create(['name' => 'editar-escritura']);
        $eliminarEscritura                = Permission::create(['name' => 'eliminar-escritura']);

        //OTROS DOCUMENTOS
        $verDocumento                     = Permission::create(['name' => 'ver-documento']);
        $ingresarDocumento                = Permission::create(['name' => 'ingresar-documento']);
        $editarDocumento                  = Permission::create(['name' => 'editar-documento']);
        $eliminarDocumento                = Permission::create(['name' => 'eliminar-documento']);

        //FACTURAS
        $verFactura                       = Permission::create(['name' => 'ver-factura']);
        $ingresarFactura                  = Permission::create(['name' => 'ingresar-factura']);
        $estadoFactura                    = Permission::create(['name' => 'estado-factura']);
        $eliminarFactura                  = Permission::create(['name' => 'eliminar-factura']);

        $superAdmin->syncPermissions([
            $ingresarUser,
            $editarUser,
            $estadoUser,
            $regenerarContrasena,

            $verDatoMaestro,
            $ingresarDatoMaestro,
            $editarDatoMaestro,
            $estadoDatoMaestro,

            $verProfesional,
            $ingresarProfesional,
            $editarProfesional,
            $estadoProfesional,
            $buscarProfesional,

            $ingresarFormacion,
            $editarFormacion,
            $eliminarFormacion,

            $ingresarCalculoPao,
            $eliminarCalculoPao,

            $ingresarDevolucionPao,
            $editarDevolucionPao,
            $eliminarDevolucionPao,

            $ingresarInterrupcionPao,
            $editarInterrupcionPao,
            $eliminarInterrupcionPao,

            $ingresarEtapaDestinacion,
            $editarEtapaDestinacion,
            $eliminarEtapaDestinacion,

            $ingresarEtapaFormacion,
            $editarEtapaFormacion,
            $eliminarEtapaFormacion,

            $verConvenio,
            $ingresarConvenio,
            $editarConvenio,
            $eliminarConvenio,

            $verEscritura,
            $ingresarEscritura,
            $editarEscritura,
            $eliminarEscritura,

            $verDocumento,
            $ingresarDocumento,
            $editarDocumento,
            $eliminarDocumento,

            $verFactura,
            $ingresarFactura,
            $estadoFactura,
            $eliminarFactura
        ]);

        $admin->syncPermissions([
            $verDatoMaestro,
            $ingresarDatoMaestro,
            $editarDatoMaestro,

            $verProfesional,
            $ingresarProfesional,
            $editarProfesional,
            $estadoProfesional,
            $buscarProfesional,

            $ingresarFormacion,
            $editarFormacion,

            $ingresarCalculoPao,

            $ingresarDevolucionPao,
            $editarDevolucionPao,

            $ingresarInterrupcionPao,
            $editarInterrupcionPao,

            $ingresarEtapaDestinacion,
            $editarEtapaDestinacion,

            $ingresarEtapaFormacion,
            $editarEtapaFormacion,

            $verConvenio,
            $ingresarConvenio,
            $editarConvenio,

            $verEscritura,
            $ingresarEscritura,
            $editarEscritura,

            $verDocumento,
            $ingresarDocumento,
            $editarDocumento,

            $verFactura,
            $ingresarFactura,
            $estadoFactura
        ]);

        $auditor->syncPermissions([
            $verProfesional,
            $buscarProfesional,
            $verConvenio,
            $verEscritura,
            $verDocumento,
            $verFactura
        ]);
    }
}
