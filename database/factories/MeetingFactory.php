<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Meeting>
 */
class MeetingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'meeting_no' => fake()->unique()->numberBetween(1, 100),
            'description' => fake()->sentence(10),
            'DateTime' => fake()->dateTimeBetween('-1 week', '+1 week'),
        ];
    }
}
