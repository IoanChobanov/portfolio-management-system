<?php

namespace Database\Factories;

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
    $status = fake()->randomElement(['idea', 'in_progress', 'completed', 'on_hold']);

    $startedAt = fake()->dateTimeBetween('-2 years', '-1 month');

    $finishedAt = null;
    if ($status === 'completed') {
        $finishedAt = fake()->dateTimeBetween($startedAt, 'now');
    }

    return [
        'title' => fake()->unique()->sentence(rand(2, 4)),
        'slug' => fake()->unique()->slug(),        
        'description' => fake()->paragraph(3),
        'started_at' => $startedAt,
        'finished_at' => $finishedAt, 
        'status' => $status,
        
    ];
}
}
