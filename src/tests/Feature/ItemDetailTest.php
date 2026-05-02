<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Item;
use App\Models\Category;
use App\Models\ConditionMaster;
use Tests\TestCase;

class ItemDetailTest extends TestCase
{
    use RefreshDatabase;

    private function createItem($userId)
    {
        $condition = ConditionMaster::create(['name' => '良好']);
        $item = Item::create([
            'user_id' => $userId,
            'condition_id' => $condition->id,
            'name' => 'テスト商品',
            'brand' => 'テストブランド',
            'description' => 'テスト説明',
            'price' => 1000,
            'image' => 'test.jpg',
            'is_sold' => false,
        ]);

        $category = Category::create(['name' => 'テストカテゴリ']);
        $item->categories()->attach($category->id);

        return $item;
    }

    // 必要な情報が表示される
    public function test_item_detail_displays_required_information()
    {
        $user = User::create([
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
        ]);

        $item = $this->createItem($user->id);

        $response = $this->get('/item/' . $item->id);
        $response->assertStatus(200);
        $response->assertSee('テスト商品');
        $response->assertSee('テストブランド');
        $response->assertSee('1,000');
        $response->assertSee('テスト説明');
        $response->assertSee('良好');
    }

    // 複数選択されたカテゴリが表示される
    public function test_multiple_categories_are_displayed()
    {
        $user = User::create([
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
        ]);

        $condition = ConditionMaster::create(['name' => '良好']);
        $item = Item::create([
            'user_id' => $user->id,
            'condition_id' => $condition->id,
            'name' => 'テスト商品',
            'description' => 'テスト説明',
            'price' => 1000,
            'image' => 'test.jpg',
            'is_sold' => false,
        ]);

        $category1 = Category::create(['name' => 'カテゴリ1']);
        $category2 = Category::create(['name' => 'カテゴリ2']);
        $item->categories()->attach([$category1->id, $category2->id]);

        $response = $this->get('/item/' . $item->id);
        $response->assertStatus(200);
        $response->assertSee('カテゴリ1');
        $response->assertSee('カテゴリ2');
    }
}