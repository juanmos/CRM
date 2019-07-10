<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlantillaDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plantilla_detalles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('plantilla_id');
            $table->string('label');
            $table->integer('tipo_campo')->default(1);
            $table->integer('orden')->default(1);
            $table->string('valor_defecto')->nullable();
            $table->string('opciones')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plantilla_detalles');
    }
}
