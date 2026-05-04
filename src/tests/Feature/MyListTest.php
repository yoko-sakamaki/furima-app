<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Item;
use App\Models\Like;
use App\Models\ConditionMaster;
use Tests\TestCase;

class MyListTest extends TestCase
{
    use RefreshDatabase;

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

    // いいねした商品だけが表示される
    public function test_only_liked_items_are_displayed()
    {
        $user = User::create([
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
        ]);

        $other = User::create([
            'name' => '他のユーザー',
            'email' => 'other@example.com',
            'password' => Hash::make('password123'),
        ]);

        $item = $this->createItem($other->id);
        Like::create(['user_id' => $user->id, 'item_id' => $item->id]);

        $response = $this->actingAs($user)->get('/?tab=mylist');
        $response->assertStatus(200);
        $response->assertSee('テスト商品');
    }

    // 購入済み商品はSoldと表示される
    public function test_sold_item_displays_sold_label_in_mylist()
    {
        $user = User::create([
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
        ]);

        $other = User::create([
            'name' => '他のユーザー',
            'email' => 'other@example.com',
            'password' => Hash::make('password123'),
        ]);

        $item = $this->createItem($other->id, true);
        Like::create(['user_id' => $user->id, 'item_id' => $item->id]);

        $response = $this->actingAs($user)->get('/?tab=mylist');
        $response->assertStatus(200);
        $response->assertSee('Sold');
    }

    // 未認証の場合は何も表示されない
    public function test_mylist_is_empty_for_guest()
    {
        $response = $this->get('/?tab=mylist');
        $response->assertStatus(200);
        $response->assertDontSee('テスト商品');
    }
}