<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCheckContabilizarPeriodoToEspecialidadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('especialidads', function (Blueprint $table) {
            $table->boolean('contabilizar_periodo')->default(1)->after('termino_formacion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('especialidads', function (Blueprint $table) {
            $table->dropColumn('contabilizar_periodo');
        });
    }
}
