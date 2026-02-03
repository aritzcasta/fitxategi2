<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Crear roles
        DB::table('rol')->insert([
            'id' => 1,
            'nombre' => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        DB::table('rol')->insert([
            'id' => 2,
            'nombre' => 'usuario',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Llamar al seeder de empresas
        $this->call([
            EmpresasSeeder::class,
        ]);
    }
}
