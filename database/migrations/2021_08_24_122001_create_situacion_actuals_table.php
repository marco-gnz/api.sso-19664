<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSituacionActualsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('situacion_actuals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('cod_sirh')->nullable();
            $table->string('nombre', 100);

            $table->unsignedBigInteger('usuario_add_id')->nullable();
            $table->foreign('usuario_add_id')->references('id')->on('users');

            $table->unsignedBigInteger('usuario_update_id')->nullable();
            $table->foreign('usuario_update_id')->references('id')->on('users');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('situacion_actuals');
    }
}
