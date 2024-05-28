<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //unique food name
            'name' => $this->faker->unique()->word,
            'description' => $this->faker->sentence,
            'price' => $this->faker->randomFloat(2, 1, 100),
            'category' => $this->faker->randomElement(['geprek', 'ricebowl', 'snack', 'minuman']),
            'stock' => $this->faker->numberBetween(0, 100),
            'image' => $this->faker->imageUrl(),
        ];
    }
}
