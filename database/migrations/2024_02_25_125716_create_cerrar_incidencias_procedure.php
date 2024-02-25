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
        DB::unprepared('
        CREATE PROCEDURE cerrarIncidenciasResueltas()
        BEGIN
            UPDATE incidencias
            SET estado = "cerrada"
            WHERE estado = "resuelta" AND fecha_cierre IS NOT NULL AND fecha_cierre < NOW() - INTERVAL 1 DAY;
        END;
    ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS cerrarIncidenciasResueltas');
    }
};
