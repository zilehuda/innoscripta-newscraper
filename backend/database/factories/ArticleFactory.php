<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(),
            'url' => $this->faker->url(),
            'description' => $this->faker->paragraph(),
            'author' => $this->faker->name(),
            'source' => $this->faker->company(),
            'image' => $this->faker->imageUrl(),
            'category' => $this->faker->word(),
            'published_at' => $this->faker->dateTime(),
        ];
    }
}
