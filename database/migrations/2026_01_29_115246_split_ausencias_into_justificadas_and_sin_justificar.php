<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('usuario', function (Blueprint $table) {
            $table->integer('ausencias_justificadas')->default(0)->after('ausencias');
            $table->integer('ausencias_sin_justificar')->default(0)->after('ausencias_justificadas');
        });

        // Migrar datos existentes: todas las ausencias actuales pasan a ser sin justificar
        DB::statement('UPDATE usuario SET ausencias_sin_justificar = ausencias WHERE ausencias > 0');
    }

    public function down(): void
    {
        // Revertir: sumar justificadas y sin justificar de vuelta a ausencias
        DB::statement('UPDATE usuario SET ausencias = ausencias_justificadas + ausencias_sin_justificar WHERE ausencias_justificadas > 0 OR ausencias_sin_justificar > 0');

        Schema::table('usuario', function (Blueprint $table) {
            $table->dropColumn(['ausencias_justificadas', 'ausencias_sin_justificar']);
        });
    }
};
