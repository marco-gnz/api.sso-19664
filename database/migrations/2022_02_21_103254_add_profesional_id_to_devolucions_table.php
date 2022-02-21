<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProfesionalIdToDevolucionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('devolucions', function (Blueprint $table) {
            $table->unsignedBigInteger('profesional_id')->nullable()->after('color');
            $table->foreign('profesional_id')->references('id')->on('profesionals');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('devolucions', function (Blueprint $table) {
            $table->dropColumn('profesional_id');
        });
    }
}
