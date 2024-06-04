<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserVoucher>
 */
class UserVoucherFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'voucher_id' => $this->faker->randomElement(\App\Models\Voucher::all()->pluck('id')->toArray()),
            'user_id' => $this->faker->randomElement(\App\Models\User::all()->pluck('id')->toArray()),
            'status' => $this->faker->randomElement(['active', 'used', 'expired']),
            'is_redeemed' => $this->faker->boolean(),
        ];
    }
}
