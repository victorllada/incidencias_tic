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
            CREATE TRIGGER IF NOT EXISTS asignar_rol_after_insert_user
            AFTER INSERT ON users FOR EACH ROW
            BEGIN
                -- Variables
                DECLARE usuarios_totales INT; -- Cantidad de usuarios en la tabla users. Nos indicará si es el primer login o no.
                DECLARE administrador_role_id INT; -- ID del rol administrador en la tabla roles
                DECLARE usuario_role_id INT; -- ID del rol usuario en la tabla roles
                DECLARE user_model_type VARCHAR(255); -- Espacio de nombres que será el tipo del modelo en la tabla model_has_roles

                -- Guardar el namespace del modelo de usuario
                SET user_model_type = "App\\\\Models\\\\User";

                -- Obtener el número total de usuarios
                SELECT COUNT(*) INTO usuarios_totales FROM users;

                -- Obtener los IDs de los roles por su nombre
                SELECT id INTO administrador_role_id FROM roles WHERE name = "administrador";
                SELECT id INTO usuario_role_id FROM roles WHERE name = "profesor";

                -- Asignar el rol según si es el primer login o no
                IF usuarios_totales = 1 THEN
                    INSERT INTO model_has_roles (role_id, model_type, model_id) VALUES (administrador_role_id, user_model_type, NEW.id);
                ELSE
                    INSERT INTO model_has_roles (role_id, model_type, model_id) VALUES (usuario_role_id, user_model_type, NEW.id);
                END IF;
            END;
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS asignar_rol_after_insert_user');
    }
};
