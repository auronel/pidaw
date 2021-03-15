<?php

namespace Database\Seeders;

use App\Models\Producto;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('productos')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        Producto::create([
            'nombre' => 'Pienso para Yorkshire joven',
            'descripcion' => 'Pienso seco Royal Canin para perros formulado especialmente para razas yorkshire junior.',
            'precio' => 13.66,
            'categoria' => 'Pienso',
            'foto' => 'piensoyorkshire.jpg'
        ]);

        Producto::create([
            'nombre' => 'Pienso para Pastor aleman',
            'descripcion' => 'Pienso seco Royal Canin para perros formulado especialmente para razas pastor alemán.',
            'precio' => 17.89,
            'categoria' => 'Pienso',
            'foto' => 'piensopastoraleman.jpg'
        ]);

        Producto::create([
            'nombre' => 'Pienso gatitos esterilizados',
            'descripcion' => 'Indicado para gatos de menos de un año de edad esterilizados.',
            'precio' => 18.94,
            'categoria' => 'Pienso',
            'foto' => 'gatitosesterilizados.jpg'
        ]);

        Producto::create([
            'nombre' => 'Pienso para gatos adultos',
            'descripcion' => 'Indicado para: gatos adultos a partir de 1 año - Ayuda a mantener la salud del sistema urinario.',
            'precio' => 19.82,
            'categoria' => 'Pienso',
            'foto' => 'piensogatosadultos.jpg'
        ]);

        Producto::create([
            'nombre' => 'Dentastix para perros medianos',
            'descripcion' => 'Un perfecto limpiador de dientes con una alta palatabilidad y un efecto aprobado por especialistas.',
            'precio' => 6.77,
            'categoria' => 'Golosinas y premios',
            'foto' => 'sticksdentalesparaperros.jpg'
        ]);

        Producto::create([
            'nombre' => 'Snack dental para perros',
            'descripcion' => 'Snack dental masticable muy sabroso que combate el mal aliento y ayuda a mantener la higiene oral en perros.',
            'precio' => 6.22,
            'categoria' => 'Golosinas y premios',
            'foto' => 'snackdentalparaperros.jpg'
        ]);

        Producto::create([
            'nombre' => 'Snacks Anti-Hairball para Gato',
            'descripcion' => 'Los gatos también merecen un snack como premio a su buen comportamiento o sencillamente para alegrar su día.',
            'precio' => 3.92,
            'categoria' => 'Golosinas y premios',
            'foto' => 'snacksantihairball.png'
        ]);

        Producto::create([
            'nombre' => 'Suplemento alimentario',
            'descripcion' => 'Evita las bolas de pelo y ayuda a eliminarlas. Acción laxante. Salud intestinal.',
            'precio' => 11.48,
            'categoria' => 'Golosinas y premios',
            'foto' => 'gatossuplementoalimentario.png'
        ]);

        Producto::create([
            'nombre' => 'Repelente natural',
            'descripcion' => 'Collar repelente de insectos natural apto a partir de 2 meses.',
            'precio' => 9.63,
            'categoria' => 'Antiparasitarios',
            'foto' => 'repelentenaturalperros.png'
        ]);

        Producto::create([
            'nombre' => 'Pipetas Antiparasitarias',
            'descripcion' => 'Mata y repele los cuatro parásitos más comunes: flebótomos, pulgas, garrapatas y mosquitos.',
            'precio' => 22.27,
            'categoria' => 'Antiparasitarios',
            'foto' => 'pipetasantiparasitarias.jpg'
        ]);

        Producto::create([
            'nombre' => 'Collar antiparasitario gatos',
            'descripcion' => 'Collar antiparasitario tabergat gatos. Contra parásitos externos, varios tipos de pulgas.',
            'precio' => 5.47,
            'categoria' => 'Antiparasitarios',
            'foto' => 'collarantiparasitariogatos.jpg'
        ]);

        Producto::create([
            'nombre' => 'Pipetas antiparasitarias',
            'descripcion' => 'Pipetas antiparasitarias para gato: Indicado para todo tipo de gatos.',
            'precio' => 14.66,
            'categoria' => 'Antiparasitarios',
            'foto' => 'pipetasantiparasitariasgato.jpg'
        ]);

        Producto::create([
            'nombre' => 'Mordedor Algodon',
            'descripcion' => 'Mordedor Algodon Ter Ferplast Juguete perfecto para tener a tu perro entretendio y divirtiendose.',
            'precio' => 5.95,
            'categoria' => 'Juguetes',
            'foto' => 'mordedoralgodon.jpg'
        ]);

        Producto::create([
            'nombre' => 'Juguete Gato Raptor',
            'descripcion' => 'Juguete interactivo que permite mantener al gato, entretenido y tonificado.',
            'precio' => 43.65,
            'categoria' => 'Juguetes',
            'foto' => 'juguetegatoraptor.jpg'
        ]);
    }
}
