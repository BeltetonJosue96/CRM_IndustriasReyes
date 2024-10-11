<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmpresaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $empresas = [
            'Naturaceites S.A.',
            'INTECAP',
            'Antojitos Dana',
            'Pollo Granjero',
            'Pollo Express',
            'Gauchitos',
            'Parrillada El Gordo',
            'Parrillada Don Milo',
            'Comedor Yolanda',
            'Restaurante Puerto Madero',
            'Hotel Puerto Bello',
            'Restaurante Marbella',
            'Comedor La Bahía',
            'Toro Gordo',
            'Rest El Ancla',
            'Casa Santorini',
            'Hotel Mar Brisa',
            'Hotel Posada Don Diego',
            'Tortillas El Inde',
            'Rest Tajamar',
            'Beach Burger',
            'Sushi Kito',
            'Rest El Safari',
            'Maxim Express',
            'Que Dely',
            'Pollo Landia',
            'Xiomaras Cafe'
        ];

        foreach ($empresas as $empresa) {
            DB::table('empresa')->insert([
                'nombre' => $empresa,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
