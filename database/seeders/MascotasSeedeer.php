<?php

namespace Database\Seeders;

use App\Models\Mascota;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MascotasSeedeer extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('mascotas')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        Mascota::create([
            'nombre' => 'Vito',
            'tipo' => 'Perro',
            'raza' => 'Chihuahua',
            'edad' => 2,
            'sexo' => 'Macho',
            'user_id' => 2
        ]);

        Mascota::create([
            'nombre' => 'Leon',
            'tipo' => 'Perro',
            'raza' => 'Pastor Aleman',
            'edad' => 1,
            'sexo' => 'Macho',
            'user_id' => 3
        ]);

        Mascota::create([
            'nombre' => 'Garfield',
            'tipo' => 'Gato',
            'raza' => 'Romano',
            'edad' => 5,
            'sexo' => 'Macho',
            'user_id' => 4
        ]);

        Mascota::create([
            'nombre' => 'Fredy Mercury',
            'tipo' => 'Ave',
            'raza' => 'Loro',
            'edad' => 2,
            'sexo' => 'Macho',
            'user_id' => 5
        ]);

        Mascota::create([
            'nombre' => 'Daga',
            'tipo' => 'Gato',
            'raza' => 'Europeo común',
            'edad' => 4,
            'sexo' => 'Hembra',
            'user_id' => 8
        ]);

        Mascota::create([
            'nombre' => 'Medusa',
            'tipo' => 'Reptil',
            'raza' => 'Boa constrictor',
            'edad' => 1,
            'sexo' => 'Hembra',
            'user_id' => 5
        ]);

        Mascota::create([
            'nombre' => 'Messi',
            'tipo' => 'Perro',
            'raza' => 'Yorkshire terrier',
            'edad' => 8,
            'sexo' => 'Macho',
            'user_id' => 8
        ]);

        Mascota::create([
            'nombre' => 'Camarón',
            'tipo' => 'Ave',
            'raza' => 'Canario',
            'edad' => 3,
            'sexo' => 'Macho',
            'user_id' => 7
        ]);

        Mascota::create([
            'nombre' => 'Nana',
            'tipo' => 'Reptil',
            'raza' => 'Camaleon',
            'edad' => 1,
            'sexo' => 'Hembra',
            'user_id' => 6
        ]);

        Mascota::create([
            'nombre' => 'Bastet',
            'tipo' => 'Gato',
            'raza' => 'Bengala',
            'edad' => 1,
            'sexo' => 'Hembra',
            'user_id' => 6
        ]);
    }
}
