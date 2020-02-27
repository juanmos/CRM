<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Cliente;
use App\Models\DatosFacturacion;
use Faker\Generator as Faker;

$factory->define(DatosFacturacion::class, function (Faker $faker) {
    return [
        'cliente_id'=>factory(Cliente::class),
        'nombre'=>$faker->company,
        'direccion'=>$faker->address,
        'telefono_facturacion'=>$faker->phoneNumber,
        'ruc'=>'293482948239',
        'email'=>$faker->email
    ];
});
