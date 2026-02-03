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
        // Crear roles
        DB::table('rol')->updateOrInsert(
            ['id' => 1],
            [
                'nombre' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        DB::table('rol')->updateOrInsert(
            ['id' => 2],
            [
                'nombre' => 'usuario',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // Crear usuario administrador
        Usuario::updateOrCreate(
            ['email' => 'admin@admin'],
            [
                'nombre' => 'Admin User',
                'password' => Hash::make('12345678'),
                'email_verified_at' => now(),
                'rol_id' => 1,
                'fecha_ini' => Carbon::now(),
                'activo' => 1,
            ]
        );

        // Crear usuario estudiante
        Usuario::updateOrCreate(
            ['email' => 'estudiante@fitxategi.com'],
            [
                'nombre' => 'Estudiante Demo',
                'password' => Hash::make('password'),
                'rol_id' => 2,
                'fecha_ini' => Carbon::now(),
                'activo' => 1,
            ]
        );

        // Llamar al seeder de empresas
        $this->call([
            EmpresasSeeder::class,
        ]);
    }
}
