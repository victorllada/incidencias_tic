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
        Schema::create('equipos', function (Blueprint $table) {
            $table->id();
            $table->enum('tipo_equipo', ['altavoces', 'impresora', 'monitor', 'pantalla interactiva', 'portátil de aula', 'portátil Consejería', 'proyector']);
            $table->date('fecha_adquisicion')->nullable();
            $table->char('etiqueta', 8);
            $table->string('marca', 20);
            $table->string('modelo')->nullable();
            $table->text('descripcion')->nullable();
            $table->tinyInteger('baja')->default(0);
            $table->integer('aula_id');
            $table->integer('puesto')->nullable();
            $table->timestamps();

            $table->foreign('aula_id')->references('id')->on('aulas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipos');
    }
};
