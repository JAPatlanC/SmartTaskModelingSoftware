<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('settings')->insert([
            'name' => 'MensajeInicial',
            'value' => 'Bienvenidos al formulario FAEN',
        ]);
        DB::table('settings')->insert([
            'name' => 'TiempoEncuesta',
            'value' => '45',
        ]);
    }
}
