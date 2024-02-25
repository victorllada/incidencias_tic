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
        CREATE TRIGGER before_insert_user
        BEFORE INSERT ON users FOR EACH ROW
        BEGIN
            -- Almacenar temporalmente el ID del departamento encontrado
            DECLARE departamento_id bigint(20);

            -- Verificar si el campo nombre_departamento no es NULL
            IF NEW.nombre_departamento IS NOT NULL THEN
                -- Buscar el departamento en la tabla departamentos
                SELECT id INTO departamento_id FROM departamentos WHERE nombre = NEW.nombre_departamento;

                -- Si se encuentra el departamento, actualizar id_departamento en users
                IF departamento_id IS NOT NULL THEN
                    SET NEW.id_departamento = departamento_id;
                END IF;
                -- Si no se encuentra se deja a NULL (También podriamos hacer que se le asignara un departamento por defecto)
            END IF;
        END;
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS before_insert_user');
    }
};
