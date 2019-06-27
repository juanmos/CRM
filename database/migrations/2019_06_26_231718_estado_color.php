<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EstadoColor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('estado_visitas', function (Blueprint $table) {
            $table->string('color')->default('#2C3E50');
            $table->string('textColor')->default('#fff');
            $table->string('icono')->default('fa fa-eye');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('estado_visitas', function (Blueprint $table) {
            $table->dropColumn('color');
            $table->dropColumn('textColor');
            $table->dropColumn('icono');
        });
    }
}
