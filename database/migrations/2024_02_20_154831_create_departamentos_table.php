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
        Schema::create('departamentos', function (Blueprint $table) {
            $table->id();
            $table->char('cod', 6);
            $table->string('nombre', 45);
            $table->tinyInteger('activo')->default(1);
            $table->integer('jefedep_id')->nullable();
            $table->timestamps();

            $table->foreign('jefedep_id')->references('id')->on('personal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departamentos');
    }
};
