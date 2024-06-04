<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserVoucher;
use App\Models\Voucher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserVoucherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all users and vouchers
        $users = User::all();
        $vouchers = Voucher::all();

        // For each user, assign a random voucher
        foreach ($users as $user) {
            $voucher = $vouchers->random();

            // Create a new UserVoucher
            $userVoucher = new UserVoucher();
            $userVoucher->user_id = $user->id;
            $userVoucher->voucher_id = $voucher->id;
            $userVoucher->used = false;
            $userVoucher->save();
        }
    }
}
