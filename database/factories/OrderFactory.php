<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'cart_id' => \App\Models\Cart::factory(),
            'method_type' => $this->faker->randomElement(['on_delivery', 'pickup']),
            'posts_id' => \App\Models\Post::factory(),
            'status' => $this->faker->randomElement(['accept', 'processing', 'completed', 'cancelled']),
        ];
    }
}
