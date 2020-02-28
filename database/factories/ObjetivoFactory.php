<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Objetivo;
use App\Models\User;

use Faker\Generator as Faker;

$factory->define(Objetivo::class, function (Faker $faker) {
    return [
        'texto'=>'Texto',
        'fecha'=>'2020-09-09',
        'porcentaje'=>0,
        'usuario_id'=>factory(User::class)
    ];
});
