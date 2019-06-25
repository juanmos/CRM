<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfiguracionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configuracions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('empresa_id');
            $table->string('min_time')->default('06:00:00');
            $table->string('max_time')->default('21:00:00');
            $table->string('scrollTime')->default('08:00:00');
            $table->string('defaultView')->default('timeGridWeek');
            $table->integer('tiempo_visita')->default(30);
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
        Schema::dropIfExists('configuracions');
    }
}
