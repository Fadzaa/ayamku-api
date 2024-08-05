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
                'name' => 'Ayam Geprek Original',
                'image' => 'https://thumbs.dreamstime.com/z/ayam-geprek-indonesian-food-crispy-fried-chicken-hot-spicy-sambal-chili-sauce-served-steam-rice-recipe-currently-found-215159621.jpg?w=768',
                'description' => 'Ayam geprek original'
            ],
            'ricebowl' => [
                'name' => 'Ricebowl BBQ',
                'image' => 'https://img.freepik.com/premium-photo/spicy-yummy-chicken-rice-bowl-with-vegetables-isolated-white-background_787273-29390.jpg',
                'description' => 'Ricebowl chicken saus bbq'
            ],
            'snack' => [
                'name' => 'Kentang Goreng',
                'image' => 'https://www.dairyqueen.com/dA/0851e38bb2/chicken_strips_fry_rings.png',
                'description' => 'Kentang goreng'
            ],
            'minuman' => [
                'name' => 'Es Teh',
                'image' => 'https://static.vecteezy.com/system/resources/previews/027/254/417/original/delicious-ice-tea-png.png',
                'description' => 'Es teh manis'
            ],
        ];


        return [
            'name' => $categoryData[$category]['name'],
            'description' => $categoryData[$category]['description'],
            'price' => $this->faker->numberBetween(10000, 20000),
            'category' => $category,
            'image' => $categoryData[$category]['image'],
        ];
    }
}
