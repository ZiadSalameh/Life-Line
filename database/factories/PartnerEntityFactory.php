<?php

namespace Database\Factories;

use App\Models\ProjectProposal;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PartnerEntity>
 */
class PartnerEntityFactory extends Factory
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
            'qualification_field_work' => fake()->text(),
            'role_responsibility' => fake()->randomElement(['Supervision', 'Implementation']),
        ];
    }
}
