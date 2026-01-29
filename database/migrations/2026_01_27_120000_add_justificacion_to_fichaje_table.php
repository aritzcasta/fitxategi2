<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('fichaje', function (Blueprint $table) {
            $table->boolean('justificado')->default(false)->after('estado');
            $table->text('justificacion')->nullable()->after('justificado');
            $table->string('justificacion_foto')->nullable()->after('justificacion');
            $table->string('justificacion_estado')->default('pending')->after('justificacion_foto');
        });
    }

    public function down()
    {
        Schema::table('fichaje', function (Blueprint $table) {
            $table->dropColumn(['justificado', 'justificacion', 'justificacion_foto', 'justificacion_estado']);
        });
    }
};
