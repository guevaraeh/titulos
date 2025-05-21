<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Career;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $careers = Career::pluck('id');
        $dni = fake()->numberBetween(10000000, 99999999);

        return [
            'name' => fake()->firstname() . ' ' . fake()->firstname(),
            'lastname' => fake()->lastname() . ' ' . fake()->lastname(),
            'dni' => $dni,
            'career_id' => fake()->randomElement($careers),
            'remember_token' => hash('sha256',  $dni.time()),
            //'email' => fake()->email(),
        ];
    }
}
