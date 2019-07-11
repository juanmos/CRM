<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TipoVisitaPlantilla extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tipo_visitas', function (Blueprint $table) {
            $table->integer('plantilla_pre_id')->default(1);
            $table->integer('plantilla_visita_id')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tipo_visitas', function (Blueprint $table) {
            $table->dropColumn('plantilla_pre_id');
            $table->dropColumn('plantilla_visita_id');
        });
    }
}
