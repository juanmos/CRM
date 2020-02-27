<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\NotaCliente;
use App\Models\Cliente;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(NotaCliente::class, function (Faker $faker) {
    return [
        'cliente_id'=>factory(Cliente::class),
        'nota'=>$faker->word,
        'usuario_id'=>factory(User::class)
    ];
});
