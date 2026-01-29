<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('usuario', function (Blueprint $table) {
            $table->integer('faltas_justificadas')->default(0)->after('veces_registradas');
        });
    }

    public function down()
    {
        Schema::table('usuario', function (Blueprint $table) {
            $table->dropColumn('faltas_justificadas');
        });
    }
};
