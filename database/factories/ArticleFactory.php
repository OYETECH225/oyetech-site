<?php

namespace Database\Factories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->sentence(6);

        return [
            'title' => $title,
            'slug' => str()->slug($title).'-'.$this->faker->unique()->numberBetween(1, 100000),
            'category' => $this->faker->randomElement(['Innovation', 'Fintech', 'Marketing', 'Stratégie']),
            'excerpt' => $this->faker->sentence(),
            'content' => '<p>'.$this->faker->paragraph().'</p>',
            'is_published' => false,
        ];
    }
}
