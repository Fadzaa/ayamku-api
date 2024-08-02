<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            ProductSeeder::class,
            PromoSeeder::class,
            PostSeeder::class,
            VoucherSeeder::class,
//            CartSeeder::class,
//            CartItemSeeder::class,
            AdminUserSeeder::class,
//            FavouriteFoodSeeder::class,
            StoreStatusSeeder::class,
//            OrderSeeder::class,
            UserVoucherSeeder::class
        ]);
    }
}
