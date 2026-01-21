<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::dropIfExists('practicas');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No-op: recreating the table should be done in the original migration.
    }
};
