<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNullableColumnsToFacturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('facturas', function (Blueprint $table) {
            $table->integer('n_resolucion')->nullable()->change();
            $table->date('fecha_resolucion')->nullable()->change();
            $table->integer('n_factura')->nullable()->change();
            $table->date('fecha_emision_factura')->nullable()->change();
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
            $table->dropColumn('n_resolucion');
            $table->dropColumn('fecha_resolucion');
            $table->dropColumn('n_factura');
            $table->dropColumn('fecha_emision_factura');
        });
    }
}
