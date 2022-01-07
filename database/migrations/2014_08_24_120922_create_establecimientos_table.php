<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstablecimientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('establecimientos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('cod_sirh')->nullable();
            $table->string('sigla', 10);
            $table->string('nombre', 100);
            $table->text('descripcion')->nullable();

            $table->unsignedBigInteger('red_hospitalaria_id')->nullable();
            $table->foreign('red_hospitalaria_id')->references('id')->on('red_hospitalarias');

            $table->unsignedBigInteger('grado_complejidad_id')->nullable();
            $table->foreign('grado_complejidad_id')->references('id')->on('grado_complejidads');

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
        Schema::dropIfExists('establecimientos');
    }
}
