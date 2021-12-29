<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDevolucionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devolucions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique()->nullable();
            $table->date('inicio_devolucion')->nullable();
            $table->date('termino_devolucion')->nullable();
            $table->text('observacion')->nullable();
            $table->string('color');

            $table->unsignedBigInteger('tipo_contrato')->nullable();
            $table->foreign('tipo_contrato')->references('id')->on('tipo_contratos');

            $table->unsignedBigInteger('pao_id')->nullable();
            $table->foreign('pao_id')->references('id')->on('paos')->onDelete('cascade');

            $table->unsignedBigInteger('establecimiento_id')->nullable();
            $table->foreign('establecimiento_id')->references('id')->on('establecimientos');

            $table->unsignedBigInteger('escritura_id')->nullable();
            $table->foreign('escritura_id')->references('id')->on('escrituras');

            $table->unsignedBigInteger('usuario_add_id')->nullable();
            $table->foreign('usuario_add_id')->references('id')->on('users');
            $table->dateTime('fecha_add', 0)->nullable();

            $table->unsignedBigInteger('usuario_update_id')->nullable();
            $table->foreign('usuario_update_id')->references('id')->on('users');
            $table->dateTime('fecha_update', 0)->nullable();

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
        Schema::dropIfExists('devolucions');
    }
}
