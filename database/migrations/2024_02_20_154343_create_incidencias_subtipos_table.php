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
        Schema::create('incidencias_subtipos', function (Blueprint $table) {
            $table->id();
            $table->enum('tipo', ['EQUIPOS', 'CUENTAS', 'WIFI', 'INTERNET', 'SOFTWARE']);
            $table->string('subtipo_nombre', 20)->nullable();
            $table->string('sub_subtipo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incidencias_subtipos');
    }
};
