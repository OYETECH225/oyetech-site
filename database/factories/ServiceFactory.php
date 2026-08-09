<?php

namespace Database\Factories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Service>
 */
class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->words(3, true);

        return [
            'name' => $name,
            'slug' => str()->slug($name).'-'.$this->faker->unique()->numberBetween(1, 100000),
            'pole' => $this->faker->randomElement(['conseil', 'communication', 'marketing', 'solutions', 'ilepay']),
            'summary' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'deliverables' => $this->faker->words(4),
            'order' => $this->faker->numberBetween(0, 10),
            'is_active' => true,
        ];
    }
}
