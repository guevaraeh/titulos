<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use Illuminate\Support\Facades\DB;
use App\Models\TitulationCertificate;
use App\Models\Students;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TitulationCertificate>
 */
class TitulationCertificateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = fake()->numberBetween(0, 1);
        
        return [
            'type' => $type,
            'project_name' => $type == 0 ? fake()->sentence() : null,
            'remarks' => fake()->paragraph(),
            'certificate_date' => fake()->dateTimeBetween('-100 days', '+100 days'),
            'remember_token' => hash('sha256',  time().rand())
        ];
    }

    public function configure(): static
    {   
        return $this->afterCreating(function (TitulationCertificate $titulationCertificate) {
            $students = DB::table('students')->pluck('id')->toArray();
            $lps = fake()->numberBetween(1, 3);
            for ($i=0; $i < $lps; $i++)
                $titulationCertificate->students()->attach($students[fake()->numberBetween(0, count($students))]);
        });
    }
}
