<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfesionalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profesionals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique()->nullable();
            $table->integer('rut')->unique();
            $table->string('dv', 2);
            $table->string('rut_completo')->unique();
            $table->string('nombres');
            $table->string('apellidos');
            $table->string('nombre_completo');
            $table->string('email')->unique()->nullable();
            $table->string('n_contacto')->unique()->nullable();
            $table->string('ciudad');
            $table->boolean('estado')->default(1);

            $table->unsignedBigInteger('etapas_id')->nullable();
            $table->foreign('etapas_id')->references('id')->on('etapas');

            $table->unsignedBigInteger('situacion_actual_id')->nullable();
            $table->foreign('situacion_actual_id')->references('id')->on('situacion_actuals');

            $table->unsignedBigInteger('calidad_juridica_id')->nullable();
            $table->foreign('calidad_juridica_id')->references('id')->on('calidad_juridicas');

            $table->unsignedBigInteger('planta_id')->nullable();
            $table->foreign('planta_id')->references('id')->on('plantas');

            $table->unsignedBigInteger('genero_id')->nullable();
            $table->foreign('genero_id')->references('id')->on('generos');

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
        Schema::dropIfExists('profesionals');
    }
}
