<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */
use App\Models\User;
use App\Models\Empresa;
use App\Models\Cliente;
use App\Models\DatosFacturacion;
use Faker\Generator as Faker;

$factory->define(Cliente::class, function (Faker $faker) {
    return [
        'nombre'=>$faker->company,
        'telefono'=>$faker->phoneNumber,
        'web'=>$faker->domainName,
        'activo'=>1,
        'clasificacion_id'=>1,
        'usuario_id'=>factory(User::class),
        'empresa_id'=>factory(Empresa::class),
    ];
});
