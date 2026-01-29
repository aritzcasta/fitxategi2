<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('usuario', function (Blueprint $table) {
            if (! Schema::hasColumn('usuario', 'faltas_sin_justificar')) {
                $table->integer('faltas_sin_justificar')->default(0)->after('faltas_justificadas');
            }
        });
    }

    public function down()
    {
        Schema::table('usuario', function (Blueprint $table) {
            if (Schema::hasColumn('usuario', 'faltas_sin_justificar')) {
                $table->dropColumn('faltas_sin_justificar');
            }
        });
    }
};
