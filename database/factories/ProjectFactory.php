<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Project>
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
        $title = $this->faker->sentence(4);

        return [
            'title' => $title,
            'slug' => str()->slug($title).'-'.$this->faker->unique()->numberBetween(1, 100000),
            'pole' => $this->faker->randomElement(['conseil', 'communication', 'marketing', 'solutions', 'ilepay']),
            'client' => $this->faker->company(),
            'sector' => $this->faker->word(),
            'challenge' => $this->faker->paragraph(),
            'solution' => $this->faker->paragraph(),
            'results' => $this->faker->sentence(),
            'is_featured' => $this->faker->boolean(),
        ];
    }
}
