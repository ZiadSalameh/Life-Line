<?php

namespace Database\Factories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TaskStep>
 */
class TaskStepFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'task_id' => Task::factory(),
            'step' => $this->faker->randomElement(['step_1', 'step_2', 'step_3']),
            'duration' => fake()->numberBetween(1, 20),
            'description' => fake()->text(),
            'start_date' => fake()->date(),
            'end_date' => fake()->date(),
            'real_start_date' => fake()->date(),
            'real_end_date' => fake()->date(),
        ];
    }
}
