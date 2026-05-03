<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'admin',
                'email' => 'test@example.com',
                'password' => Hash::make('password123'),
                'postal_code' => '123-4567',
                'address' => '東京都渋谷区テスト町1-1',
                'building' => 'テストビル101',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'user-buyer',
                'email' => 'test2@example.com',
                'password' => Hash::make('password123'),
                'postal_code' => '234-5678',
                'address' => '大阪府大阪市テスト区2-2',
                'building' => 'テストマンション202',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'user-preset',
                'email' => 'test3@example.com',
                'password' => Hash::make('password123'),
                'postal_code' => '345-6789',
                'address' => '愛知県名古屋市テスト区3-3',
                'building' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}