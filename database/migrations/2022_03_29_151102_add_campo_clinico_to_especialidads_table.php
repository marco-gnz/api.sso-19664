<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCampoClinicoToEspecialidadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('especialidads', function (Blueprint $table) {
            $table->unsignedBigInteger('campo_clinico_id')->nullable()->after('centro_formador_id');
            $table->foreign('campo_clinico_id')->references('id')->on('campo_clinicos');
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
            $table->dropColumn('campo_clinico_id');
        });
    }
}
