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
        $category = $this->faker->randomElement(['geprek', 'ricebowl', 'snack', 'minuman']);

        $categoryData = [
            'geprek' => [
                'name' => 'Geprek Sample',
                'image' => 'https://png.pngtree.com/png-clipart/20230319/original/pngtree-sweet-cheese-geprek-chicken-png-image_8995918.png',
            ],
            'ricebowl' => [
                'name' => 'Ricebowl Sample',
                'image' => 'https://img.freepik.com/premium-photo/spicy-yummy-chicken-rice-bowl-with-vegetables-isolated-white-background_787273-29390.jpg',
            ],
            'snack' => [
                'name' => 'Snack',
                'image' => 'https://www.dairyqueen.com/dA/0851e38bb2/chicken_strips_fry_rings.png',
            ],
            'minuman' => [
                'name' => 'Minuman',
                'image' => 'https://static.vecteezy.com/system/resources/previews/027/254/417/original/delicious-ice-tea-png.png',
            ],
        ];


        return [
            'name' => $categoryData[$category]['name'],
            'description' => $this->faker->sentence,
            'price' => $this->faker->numberBetween(10000, 20000),
            'category' => $category,
            'image' => $categoryData[$category]['image'],
        ];
    }
}
