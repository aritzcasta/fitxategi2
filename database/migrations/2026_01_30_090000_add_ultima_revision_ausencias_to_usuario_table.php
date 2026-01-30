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
            if (! Schema::hasColumn('usuario', 'ultima_revision_ausencias')) {
                $table->date('ultima_revision_ausencias')->nullable()->after('ausencias_sin_justificar');
            }

            // Por seguridad, si falta el contador en esta BD.
            if (! Schema::hasColumn('usuario', 'ausencias_sin_justificar')) {
                $table->integer('ausencias_sin_justificar')->default(0)->after('ausencias_justificadas');
            }

            if (! Schema::hasColumn('usuario', 'ausencias_justificadas')) {
                $table->integer('ausencias_justificadas')->default(0)->after('ausencias');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('usuario', function (Blueprint $table) {
            if (Schema::hasColumn('usuario', 'ultima_revision_ausencias')) {
                $table->dropColumn('ultima_revision_ausencias');
            }
        });
    }
};
