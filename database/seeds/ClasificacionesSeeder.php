<?php

use Illuminate\Database\Seeder;

class ClasificacionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('clasificacions')->insert([
            'clasificacion' => "Normal",
        ]);
        DB::table('clasificacions')->insert([
            'clasificacion' => "Vip",
        ]);
        DB::table('clasificacions')->insert([
            'clasificacion' => "Premium",
        ]);
        
    }
}
