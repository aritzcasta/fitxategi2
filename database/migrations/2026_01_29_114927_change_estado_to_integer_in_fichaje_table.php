<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('fichaje', function (Blueprint $table) {
            // Cambiar el campo estado de enum a integer
            $table->dropColumn('estado');
        });

        Schema::table('fichaje', function (Blueprint $table) {
            $table->tinyInteger('estado')->nullable()->after('hora_salida')->comment('0=a tiempo, 1=tarde, 2=ausente');
        });
    }

    public function down(): void
    {
        Schema::table('fichaje', function (Blueprint $table) {
            $table->dropColumn('estado');
        });

        Schema::table('fichaje', function (Blueprint $table) {
            $table->enum('estado', ['a_tiempo', 'tarde', 'ausente'])->nullable()->after('hora_salida');
        });
    }
};
