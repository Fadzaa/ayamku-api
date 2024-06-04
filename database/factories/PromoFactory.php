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
            'discount' => $this->faker->randomDigit(),
            'is_active' => $this->faker->boolean,
            'usage_limit' => $this->faker->randomNumber(3),
            'used_count' => $this->faker->randomNumber(2),
            'image' => 'https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEgeNOJGZL4W6MsX-Dn8uOACfuANVfADL6R84Mr2nhLVO7zz4Ir6lnUZe19DO-ZwKue-SH45fnCnYBLQrborsyJx3iQKNvvxKNAeD7KHs5LncMsBUXsNqU0XOAzy4As4rqcef8HGqH4g02QI/s0/geprekbensu_1028hd.jpg',
        ];
    }
}
