<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEspecialidadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('especialidads', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique()->nullable();
            $table->date('fecha_registro')->nullable();
            $table->date('inicio_formacion')->nullable();
            $table->date('termino_formacion')->nullable();
            $table->text('observacion')->nullable();
            $table->enum('origen',['EDF','PAO', 'OTROS'])->nullable()->default('PAO');

            $table->unsignedBigInteger('profesional_id')->nullable();
            $table->foreign('profesional_id')->references('id')->on('profesionals');

            $table->unsignedBigInteger('centro_formador_id')->nullable();
            $table->foreign('centro_formador_id')->references('id')->on('centro_formadors');

            $table->unsignedBigInteger('perfeccionamiento_id')->nullable();
            $table->foreign('perfeccionamiento_id')->references('id')->on('perfeccionamientos');

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
        Schema::dropIfExists('especialidads');
    }
}
