<?php

namespace Database\Seeders;

use App\Models\Departamento;
use App\Models\Personal;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PersonalDepartamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departamentos = Departamento::factory(10)->create();
        $personas = Personal::factory(25)->create();
        $listaPersonas = Personal::pluck('id')->toArray();

        // Actualizar departamentos 'jefedep_id'
        foreach($departamentos as $departamento) {
            $departamento->update([
                'jefedep_id' => array_shift($listaPersonas)
            ]);
        }

        // Actualizar personas 'departamento_id'
        foreach($personas as $persona) {
            $persona->update([
                'departamento_id' => Departamento::pluck('id')->random()
            ]);
        }

        $this->command->info('Tabla departamentos y personas inicializada con datos.');
    }
}
