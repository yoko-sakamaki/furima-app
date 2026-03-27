<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'メンズ'],
            ['name' => 'レディース'],
            ['name' => 'キッズ'],
            ['name' => 'インテリア/住まい/日用品'],
            ['name' => '本/音楽/ゲーム'],
            ['name' => 'おもちゃ/ホビー/グッズ'],
            ['name' => '家電/スマホ/カメラ'],
            ['name' => 'スポーツ/レジャー'],
            ['name' => 'ハンドメイド'],
            ['name' => 'その他'],
        ];

        DB::table('categories')->insert($categories);
    }
}