<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Technology>
 */
class TechnologyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $techs = [
            'PHP', 'Laravel', 'JavaScript', 'Vue.js', 'React', 'Tailwind CSS', 
            'MySQL', 'Redis', 'Docker', 'AWS', 'Python', 'Figma'
        ];

        return [
            'name' => fake()->unique()->randomElement($techs),
        ];
    }
}
