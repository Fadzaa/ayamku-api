<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Promo>
 */
class PromoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word,
            'description' => $this->faker->sentence,
            'qty' => $this->faker->randomNumber(2),
            'start_date' => $this->faker->date(),
            'end_date' => $this->faker->date(),
//            'promo_code' => $this->faker->unique()->bothify('Promo##??'),
//            'discount' => $this->faker->randomFloat(2, 1, 100),
//            'min_purchase' => $this->faker->randomFloat(2, 1, 1000),
//            'max_discount' => $this->faker->randomFloat(2, 1, 500),
//            'is_active' => $this->faker->boolean,
//            'usage_limit' => $this->faker->randomNumber(3),
//            'used_count' => $this->faker->randomNumber(2),
            'image' => $this->faker->imageUrl(),
        ];
    }
}
