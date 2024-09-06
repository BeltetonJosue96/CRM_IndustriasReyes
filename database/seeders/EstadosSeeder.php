<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstadosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $estados = [
            'Pendiente',
            'Programado',
            'Reprogramado',
            'Rechazado',
        ];

        foreach ($estados as $estado) {
            DB::table('estado')->insert([
                'estado' => $estado,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
