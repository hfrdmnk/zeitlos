<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Entry>
 */
class EntryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'date' => $this->faker->unique()->dateTimeBetween('-3 year', 'now')->format('Y-m-d'),
            'story' => $this->faker->paragraphs(3, true),
            'mood' => $this->faker->numberBetween(1, 5),
        ];
    }
}
