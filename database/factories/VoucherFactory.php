<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Voucher>
 */
class VoucherFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => $this->faker->unique()->word,
            'name' => $this->faker->word,
            'description' => $this->faker->text,
            'discount' => $this->faker->randomNumber(),
            'qty' => $this->faker->randomNumber(),
            'start_date' => $this->faker->randomNumber(),
            'end_date' => $this->faker->randomNumber(),
        ];
    }
}
