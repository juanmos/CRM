<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Configuracion;
use App\Models\Empresa;
use Faker\Generator as Faker;

$factory->define(Configuracion::class, function (Faker $faker) {
    return [
        'empresa_id'=>factory(Empresa::class),
        'min_time'=>'08:00',
        'max_time'=>'20:00',
        'scrollTime'=>'30',
        'defaultView'=>'timeGridWeek',
        'tiempo_visita'=>60
    ];
});
