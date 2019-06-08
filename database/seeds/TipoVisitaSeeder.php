<?php

use Illuminate\Database\Seeder;

class TipoVisitaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipo_visitas')->insert([
            'tipo' => "Venta",
        ]);
        DB::table('tipo_visitas')->insert([
            'tipo' => "Preventa",
        ]);
        DB::table('tipo_visitas')->insert([
            'tipo' => "Soporte",
        ]);
    }
}
