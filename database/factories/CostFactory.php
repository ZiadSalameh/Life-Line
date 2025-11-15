<?php

namespace Database\Factories;

use App\Models\Element as ModelsElement;
use Dom\Element;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cost>
 */
class CostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'element_id' => ModelsElement::factory(),
            'pay_date' => $this->faker->date(),
        ];
    }
}
