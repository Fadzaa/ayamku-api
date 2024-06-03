<?php

namespace Database\Seeders;

use App\Models\StoreStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StoreStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $status = new StoreStatus();
        $status->is_open = true;
        $status->save();
    }
}
