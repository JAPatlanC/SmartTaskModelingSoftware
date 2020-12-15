<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
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
        DB::table('settings')->insert([
            'name' => 'MensajeFinal',
            'value' => 'Gracias por participar!',
        ]);
    }
}
