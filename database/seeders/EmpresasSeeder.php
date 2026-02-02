<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EmpresasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $empresas = [
            ['nombre' => 'Tech Solutions S.L.'],
            ['nombre' => 'Innovación Digital España'],
            ['nombre' => 'Construcciones del Norte'],
            ['nombre' => 'Consultoría Empresarial Asturias'],
            ['nombre' => 'Comercial Mediterránea'],
            ['nombre' => 'Logística y Transporte Ibérico'],
            ['nombre' => 'Servicios Integrales Madrid'],
            ['nombre' => 'Alimentación Gourmet S.A.'],
            ['nombre' => 'Energías Renovables Costa'],
            ['nombre' => 'Marketing y Publicidad Creativa'],
            ['nombre' => 'Distribuidora Nacional'],
            ['nombre' => 'Ingeniería y Proyectos Avanzados'],
            ['nombre' => 'Textil Moderna S.L.'],
            ['nombre' => 'Hostelería Premium'],
            ['nombre' => 'Farmacéutica del Atlántico'],
            ['nombre' => 'Tecnologías de la Información'],
            ['nombre' => 'Productos Químicos Industriales'],
            ['nombre' => 'Seguros y Finanzas Península'],
            ['nombre' => 'Educación y Formación Profesional'],
            ['nombre' => 'Inmobiliaria Urbana España'],
        ];

        $now = Carbon::now();

        foreach ($empresas as &$empresa) {
            $empresa['created_at'] = $now;
            $empresa['updated_at'] = $now;
        }

        DB::table('empresa')->insert($empresas);
    }
}
