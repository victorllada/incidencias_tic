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
        Schema::create('perfiles', function (Blueprint $table) {
            $table->id();
            $table->integer('personal_id');
            $table->string('dominio', 15)->nullable();
            $table->string('educantabria', 50)->nullable();
            $table->char('password', 32)->nullable();
            $table->enum('perfil', ['administrador', 'profesor', 'otros'])->default('profesor');
            $table->timestamps();

            $table->foreign('personal_id')->references('id')->on('personal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perfiles');
    }
};
