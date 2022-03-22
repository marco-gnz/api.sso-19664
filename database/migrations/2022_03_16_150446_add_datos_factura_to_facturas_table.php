<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDatosFacturaToFacturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('facturas', function (Blueprint $table) {
            $table->integer('n_resolucion_convenio')->nullable()->after('fecha_resolucion');
            $table->date('fecha_convenio')->nullable()->after('n_resolucion_convenio');
            $table->boolean('envio_finanza')->default(0)->after('fecha_convenio');
            $table->date('fecha_pago')->nullable()->after('envio_finanza');
            $table->date('anio_academico')->nullable()->after('fecha_pago');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('facturas', function (Blueprint $table) {
            $table->dropColumn('n_resolucion_convenio');
            $table->dropColumn('fecha_convenio');
            $table->dropColumn('envio_finanza');
            $table->dropColumn('fecha_pago');
            $table->dropColumn('anio_academico');
        });
    }
}
