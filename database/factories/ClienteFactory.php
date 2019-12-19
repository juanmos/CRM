<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Cliente;
use Faker\Generator as Faker;

$factory->define(Cliente::class, function (Faker $faker) {
    return [
        'nombre'=>$faker->company,
        'telefono'=>$faker->phoneNumber,
        'web'=>$faker->domainName,
        'activo'=>1,
        'clasificacion_id'=>1,
        'usuario_id'=>1,
        'empresa_id'=>1
    ];
});
