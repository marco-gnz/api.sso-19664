<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNResolucionToEscriturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('escrituras', function (Blueprint $table) {
            $table->dropUnique(['n_resolucion']);
            $table->dropUnique(['n_repertorio']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('escrituras', function (Blueprint $table) {
            $table->dropUnique(['n_resolucion']);
            $table->dropUnique(['n_repertorio']);
        });
    }
}
