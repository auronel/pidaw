<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsuariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('users')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        User::create([
            'dni' => '12345678A',
            'name' => 'Manuel',
            'apellidos' => 'Ramos Sánchez',
            'telefono' => '123456789',
            'email' => 'admin@admin.com',
            'password' => bcrypt('12345678')
        ]);

        User::create([
            'dni' => '11111111A',
            'name' => 'Antonio',
            'apellidos' => 'López Gutierrez',
            'telefono' => '111111111',
            'email' => 'correo1@gmail.com',
            'password' => bcrypt('12345678')
        ]);

        User::create([
            'dni' => '22222222A',
            'name' => 'Alicia',
            'apellidos' => 'Dominguez Pérez',
            'telefono' => '222222222',
            'email' => 'correo2@gmail.com',
            'password' => bcrypt('12345678')
        ]);

        User::create([
            'dni' => '33333333A',
            'name' => 'Ana',
            'apellidos' => 'Santiago Gómez',
            'telefono' => '333333333',
            'email' => 'correo3@gmail.com',
            'password' => bcrypt('12345678')
        ]);

        User::create([
            'dni' => '44444444A',
            'name' => 'Ramón',
            'apellidos' => 'López Salmerón',
            'telefono' => '444444444',
            'email' => 'correo4@gmail.com',
            'password' => bcrypt('12345678')
        ]);

        User::create([
            'dni' => '55555555A',
            'name' => 'Rubén',
            'apellidos' => 'Saiz Casado',
            'telefono' => '555555555',
            'email' => 'correo5@gmail.com',
            'password' => bcrypt('12345678')
        ]);

        User::create([
            'dni' => '66666666A',
            'name' => 'Juan Francisco',
            'apellidos' => 'García De Sousa',
            'telefono' => '666666666',
            'email' => 'correo6@gmail.com',
            'password' => bcrypt('12345678')
        ]);

        User::create([
            'dni' => '77777777A',
            'name' => 'Maria Del Carmen',
            'apellidos' => 'Barranco Barranco',
            'telefono' => '777777777',
            'email' => 'correo7@gmail.com',
            'password' => bcrypt('12345678')
        ]);

        User::create([
            'dni' => '88888888A',
            'name' => 'Antonio',
            'apellidos' => 'Fernández Fernández',
            'telefono' => '888888888',
            'email' => 'correo8@gmail.com',
            'password' => bcrypt('12345678')
        ]);

        User::create([
            'dni' => '99999999A',
            'name' => 'Luisa',
            'apellidos' => 'Ramos Torres',
            'telefono' => '999999999',
            'email' => 'correo9@gmail.com',
            'password' => bcrypt('12345678')
        ]);

        $user = User::first();

        $user->update([
            'rol' => 'Administrador'
        ]);
    }
}
