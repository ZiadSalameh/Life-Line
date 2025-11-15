<?php

namespace Database\Factories;

use App\Models\ProjectProposal;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ActivityMonitoring>
 */
class ActivityMonitoringFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'projectproposal_id' => ProjectProposal::all()->random()->id,
            'name' => fake()->name(),
            'monitors_name' => fake()->name(),
            'date_tracking' => fake()->date(),
            'monitors_note' => fake()->text(),
            'monitroing_mechanism' => fake()->text(),

        ];
    }
}
