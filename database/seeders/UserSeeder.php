<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $objUser = new User();

        $objUser->name = 'daw999';
        $objUser->nombre_completo = 'Pepe';
        $objUser->email = 'pepe@gmail.com';
        $objUser->password = bcrypt('1234');
        $objUser->nombre_departamento = 'Informática';

        $objUser->save();

        $this->command->info('Tabla users inicializada con datos.');
    }
}
