<?php

namespace Database\Factories;

use App\Models\Meeting;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BoardDee>
 */
class BoardDeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'board_no' => fake()->numberBetween(1, 100),
            'boar_dee_date' => fake()->date(),
            'description' => fake()->text(),
            'voted' => fake()->text(),
            'meeting_id' => Meeting::all()->random()->id,
        ];
    }
}
