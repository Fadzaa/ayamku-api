<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->sentence,
            'description' => $this->faker->paragraph,
            'major' => $this->faker->randomElement(['Animasi 2D', 'Animasi 3D', 'PPLG', 'Teknik Grafika', 'Design Grafis']),
            'class' => $this->faker->randomElement(['10', '11', '12']),
        ];
    }
}
