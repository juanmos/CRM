<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Visita;
use App\Models\Cliente;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Visita::class, function (Faker $faker) {
    return [
        'cliente_id'=>factory(Cliente::class),
        'usuario_id'=>factory(User::class),
        'contacto_id'=>1,
        'tipo_visita_id'=>$faker->randomElement([1,2,3]),
        'estado_visita_id'=>$faker->randomElement([1,2,3,4,5,6]),
        'fecha_inicio'=> now()->toDateTimeString(),
        'fecha_fin'=> now()->toDateTimeString(),
        'codigo'=>$faker->word,
        'descripcion'=>$faker->sentence(5),

    ];
});
