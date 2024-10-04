<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlanMantoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('plan_manto')->insert([
            [
                'id_plan_manto' => 1,
                'nombre' => 'Bimestral',
                'descripcion' => 'Especial',
                'frecuencia_mes' => 2,
            ],
            [
                'id_plan_manto' => 2,
                'nombre' => 'Trimestral',
                'descripcion' => 'AC muy contaminados',
                'frecuencia_mes' => 4,
            ],
            [
                'id_plan_manto' => 3,
                'nombre' => 'Cuatrimestral',
                'descripcion' => 'AC menos contaminados',
                'frecuencia_mes' => 3,
            ],
            [
                'id_plan_manto' => 4,
                'nombre' => 'Semestral',
                'descripcion' => 'Línea Caliente',
                'frecuencia_mes' => 6,
            ],
            [
                'id_plan_manto' => 5,
                'nombre' => 'No aplica',
                'descripcion' => 'No se requiere',
                'frecuencia_mes' => 0,
            ]
        ]);
    }
}
