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
            'plantilla_pre_id'=>1,
            'plantilla_visita_id'=>2
        ]);
        DB::table('tipo_visitas')->insert([
            'tipo' => "Preventa",
            'plantilla_pre_id'=>1,
            'plantilla_visita_id'=>2
        ]);
        DB::table('tipo_visitas')->insert([
            'tipo' => "Soporte",
            'plantilla_pre_id'=>1,
            'plantilla_visita_id'=>2
        ]);
    }
}
