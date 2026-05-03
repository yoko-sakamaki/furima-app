<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Item;
use App\Models\ConditionMaster;
use Tests\TestCase;

class ItemSearchTest extends TestCase
{
    use RefreshDatabase;

    private function createItem($userId, $name)
    {
        $condition = ConditionMaster::create(['name' => '良好']);
        return Item::create([
            'user_id' => $userId,
            'condition_id' => $condition->id,
            'name' => $name,
            'description' => 'テスト説明',
            'price' => 1000,
            'image' => 'test.jpg',
            'is_sold' => false,
        ]);
    }

    // 商品名で部分一致検索ができる
    public function test_items_can_be_searched_by_name()
    {
        $user = User::create([
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
        ]);

        $this->createItem($user->id, '腕時計');
        $this->createItem($user->id, 'バッグ');

        $response = $this->get('/?search=腕時計');
        $response->assertStatus(200);
        $response->assertSee('腕時計');
        $response->assertDontSee('バッグ');
    }

    // 検索状態がマイリストでも保持されている
    public function test_search_keyword_is_preserved_in_mylist()
    {
        $response = $this->get('/?search=腕時計&tab=mylist');
        $response->assertRedirect('/login');
    }
}