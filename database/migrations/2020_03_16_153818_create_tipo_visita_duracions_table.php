<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTipoVisitaDuracionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipo_visita_duracions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('tipo_visita_id');
            $table->integer('empresa_id');
            $table->integer('duracion')->default(60);
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
        Schema::dropIfExists('tipo_visita_duracions');
    }
}
