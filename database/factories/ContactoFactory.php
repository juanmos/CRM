<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Contacto;
use App\Models\Cliente;
use Faker\Generator as Faker;

$factory->define(Contacto::class, function (Faker $faker) {
    return [
        'cliente_id'=>factory(Cliente::class),
        'nombre'=>$faker->firstName,
        'apellido'=>$faker->lastName,
        'email'=>$faker->email,
        'telefono'=>$faker->phoneNumber,
        'extension'=>'123',
        'cargo'=>'CEO',
        'ciudad_id'=>1,
        'oficina_id'=>0
    ];
});
