<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInterrupcionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interrupcions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique()->nullable();
            $table->date('inicio_interrupcion')->nullable();
            $table->date('termino_interrupcion')->nullable();
            $table->text('observacion')->nullable();

            $table->unsignedBigInteger('pao_id')->nullable();
            $table->foreign('pao_id')->references('id')->on('paos')->onDelete('cascade');

            $table->unsignedBigInteger('devolucion_id')->nullable();
            $table->foreign('devolucion_id')->references('id')->on('devolucions')->onDelete('cascade');

            $table->unsignedBigInteger('causal_id')->nullable();
            $table->foreign('causal_id')->references('id')->on('causals');

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
        Schema::dropIfExists('interrupcions');
    }
}
