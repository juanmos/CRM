<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EmpresaCampos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('empresas', function (Blueprint $table) {
            $table->boolean('pruebas')->default(0)->after('activo');
            $table->date('fecha_inicio')->nullable()->after('pruebas');
            $table->date('fecha_fin_pruebas')->nullable()->after('fecha_inicio');
            $table->integer('usuarios_permitidos')->default(0)->after('fecha_fin_pruebas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('empresas', function (Blueprint $table) {
            $table->dropColumn('pruebas');
            $table->dropColumn('fecha_inicio');
            $table->dropColumn('fecha_fin_pruebas');
            $table->dropColumn('usuarios_permitidos');
        });
    }
}
