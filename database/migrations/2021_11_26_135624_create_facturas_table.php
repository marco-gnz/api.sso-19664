<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facturas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('uuid')->unique()->nullable();
            $table->integer('n_resolucion')->unique();
            $table->date('fecha_resolucion');
            $table->integer('n_factura')->unique();
            $table->date('fecha_emision_factura');
            $table->date('fecha_vencimiento_factura')->nullable();
            $table->string('cargo_item')->nullable();
            $table->text('anios_pago');
            $table->decimal('monto_total', 10, 0)->nullable();
            $table->text('observacion')->nullable();

            $table->unsignedBigInteger('profesional_id')->nullable();
            $table->foreign('profesional_id')->references('id')->on('profesionals');

            $table->unsignedBigInteger('tipo_contrado_id')->nullable();
            $table->foreign('tipo_contrado_id')->references('id')->on('tipo_contratos');


            $table->unsignedBigInteger('situacion_factura_id')->nullable();
            $table->foreign('situacion_factura_id')->references('id')->on('situacion_facturas');

            $table->unsignedBigInteger('convenio_id')->nullable();
            $table->foreign('convenio_id')->references('id')->on('convenios');

            $table->unsignedBigInteger('centro_formador_id')->nullable();
            $table->foreign('centro_formador_id')->references('id')->on('centro_formadors');

            $table->unsignedBigInteger('red_hospitalaria_id')->nullable();
            $table->foreign('red_hospitalaria_id')->references('id')->on('red_hospitalarias');

            $table->unsignedBigInteger('perfeccionamiento_id')->nullable();
            $table->foreign('perfeccionamiento_id')->references('id')->on('perfeccionamientos');

            $table->ipAddress('ip_user_add')->nullable();
            $table->unsignedBigInteger('usuario_add_id')->nullable();
            $table->foreign('usuario_add_id')->references('id')->on('users');
            $table->dateTime('fecha_add', 0)->nullable();

            $table->ipAddress('ip_user_update')->nullable();
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
        Schema::dropIfExists('facturas');
    }
}
