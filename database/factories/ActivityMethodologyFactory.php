<?php

namespace Database\Factories;

use App\Models\ProjectProposal;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ActivityMethodology>
 */
class ActivityMethodologyFactory extends Factory
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
            'activity_methodology_name' => fake()->name(),
            'proposed_implementation_period' => fake()->date(),
            'logistical_requirements' => fake()->text(),
            'outputs' => fake()->text(),
            
        ];
    }
}
