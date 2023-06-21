<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UbigeoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $data = [
            ['ubig_cod' => '210101', 'ubig_departamento' => 'Puno', 'ubig_provincia' => 'Puno', 'ubig_distrito' => 'Puno'],
            ['ubig_cod' => '210102', 'ubig_departamento' => 'Puno', 'ubig_provincia' => 'Puno', 'ubig_distrito' => 'Juliaca'],
            ['ubig_cod' => '210103', 'ubig_departamento' => 'Puno', 'ubig_provincia' => 'Puno', 'ubig_distrito' => 'Ayaviri'],
            ['ubig_cod' => '210104', 'ubig_departamento' => 'Puno', 'ubig_provincia' => 'Puno', 'ubig_distrito' => 'Ilave'],
            ['ubig_cod' => '210105', 'ubig_departamento' => 'Puno', 'ubig_provincia' => 'Puno', 'ubig_distrito' => 'Azángaro'],
            ['ubig_cod' => '210106', 'ubig_departamento' => 'Puno', 'ubig_provincia' => 'Puno', 'ubig_distrito' => 'Macusani'],
            // Agrega más datos para otros distritos de Puno
            
            ['ubig_cod' => '210150', 'ubig_departamento' => 'Puno', 'ubig_provincia' => 'El Collao', 'ubig_distrito' => 'Capazo'],
            ['ubig_cod' => '210151', 'ubig_departamento' => 'Puno', 'ubig_provincia' => 'El Collao', 'ubig_distrito' => 'Pisacoma'],
            ['ubig_cod' => '210152', 'ubig_departamento' => 'Puno', 'ubig_provincia' => 'El Collao', 'ubig_distrito' => 'Zepita'],
            ['ubig_cod' => '210153', 'ubig_departamento' => 'Puno', 'ubig_provincia' => 'El Collao', 'ubig_distrito' => 'Kelluyo'],
            ['ubig_cod' => '210154', 'ubig_departamento' => 'Puno', 'ubig_provincia' => 'El Collao', 'ubig_distrito' => 'Pomata'],
            // Agrega más datos para otros distritos de Puno
            
            // Continúa agregando más datos hasta completar los 50 registros
        ];
        
        DB::table('ubigeos')->insert($data);
        
    }
}
