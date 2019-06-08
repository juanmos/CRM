<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDatosFacturacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('datos_facturacions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('cliente_id');
            $table->string('nombre')->nullable();
            $table->string('direccion')->nullable();
            $table->string('telefono_facturacion')->nullable();
            $table->string('ruc')->nullable();
            $table->string('email')->nullable();
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
        Schema::dropIfExists('datos_facturacions');
    }
}
