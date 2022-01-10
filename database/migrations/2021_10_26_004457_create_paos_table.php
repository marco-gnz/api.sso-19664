<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique()->nullable();
            $table->date('periodo_inicio')->nullable();
            $table->date('periodo_termino')->nullable();
            $table->text('observacion_periodo')->nullable();
            $table->text('observacion')->nullable();
            $table->boolean('estado')->default(1); //suspendido - activo

            $table->unsignedBigInteger('especialidad_id')->nullable();
            $table->foreign('especialidad_id')->references('id')->on('especialidads');

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
        Schema::dropIfExists('paos');
    }
}
