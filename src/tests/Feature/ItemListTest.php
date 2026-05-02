<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Item;
use App\Models\ConditionMaster;
use Tests\TestCase;

class ItemListTest extends TestCase
{
    use RefreshDatabase;

    // テスト用の共通データを作るメソッド
    private function createItem($userId, $isSold = false)
    {
        $condition = ConditionMaster::create(['name' => '良好']);

        return Item::create([
            'user_id' => $userId,
            'condition_id' => $condition->id,
            'name' => 'テスト商品',
            'description' => 'テスト説明',
            'price' => 1000,
            'image' => 'test.jpg',
            'is_sold' => $isSold,
        ]);
    }

    // 全商品が表示される
    public function test_all_items_are_displayed()
    {
        $user = User::create([
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
        ]);

        $this->createItem($user->id);

        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('テスト商品');
    }

    // 購入済み商品はSoldと表示される
    public function test_sold_item_displays_sold_label()
    {
        $user = User::create([
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
        ]);

        $this->createItem($user->id, true);

        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Sold');
    }

    // 自分が出品した商品は表示されない
    public function test_own_items_are_not_displayed()
    {
        $user = User::create([
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
        ]);

        $this->createItem($user->id);

        $response = $this->actingAs($user)->get('/');
        $response->assertStatus(200);
        $response->assertDontSee('テスト商品');
    }
}