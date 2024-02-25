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

        $objUser->nombre_completo = 'Víctor';
        $objUser->email = 'victor@gmail.com';
        $objUser->password = bcrypt('1234');

        $objUser->save();

        $this->command->info('Tabla users inicializada con datos.');
    }
}
