<?php

namespace Database\Seeders;

use App\Models\Usuario;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {

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

        Usuario::create([
            'nombre' => 'Admin User',
            'email' => 'admin@fitxategi.com',
            'password' => Hash::make('password'),
            'rol_id' => 1,
            'fecha_ini'=>Carbon::now(),
            'activo' => 1,
        ]);

        // Crear usuario profesor


        // Crear usuario estudiante
        Usuario::create([
            'nombre' => 'Estudiante Demo',
            'email' => 'estudiante@fitxategi.com',
            'password' => Hash::make('password'),
            'rol_id' => 2,
            'fecha_ini'=>Carbon::now(),


            'activo' => 1,
        ]);



    }
}
