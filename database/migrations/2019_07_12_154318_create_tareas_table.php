<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTareasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tareas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('visita_id')->default(0);
            $table->integer('usuario_id');
            $table->integer('usuario_crea_id');
            $table->string('nombre');
            $table->text('detalle')->nullable();
            $table->timestamp('fecha')->useCurrent();
            $table->timestamp('fecha_completada')->useCurrent();
            $table->boolean('realizado')->default(0);
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
        Schema::dropIfExists('tareas');
    }
}
