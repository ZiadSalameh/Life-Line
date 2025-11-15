<?php

namespace Database\Factories;

use App\Models\Objective;
use App\Models\ProjectProposal;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Activity>
 */
class ActivityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'objective_id' => Objective::all()->random()->id,
            // 'project_proposal_id' => ProjectProposal::all()->random()->id, // الأصح
            'activity_name' => fake()->name(),
            'expected_outcome' => fake()->text(),
            'brief_project' => fake()->text(),
        ];
    }
}
