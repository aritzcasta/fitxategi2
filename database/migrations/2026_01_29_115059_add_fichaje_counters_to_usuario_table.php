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
        Schema::table('usuario', function (Blueprint $table) {
            $table->integer('llegadas_a_tiempo')->default(0)->after('faltas_sin_justificar');
            $table->integer('llegadas_tarde')->default(0)->after('llegadas_a_tiempo');
            $table->integer('ausencias')->default(0)->after('llegadas_tarde');
        });
    }

    public function down(): void
    {
        Schema::table('usuario', function (Blueprint $table) {
            $table->dropColumn(['llegadas_a_tiempo', 'llegadas_tarde', 'ausencias']);
        });
    }
};
