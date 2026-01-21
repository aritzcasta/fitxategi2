<?php

namespace Database\Seeders;

use App\Models\Usuario;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {

        DB::table('rol')->insert([
            'id' => 1,
            'nombre' => 'Administrador',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
         DB::table('rol')->insert([
            'id' => 2,
            'nombre' => 'Estudiante',
            'created_at' => now(),
            'updated_at' => now(),
        ]);



    }
}
