<?php

namespace Database\Factories;

use App\Models\BoardDee;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'board_dee_id' => BoardDee::inRandomOrder()->first()?->id
                ?? BoardDee::factory()->create()->id,
            'project_no' => fake()->unique()->numberBetween(1, 100),
            'project_name' => fake()->name(),
            'start_date' => fake()->date(),
            'end_date' => fake()->date(),
            'real_start_date' => fake()->date(),
            'real_end_date' => fake()->date(),
        ];
    }
}
