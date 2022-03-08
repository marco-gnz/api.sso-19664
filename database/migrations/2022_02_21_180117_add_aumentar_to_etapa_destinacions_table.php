<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAumentarToEtapaDestinacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('etapa_destinacions', function (Blueprint $table) {
            $table->boolean('aumentar')->default(0)->after('termino_periodo');
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
        Schema::table('etapa_destinacions', function (Blueprint $table) {
            $table->dropColumn('aumentar');
            $table->dropColumn('aumentar_observacion');
        });
    }
}
