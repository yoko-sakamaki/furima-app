<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            ConditionMasterSeeder::class,
            CategorySeeder::class,
            UserSeeder::class,
            ItemSeeder::class,
        ]);
    }
}