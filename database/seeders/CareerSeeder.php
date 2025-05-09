<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Career;

class CareerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Career::factory()->create([
            'name' => 'Construcción Civil',
        ]);

        Career::factory()->create([
            'name' => 'Contabilidad',
        ]);

        Career::factory()->create([
            'name' => 'Desarrollo de Sistemas de información',
        ]);

        Career::factory()->create([
            'name' => 'Electricidad Industrial',
        ]);

        Career::factory()->create([
            'name' => 'Electronica Industrial',
        ]);

        Career::factory()->create([
            'name' => 'Mecánica de Producción Industrial',
        ]);

        Career::factory()->create([
            'name' => 'Mecatrónica Automotriz',
        ]);

        Career::factory()->create([
            'name' => 'Producción Agropecuaria',
        ]);

        Career::factory()->create([
            'name' => 'Asistencia Administrativa',
        ]);
    }
}
