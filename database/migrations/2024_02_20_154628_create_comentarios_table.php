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
        Schema::create('comentarios', function (Blueprint $table) {
            $table->id();
            $table->text('texto');
            $table->datetime('fechahora');
            $table->unsignedBigInteger('incidencia_num');
            $table->unsignedBigInteger('personal_id');
            $table->text('adjunto_url')->nullable();
            $table->timestamps();

            $table->foreign('incidencia_num')->references('id')->on('incidencias');
            $table->foreign('personal_id')->references('id')->on('personal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comentarios');
    }
};
