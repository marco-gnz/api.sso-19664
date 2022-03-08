<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAumentarToEspecialidadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('especialidads', function (Blueprint $table) {
            $table->boolean('aumentar')->default(0)->after('termino_formacion');
            $table->text('aumentar_observacion')->nullable()->after('aumentar');
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
            $table->dropColumn('aumentar');
            $table->dropColumn('aumentar_observacion');
        });
    }
}
