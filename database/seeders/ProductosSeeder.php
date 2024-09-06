<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productos = [
            'Estufa Industrial',
            'Parrilla',
            'Tamalera / Chicharronera',
            'Campana',
            'Aire Acondicionado',
            'Horno Industrial',
            'Servicios varios',
        ];

        foreach ($productos as $nombre) {
            DB::table('producto')->insert([
                'nombre' => $nombre,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
