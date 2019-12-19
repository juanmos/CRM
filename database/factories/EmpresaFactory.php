<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Empresa;
use Faker\Generator as Faker;

$factory->define(Empresa::class, function (Faker $faker) {
    return [
        'nombre'=>$faker->company,
        'ruc'=>$faker->shuffle('1234567890001'),
        'direccion'=>$faker->address,
        'telefono'=>$faker->phoneNumber,
        'costo'=>30,
        'ciudad_id'=>1,
        'activo'=>1,
        'pruebas'=>0
    ];
});
