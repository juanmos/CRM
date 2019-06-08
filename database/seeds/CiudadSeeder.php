<?php

use Illuminate\Database\Seeder;

class CiudadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ciudads')->insert([
            'ciudad' => "Guayaquil",
        ]);
        DB::table('ciudads')->insert([
            'ciudad' => "Quito",
        ]);
        DB::table('ciudads')->insert([
            'ciudad' => "Cuenca",
        ]);
        DB::table('ciudads')->insert([
            'ciudad' => "Manta",
        ]);
        DB::table('ciudads')->insert([
            'ciudad' => "Portoviejo",
        ]);
    }
}
