<?php

use Illuminate\Database\Seeder;

class EstadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('estado_visitas')->insert([
            'estado' => "Creado",
        ]);
        DB::table('estado_visitas')->insert([
            'estado' => "Confirmada",
        ]);
        DB::table('estado_visitas')->insert([
            'estado' => "En camino",
        ]);
        DB::table('estado_visitas')->insert([
            'estado' => "En cliente",
        ]);
        DB::table('estado_visitas')->insert([
            'estado' => "Terminada",
        ]);
        DB::table('estado_visitas')->insert([
            'estado' => "Cancelada",
        ]);
    }
}
