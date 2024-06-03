<?php

namespace Database\Seeders;

use App\Models\FavouriteFood;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FavouriteFoodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $favouriteFoods = [
            [
                'user_id' => 1,
                'product_id' => 1,
            ],
            [
                'user_id' => 1,
                'product_id' => 2,
            ],
            [
                'user_id' => 2,
                'product_id' => 3,
            ],
            [
                'user_id' => 2,
                'product_id' => 4,
            ],
        ];

        foreach ($favouriteFoods as $favouriteFood) {
            $food = new FavouriteFood();
            $food->fill($favouriteFood);
            $food->save();
        }
    }
}
