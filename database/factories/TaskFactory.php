<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'task_name' => fake()->name(),
            'duration' => fake()->numberBetween(1, 10),
            'responsible' => fake()->name(),
            'description' => fake()->text(),
            'start_date' => fake()->date(),
            'end_date' => fake()->date(),
            'real_start_date' => fake()->date(),
            'real_end_date' => fake()->date(),
            'project_id' => Project::inRandomOrder()->first()?->id
                ?? Project::factory()->create()->id,
        ];
    }
}
